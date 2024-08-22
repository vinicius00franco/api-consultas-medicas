<?php

namespace App\Service;

use App\Entity\Hospital;
use App\Repository\HospitalRepository;
use Doctrine\ORM\EntityNotFoundException;

class HospitalService
{
    private $hospitalRepository;

    public function __construct(HospitalRepository $hospitalRepository)
    {
        $this->hospitalRepository = $hospitalRepository;
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

    public function getAllHospitals(): array
    {
        return $this->hospitalRepository->findAll();
    }
}
