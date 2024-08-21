<?php
namespace App\Repository;

use App\Entity\Beneficiario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BeneficiarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beneficiario::class);
    }

    public function create(array $data): Beneficiario
    {
        $beneficiario = new Beneficiario();
        $beneficiario->setFromData($data);

        $this->_em->persist($beneficiario); // Utilize $this->_em para acessar o EntityManager
        $this->_em->flush();

        return $beneficiario;
    }

    public function update(Beneficiario $beneficiario, array $data): Beneficiario
    {
        $beneficiario->setFromData($data);
        $this->_em->flush();
        return $beneficiario;
    }

    public function delete(Beneficiario $beneficiario): void
    {
        $this->_em->remove($beneficiario);
        $this->_em->flush();
    }
}
