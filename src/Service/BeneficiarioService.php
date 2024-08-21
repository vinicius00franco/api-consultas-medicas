<?php

namespace App\Service;

use App\Entity\Beneficiario;
use App\Repository\BeneficiarioRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
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
        return $this->beneficiarioRepository->findAll();
    }

    public function createBeneficiario(array $data): Beneficiario
    {
        $beneficiario = new Beneficiario();
        $beneficiario->setFromData($data);

        // Validate the Beneficiario entity
        $errors = $this->validator->validate($beneficiario);
        if (count($errors) > 0) {
            $errorMessages = [];
            /** @var \Symfony\Component\Validator\ConstraintViolation $error */
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            throw new \InvalidArgumentException(implode(', ', $errorMessages));
        }

        return $this->beneficiarioRepository->create($beneficiario);
    }

    public function updateBeneficiario(Beneficiario $beneficiario, array $data): Beneficiario
    {
        $beneficiario->setFromData($data);

        // Validate the updated Beneficiario entity
        $errors = $this->validator->validate($beneficiario);
        if (count($errors) > 0) {
            $errorMessages = [];
            /** @var \Symfony\Component\Validator\ConstraintViolation $error */
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            throw new \InvalidArgumentException(implode(', ', $errorMessages));
        }

        return $this->beneficiarioRepository->update($beneficiario, $data);
    }

    public function deleteBeneficiario(Beneficiario $beneficiario): void
    {
        $this->beneficiarioRepository->delete($beneficiario);
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
