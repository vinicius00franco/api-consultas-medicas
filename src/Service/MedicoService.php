<?php

namespace App\Service;

use App\Repository\MedicoRepository;
use App\Entity\Medico;
use App\Repository\HospitalRepository;
use App\Service\Validation\MedicoDataValidator;
use Doctrine\ORM\EntityNotFoundException;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MedicoService
{
    private $medicoRepository;
    private $serializer;
    private $normalizer;

    private $medicoValidator;
    private $hospitalRepository;

    public function __construct(
        MedicoRepository $medicoRepository,
        SerializerInterface $serializer,
        NormalizerInterface $normalizer,
        MedicoDataValidator $medicoValidator,
        HospitalRepository $hospitalRepository
    ) {
        $this->medicoRepository = $medicoRepository;
        $this->hospitalRepository = $hospitalRepository;
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;

        $this->medicoValidator = $medicoValidator;
    }

    public function getAllMedicos(): array
    {
        $medicos = $this->medicoRepository->findAll();



        return $this->normalizer->normalize(
            $medicos,
            null,
            [
                'groups' => ['medico', 'hospital'],
                'circular_reference_handler' => function ($object) {
                    return $object->getId(); // Retorna o ID do objeto para evitar referência circular
                },
            ]
        );
    }

    public function createMedico(array $data): Medico
    {

        $this->medicoValidator->validateMedicoData($data);

        $medico = new Medico();
        $medico->setNome($data['nome']);
        $medico->setEspecialidade($data['especialidade']);

        $hospital = $this->medicoValidator->getHospitalFromData($data);
        $medico->setHospital($hospital);

        $this->medicoRepository->save($medico);

        return $medico;
    }

    public function updateMedico(Medico $medicoId, array $data): Medico
    {
        $this->medicoValidator->validateMedicoData($data);

        // Conversão do array de hospital em objeto Hospital
        $hospital = $this->hospitalRepository->find($data['hospital']['id']);
        if (!$hospital) {
            throw new \Exception('Hospital não encontrado.');
        }

        // Chama o método update no repositório com os dados preparados
        return $this->medicoRepository->update($medicoId, $data, $hospital);
    }

    public function deleteMedico(Medico $medicoId): void
    {
        $medico = $this->medicoRepository->findById($medicoId);

        if (!$medico) {
            throw new EntityNotFoundException('Medico not found.');
        }

        $this->medicoRepository->delete($medico);
    }

    public function deactivateMedico(Medico $medicoId): void
    {
        $medicoId->setAtivo(false);
        $this->medicoRepository->save($medicoId);
    }

    public function getMedicoById(Medico $medicoId): Medico
    {
        $medico = $this->medicoRepository->findById($medicoId);

        if (!$medico) {
            throw new EntityNotFoundException('Medico not found.');
        }

        return $medico;
    }
}
