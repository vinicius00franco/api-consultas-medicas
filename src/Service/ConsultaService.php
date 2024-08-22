<?php

namespace App\Service;

use App\Entity\Consulta;
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
        return $this->normalizer->normalize($consultas, null, ['groups' => ['consulta']]);
    }

    public function getConsultaById(Consulta $consulta): ?array
    {
        $consulta = $this->consultaRepository->findById($consulta);

        if (!$consulta) {
            throw new NotFoundHttpException('Consulta não encontrada.');
        }

        return $this->normalizer->normalize($consulta, null, ['groups' => ['consulta']]);
    }


    public function createConsulta(array $data): array
    {
        $consulta = new Consulta();
        $this->populateConsultaData($consulta, $data);

        $this->entityManager->persist($consulta);
        $this->entityManager->flush();

        return $this->normalizer->normalize($consulta, null, ['groups' => ['consulta']]);
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

        return $this->normalizer->normalize($consulta, null, ['groups' => ['consulta']]);
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

    private function populateConsultaData(Consulta $consulta, array $data): void
    {
        $consulta->setDataNascimento(new \DateTime($data['data']));
        $consulta->setStatus($data['status']);
        $consulta->setBeneficiario($this->entityManager->getReference('App:Beneficiario', $data['beneficiario']));
        $consulta->setMedico($this->entityManager->getReference('App:Medico', $data['medico']));
        $consulta->setHospital($this->entityManager->getReference('App:Hospital', $data['hospital']));
    }
}
