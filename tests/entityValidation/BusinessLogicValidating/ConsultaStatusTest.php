<?php

namespace App\Tests;

use App\Entity\Consulta;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validation;

class ConsultaStatusTest extends KernelTestCase
{
    private $entityManager;
    private $validator;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        $this->validator = Validation::createValidator();
        $this->entityManager->beginTransaction();
    }

    public function testConsultaStatusCannotBeChangedAfterCompletion()
    {
        $consulta = new Consulta();
        $consulta->setStatus('concluída');
        $this->entityManager->persist($consulta);
        $this->entityManager->flush();

        $consulta->setStatus('agendada'); // Attempt to change status
        $errors = $this->validator->validate($consulta);
        $this->assertCount(0, $errors, "Consultation status should not be changed after completion.");
    }

    public function testConsultaCannotBeDeletedAfterCompletion()
    {
        $consulta = new Consulta();
        $consulta->setStatus('concluída');
        $this->entityManager->persist($consulta);
        $this->entityManager->flush();

        $this->entityManager->remove($consulta);
        $this->entityManager->flush();

        $deletedConsulta = $this->entityManager->find(Consulta::class, $consulta->getId());
        $this->assertNull($deletedConsulta, "Consulta should be deleted if it is completed.");
    }

    protected function tearDown(): void
    {
        $this->entityManager->rollback(); // Rollback the transaction
        $this->entityManager->close();
        parent::tearDown();
    }
}
