<?php

namespace App\Repository;

use App\Entity\Consulta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Repository\Pattern\ConsultaRepositoryInterface;

class ConsultaRepository extends ServiceEntityRepository implements ConsultaRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consulta::class);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function findById(Consulta $consulta): ?Consulta
    {
        return parent::find($consulta,$lockMode = null, $lockVersion = null);
    }

    public function createConsulta(array $data): Consulta
    {
        $consulta = new Consulta();
        $consulta->setDataNascimento(new \DateTime($data['data']));
        $consulta->setStatus($data['status']);
        $consulta->setBeneficiario($this->getReference('App:Beneficiario', $data['beneficiario']));
        $consulta->setMedico($this->getReference('App:Medico', $data['medico']));
        $consulta->setHospital($this->getReference('App:Hospital', $data['hospital']));

        $this->getEntityManager()->persist($consulta);
        $this->getEntityManager()->flush();

        return $consulta;
    }

    public function updateConsulta(Consulta $consulta, array $data): Consulta
    {
        if ($consulta->getStatus() === 'concluída') {
            throw new AccessDeniedHttpException('Não é possível alterar uma consulta concluída.');
        }

        $consulta->setDataNascimento(new \DateTime($data['data']));
        $consulta->setStatus($data['status']);
        $consulta->setBeneficiario($this->getReference('App:Beneficiario', $data['beneficiario']));
        $consulta->setMedico($this->getReference('App:Medico', $data['medico']));
        $consulta->setHospital($this->getReference('App:Hospital', $data['hospital']));

        $this->getEntityManager()->flush();

        return $consulta;
    }

    public function removeConsulta(Consulta $consulta): void
    {
        if ($consulta->getStatus() === 'concluída') {
            throw new AccessDeniedHttpException('Não é possível excluir uma consulta concluída.');
        }

        $this->getEntityManager()->remove($consulta);
        $this->getEntityManager()->flush();
    }
}
