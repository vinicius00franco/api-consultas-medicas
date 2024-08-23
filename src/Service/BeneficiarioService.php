<?php

namespace App\Service;

use App\Entity\Beneficiario;
use App\Repository\Pattern\BeneficiarioRepositoryInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BeneficiarioService
{
    private $beneficiarioRepository;
    private $validator;
    private $serializer;

    public function __construct(BeneficiarioRepositoryInterface $beneficiarioRepository, ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->beneficiarioRepository = $beneficiarioRepository;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function getAllBeneficiarios(): array
    {
        $beneficiarios = $this->beneficiarioRepository->findAll();
        return $this->formatBeneficiarios($beneficiarios);
    }

    public function createBeneficiario(array $data): Beneficiario
    {
        $beneficiario = new Beneficiario();
        $beneficiario->setFromData($data);

        $this->validateBeneficiario($beneficiario);
        $this->serializeBeneficiario($beneficiario);

        return $this->beneficiarioRepository->create($beneficiario);
    }

    public function updateBeneficiario(Beneficiario $beneficiario, array $data): Beneficiario
    {
        $beneficiario->setFromData($data);

        $this->validateBeneficiario($beneficiario);
        $this->serializeBeneficiario($beneficiario);

        return $this->beneficiarioRepository->update($beneficiario, $data);
    }

    public function deleteBeneficiario(Beneficiario $beneficiario): void
    {
        $this->beneficiarioRepository->delete($beneficiario);
    }

    private function validateBeneficiario(Beneficiario $beneficiario): void
    {
        $errors = $this->validator->validate($beneficiario);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            throw new \InvalidArgumentException(implode(', ', $errorMessages));
        }
    }

    private function serializeBeneficiario(Beneficiario $beneficiario): void
    {
        $this->serializer->serialize($beneficiario, 'json', [
            AbstractNormalizer::GROUPS => ['beneficiario']
        ]);
    }

    public function formatBeneficiarios(array $beneficiarios): array
    {
        return array_map(function (Beneficiario $beneficiario) {
            return [
                'id' => $beneficiario->getId(),
                'nome' => $beneficiario->getNome(),
                'email' => $beneficiario->getEmail(),
                'dataNascimento' => $beneficiario->getDataNascimentoFormatted(), // Formatando a data
            ];
        }, $beneficiarios);
    }
}
