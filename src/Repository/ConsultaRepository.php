<?php

namespace App\Repository;

use App\Entity\Consulta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
        if (isset($data['data'])) {
            $consulta->setData(new \DateTime($data['data']));
        }
        if (isset($data['status'])) {
            $consulta->setStatus($data['status']);
        }
        if (isset($data['beneficiario'])) {
            $consulta->setBeneficiario($this->getEntityManager()->getReference('App:Beneficiario', $data['beneficiario']));
        }
        if (isset($data['medico'])) {
            $consulta->setMedico($this->getEntityManager()->getReference('App:Medico', $data['medico']));
        }
        if (isset($data['hospital'])) {
            $consulta->setHospital($this->getEntityManager()->getReference('App:Hospital', $data['hospital']));
        }

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
