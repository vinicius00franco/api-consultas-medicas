<?php

namespace App\Repository;

use App\Entity\Consulta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consulta>
 */
class ConsultaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consulta::class);
    }

    public function updateConsulta(Consulta $consulta, array $data)
    {
        if ($consulta->getStatus() === 'concluída') {
            throw new AccessDeniedHttpException('Consultas concluídas não podem ser alteradas.');
        }

        // Atualize os dados da consulta aqui
        // Por exemplo:
        // $consulta->setCampo($data['campo']);
        
        $this->getEntityManager()->persist($consulta);
        $this->getEntityManager()->flush();
    }

    public function removeConsulta(Consulta $consulta)
    {
        if ($consulta->getStatus() === 'concluída') {
            throw new AccessDeniedHttpException('Consultas concluídas não podem ser excluídas.');
        }

        $this->getEntityManager()->remove($consulta);
        $this->getEntityManager()->flush();
    }
}
