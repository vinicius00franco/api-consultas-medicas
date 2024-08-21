<?php

namespace App\Repository;

use App\Entity\Beneficiario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class BeneficiarioRepository extends ServiceEntityRepository implements BeneficiarioRepositoryInterface
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Beneficiario::class);
        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function create(Beneficiario $beneficiario): Beneficiario
    {
        $this->entityManager->persist($beneficiario);
        $this->entityManager->flush();

        return $beneficiario;
    }

    public function update(Beneficiario $beneficiario, array $data): Beneficiario
    {
        $beneficiario->setFromData($data);
        $this->entityManager->flush();
        return $beneficiario;
    }

    public function delete(Beneficiario $beneficiario): void
    {
        $this->entityManager->remove($beneficiario);
        $this->entityManager->flush();
    }
    
}
