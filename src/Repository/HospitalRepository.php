<?php


namespace App\Repository;

use App\Entity\Hospital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

/**
 * @extends ServiceEntityRepository<Hospital>
 */
class HospitalRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Hospital::class);
        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function create(array $data): Hospital
    {
        $hospital = new Hospital();
        $hospital->setNome($data['name']); // ajuste os setters conforme necessário
        // Defina outros campos conforme necessário

        $this->entityManager->persist($hospital);
        $this->entityManager->flush();

        return $hospital;
    }

    public function update(int $id, array $data): Hospital
    {
        $hospital = $this->find($id);

        if (!$hospital) {
            throw new EntityNotFoundException('Hospital not found.');
        }

        $hospital->setName($data['name']); // ajuste os setters conforme necessário
        // Atualize outros campos conforme necessário

        $this->entityManager->flush();

        return $hospital;
    }


    public function save(Hospital $hospital): void
    {
        $this->entityManager->persist($hospital);
        $this->entityManager->flush();
    }

    public function delete(Hospital $hospitalId): void
    {
        $hospital = $this->find($hospitalId);

        if (!$hospitalId) {
            throw new EntityNotFoundException('Hospital not found.');
        }
        $this->entityManager->remove($hospitalId);
        $this->entityManager->flush();
    }
}
