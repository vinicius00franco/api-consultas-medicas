<?php

namespace App\Service;

use App\Entity\Beneficiario;
use App\Entity\Consulta;
use App\Entity\Hospital;
use App\Entity\Medico;
use App\Repository\Pattern\ConsultaRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Service\Validation\ConsultaValidator;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ConsultaService
{
    private $consultaRepository;
    private $entityManager;
    private $serializer;
    private $normalizer;
    private $consultaValidator;

    public function __construct(
        ConsultaRepositoryInterface $consultaRepository,
        EntityManagerInterface $entityManager,
        NormalizerInterface $normalizer,
        SerializerInterface $serializer,
        ConsultaValidator $consultaValidator
    ) {
        $this->consultaRepository = $consultaRepository;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
        $this->consultaValidator = $consultaValidator;
    }

    public function getAllConsultas(): array
    {
        $consultas = $this->consultaRepository->findAll();

        return $this->normalizer->normalize(
            $this->formatDataConsulta($consultas),
            null,
            [
                'groups' => ['consulta', 'beneficiario', 'medico'],
                'circular_reference_handler' => function ($object) {
                    return $object->getId(); // Retorna o ID do objeto para evitar referência circular
                },
                'skip_uninitialized_values' => true,
                'preserve_empty_objects' => true,
            ]
        );
    }

    public function getConsultaById(Consulta $consulta): ?array
    {
        $consulta = $this->consultaRepository->findById($consulta);

        if (!$consulta) {
            throw new NotFoundHttpException('Consulta não encontrada.');
        }

        $medico = $consulta->getMedico();
        $this->entityManager->initializeObject($medico);
        $this->verificarEspecialidade($medico);

        return $this->normalizer->normalize(
            $consulta,
            null,
            [
                'groups' => ['consulta', 'beneficiario', 'medico'],
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                },
            ]
        );
    }


    public function createConsulta(array $data): array
    {

        $consulta = $this->populateConsultaData(new Consulta(), $data);

        $this->entityManager->persist($consulta);
        $this->entityManager->flush();

        return $this->normalizer->normalize(
            $consulta,
            null,
            [
                'groups' => ['consulta', 'beneficiario', 'medico'],
                'circular_reference_handler' => function ($object) {
                    return $object->getId(); // Retorna o ID do objeto para evitar referência circular
                },
            ]
        );
    }

    public function updateConsulta(Consulta $consulta, array $data): array
    {
        $consulta = $this->consultaRepository->findById($consulta);

        if (!$consulta) {
            throw new NotFoundHttpException('Consulta não encontrada.');
        }

        $this->consultaValidator->validateUpdate($consulta);

        $this->populateConsultaData($consulta, $data);

        $this->entityManager->flush();

        return $this->normalizer->normalize(
            $consulta,
            null,
            [
                'groups' => ['consulta', 'beneficiario', 'medico'],
                'circular_reference_handler' => function ($object) {
                    return $object->getId(); // Retorna o ID do objeto para evitar referência circular
                },
            ]
        );
    }

    public function deleteConsulta(Consulta $consulta): void
    {

        $consulta = $this->consultaRepository->findById($consulta);

        if (!$consulta) {
            throw new NotFoundHttpException('Consulta não encontrada.');
        }

        if ($consulta->isConcluida()) {
            throw new AccessDeniedHttpException('Não é possível excluir uma consulta concluída.');
        }

        $this->consultaValidator->validateDelete($consulta);

        $this->entityManager->remove($consulta);
        $this->entityManager->flush();
    }

    private function populateConsultaData(Consulta $consulta, array $data): Consulta
    {
        return $consulta->setDataStatus(new \DateTime($data['dataStatus']))
            ->setStatus($data['status'])
            ->setBeneficiario($this->entityManager->getReference(Beneficiario::class, $data['beneficiario']['id'])) // Referenciando corretamente a entidade Beneficiario
            ->setMedico($this->entityManager->getReference(Medico::class, $data['medico']['id'])) // Referenciando corretamente a entidade Medico
            ->setHospital($this->entityManager->getReference(Hospital::class, $data['hospital']['id'])); // Referenciando corretamente a entidade Hospital
    }
    

    public function verificarEspecialidade(Medico $medico): string
    {
        // Verifica se a propriedade 'especialidade' está inicializada
        if (!$medico->getEspecialidade()) {
            // Força a inicialização do proxy ou trate a exceção conforme necessário
            $this->entityManager->initializeObject($medico);

            // Se ainda não estiver inicializada, você pode lançar uma exceção ou lidar de outra forma
            if (!$medico->getEspecialidade()) {
                throw new \RuntimeException('A propriedade especialidade não está inicializada.');
            }
        }

        // Agora você pode acessar a especialidade com segurança
        return $medico->getEspecialidade();
    }

    public function formatDataConsulta(array $consultas): array
    {
        return array_map(function (Consulta $consulta) {
            return [
                'id' => $consulta->getId(),
                'dataStatus' => $consulta->getDataStatusFormatted(), // Formatando a data da consulta
                'status' => $consulta->getStatus(),
                'beneficiario' => [
                    'id' => $consulta->getBeneficiario()->getId(),
                    'nome' => $consulta->getBeneficiario()->getNome(),
                    'email' => $consulta->getBeneficiario()->getEmail(),
                    'dataNascimento' => $consulta->getBeneficiario()->getDataNascimentoFormatted(),
                ],
                'medico' => [
                    'id' => $consulta->getMedico()->getId(),
                    'nome' => $consulta->getMedico()->getNome(),
                    'especialidade' => $consulta->getMedico()->getEspecialidade(),
                ],
                'hospital' => [
                    'id' => $consulta->getHospital()->getId(),
                    'nome' => $consulta->getHospital()->getNome(),
                    'endereco' => $consulta->getHospital()->getEndereco(),
                ],
            ];
        }, $consultas);
    }
}
