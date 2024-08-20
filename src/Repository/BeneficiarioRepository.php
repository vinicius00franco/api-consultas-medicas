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

    public function findAll()
    {
        return $this->entityManager->getRepository(Beneficiario::class)->findAll();
    }

    public function create(array $data)
    {
        $beneficiario = new Beneficiario();
        $beneficiario->setNome($data['nome']);
        $beneficiario->setEmail($data['email']);
        $beneficiario->setDataNascimento(new \DateTime($data['data_nascimento']));

        $this->entityManager->persist($beneficiario);
        $this->entityManager->flush();

        return $beneficiario;
    }

    public function update(Beneficiario $beneficiario, array $data)
    {
        $beneficiario->updateFromData($data);
        $this->entityManager->flush();

        return $beneficiario;
    }

    public function delete(Beneficiario $beneficiario)
    {
        $this->entityManager->remove($beneficiario);
        $this->entityManager->flush();
    }
}
