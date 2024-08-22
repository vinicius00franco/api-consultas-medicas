<?php

namespace App\Service;

use App\Entity\Hospital;
use App\Repository\HospitalRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class HospitalService
{
    private $hospitalRepository;
    private $serializer;
    private $normalizer;

    public function __construct(HospitalRepository $hospitalRepository, SerializerInterface $serializer,NormalizerInterface $normalizer)
    {
        $this->hospitalRepository = $hospitalRepository;
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
    }

    public function getAllHospitals(): array
    {
        $hospital = $this->hospitalRepository->findAll();
        return $this->normalizer->normalize($hospital, null, ['groups' => ['medico', 'hospital'],
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        },
    
    ]);
    }

    public function createHospital(array $data): Hospital
    {
        $hospital = new Hospital();
        $hospital->setNome($data['nome']);
        $hospital->setEndereco($data['endereco']);
        // Adicionar mais campos conforme necessário

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
}
