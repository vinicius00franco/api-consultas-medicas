<?php

namespace App\Repository;

use App\Entity\Hospital;
use App\Entity\Medico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class MedicoRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Medico::class);
        $this->entityManager = $entityManager;
    }

    public function save(Medico $medico): void
    {
        $this->entityManager->persist($medico);
        $this->entityManager->flush();
    }

    public function delete(Medico $medico): void
    {
        $this->entityManager->remove($medico);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function findById(Medico $medicoId): ?Medico
    {
        return $this->find($medicoId);
    }

    public function update(Medico $medicoId, array $data, Hospital $hospital): Medico
    {
        $medico = $this->find($medicoId);

        if (!$medico) {
            throw new EntityNotFoundException('Medico not found.');
        }

        $medico->setNome($data['nome']);
        $medico->setEspecialidade($data['especialidade']);
        $medico->setHospital($hospital);

        $this->save($medico);

        return $medico;
    }

    public function deactivateMedico(Medico $medico): void
    {
        $medico->setAtivo(false);
        $this->medicoRepository->save($medico);
    }
}
