<?php

namespace App\Repository;

use App\Entity\Beneficiario;
use Doctrine\ORM\EntityManagerInterface;

class BeneficiarioRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll():array
    {
        return $this->entityManager->getRepository(Beneficiario::class)->findAll();
    }

    public function create(array $data): Beneficiario
    {
        $beneficiario = new Beneficiario();
        $beneficiario->setFromData($data);

        $this->entityManager->persist($beneficiario);
        $this->entityManager->flush();

        return $beneficiario;
    }

    public function update(Beneficiario $beneficiario, array $data) : Beneficiario
    {
        $beneficiario->setFromData($data);

        $this->entityManager->flush();

        return $beneficiario;
    }

    public function delete(Beneficiario $beneficiario) : void
    {
        $this->entityManager->remove($beneficiario);
        $this->entityManager->flush();
    }
}
