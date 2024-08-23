<?php

namespace App\Service;

use App\Entity\Hospital;
use App\Entity\Medico;
use App\Repository\HospitalRepository;
use App\Repository\MedicoRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class HospitalService
{
    private $hospitalRepository;
    private $serializer;
    private $normalizer;
    private $medicoRepository;

    public function __construct(
        HospitalRepository $hospitalRepository,
        MedicoRepository $medicoRepository,
        SerializerInterface $serializer,
        NormalizerInterface $normalizer
    ) {
        $this->hospitalRepository = $hospitalRepository;
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
    }

    public function getAllHospitals(): array
    {
        $hospital = $this->hospitalRepository->findAll();
        return $this->normalizer->normalize($hospital, null, [
            'groups' => ['medico', 'hospital'],
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            },

        ]);
    }

    public function createHospital(array $data): Hospital
    {
        $this->validateHospitalData($data);

        $hospital = new Hospital();
        $hospital->setNome($data['nome']);
        $hospital->setEndereco($data['endereco']);

        if (isset($data['medicos'])) {
            $this->createMedicos($data['medicos'], $hospital);
        }

        $this->hospitalRepository->save($hospital);

        return $hospital;
    }

    public function updateHospital(Hospital $hospital, array $data): Hospital
    {
        $hospital = $this->hospitalRepository->find($hospital);

        if (!$hospital) {
            throw new EntityNotFoundException('Hospital not found.');
        }

        $hospital->setNome($data['nome']);
        $hospital->setEndereco($data['endereco']);
        // Atualizar mais campos conforme necessário

        $this->hospitalRepository->save($hospital);

        return $hospital;
    }

    public function deleteHospital(Hospital $hospital): void
    {
        $hospital = $this->hospitalRepository->find($hospital);

        if (!$hospital) {
            throw new EntityNotFoundException('Hospital not found.');
        }

        $this->hospitalRepository->delete($hospital);
    }

    public function getHospitalById(Hospital $hospital): Hospital
    {
        $hospital = $this->hospitalRepository->find($hospital);

        if (!$hospital) {
            throw new EntityNotFoundException('Hospital not found.');
        }

        return $hospital;
    }

    private function createMedicos(array $medicosData, Hospital $hospital): void
    {
        foreach ($medicosData as $medicoData) {
            $this->validateMedicoData($medicoData);

            $medico = new Medico();
            $medico->setNome($medicoData['nome']);
            $medico->setEspecialidade($medicoData['especialidade']);
            $medico->setHospital($hospital);

            $this->medicoRepository->save($medico);
        }
    }

    private function validateHospitalData(array $data): void
    {
        if (empty($data['nome'])) {
            throw new \InvalidArgumentException("O nome do hospital é obrigatório.");
        }

        if (empty($data['endereco'])) {
            throw new \InvalidArgumentException("O endereço do hospital é obrigatório.");
        }
    }

    private function validateMedicoData(array $medicoData): void
    {
        if (empty($medicoData['nome'])) {
            throw new \InvalidArgumentException("O nome do médico é obrigatório.");
        }

        if (empty($medicoData['especialidade'])) {
            throw new \InvalidArgumentException("A especialidade do médico é obrigatória.");
        }
    }
}
