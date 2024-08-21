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
    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Hospital::class);
        $this->em = $em;
    }

    public function create(array $data): Hospital
    {
        $hospital = new Hospital();
        $hospital->setNome($data['name']); // ajuste os setters conforme necessário
        // Defina outros campos conforme necessário

        $this->em->persist($hospital);
        $this->em->flush();

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

        $this->em->flush();

        return $hospital;
    }

    public function delete(int $id): void
    {
        $hospital = $this->find($id);

        if (!$hospital) {
            throw new EntityNotFoundException('Hospital not found.');
        }

        $this->em->remove($hospital);
        $this->em->flush();
    }
}
