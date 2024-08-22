<?php

namespace App\Service\Validation;

use App\Repository\HospitalRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class MedicoDataValidator
{
    private $hospitalRepository;
    private $validator;

    public function __construct(HospitalRepository $hospitalRepository, ValidatorInterface $validator)
    {
        $this->hospitalRepository = $hospitalRepository;
        $this->validator = $validator;
    }

    public function validateMedicoData(array $data): void
    {
        if (!isset($data['nome']) || empty($data['nome'])) {
            throw new \InvalidArgumentException('Nome do médico é obrigatório.');
        }

        if (!isset($data['especialidade']) || empty($data['especialidade'])) {
            throw new \InvalidArgumentException('Especialidade do médico é obrigatória.');
        }

        if (!isset($data['hospital']) || !is_array($data['hospital']) || !isset($data['hospital']['id'])) {
            throw new \InvalidArgumentException('Dados do hospital inválidos.');
        }

        $hospital = $this->hospitalRepository->find($data['hospital']['id']);
        if (!$hospital) {
            throw new \Exception('Hospital não encontrado.');
        }

    }

    public function getHospitalFromData(array $data)
    {
        return $this->hospitalRepository->find($data['hospital']['id']);
    }
}
