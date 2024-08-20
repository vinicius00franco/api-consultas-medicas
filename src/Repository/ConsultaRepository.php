<?php


namespace App\Repository;

use App\Entity\Consulta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ConsultaRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->entityManager->getRepository(Consulta::class)->findAll();
    }
    public function find($id)
    {
        return $this->entityManager->getRepository(Consulta::class)->find($id);
    }

    public function create(array $data)
    {
        $consulta = new Consulta();
        $consulta->setDataNascimento(new \DateTime($data['data']));
        $consulta->setStatus($data['status']);
        $consulta->setBeneficiario($this->entityManager->getReference('App:Beneficiario', $data['beneficiario']));
        $consulta->setMedico($this->entityManager->getReference('App:Medico', $data['medico']));
        $consulta->setHospital($this->entityManager->getReference('App:Hospital', $data['hospital']));

        $this->entityManager->persist($consulta);
        $this->entityManager->flush();

        return $consulta;
    }

    public function updateConsulta(Consulta $consulta, array $data)
    {
        if ($consulta->getStatus() === 'concluída') {
            throw new AccessDeniedHttpException('Não é possível alterar uma consulta concluída.');
        }

        $consulta->setDataNascimento(new \DateTime($data['data']));
        $consulta->setStatus($data['status']);
        $consulta->setBeneficiario($this->entityManager->getReference('App:Beneficiario', $data['beneficiario']));
        $consulta->setMedico($this->entityManager->getReference('App:Medico', $data['medico']));
        $consulta->setHospital($this->entityManager->getReference('App:Hospital', $data['hospital']));

        $this->entityManager->flush();

        return $consulta;
    }

    public function removeConsulta(Consulta $consulta)
    {
        if ($consulta->getStatus() === 'concluída') {
            throw new AccessDeniedHttpException('Não é possível excluir uma consulta concluída.');
        }

        $this->entityManager->remove($consulta);
        $this->entityManager->flush();
    }
}
