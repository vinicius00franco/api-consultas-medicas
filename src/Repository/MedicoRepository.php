<?php
namespace App\Repository;

use App\Entity\Medico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MedicoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medico::class);
    }

    public function save(Medico $medico): void
    {
        $this->_em->persist($medico);
        $this->_em->flush();
    }

    public function remove(Medico $medico): void
    {
        $this->_em->remove($medico);
        $this->_em->flush();
    }
}
