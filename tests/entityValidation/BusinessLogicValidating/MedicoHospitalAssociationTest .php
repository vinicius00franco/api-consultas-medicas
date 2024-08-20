<?php

namespace App\Tests;

use App\Entity\Medico;
use App\Entity\Hospital;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validation;

class MedicoHospitalAssociationTest extends KernelTestCase
{
    private $entityManager;
    private $validator;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
        $this->validator = Validation::createValidator();
    }

    public function testMedicoWithExistingHospital()
    {
        $hospital = new Hospital();
        $hospital->setNome('Hospital São Paulo');
        $this->entityManager->persist($hospital);
        $this->entityManager->flush();

        $medico = new Medico();
        $medico->setNome('Dr. Pedro');
        $medico->setEspecialidade('Dermatologista');
        $medico->setHospital($hospital);

        $errors = $this->validator->validate($medico);
        $this->assertCount(0, $errors, "Medico should be valid with an existing hospital.");
    }

    public function testMedicoWithNonExistentHospital()
    {
        $medico = new Medico();
        $medico->setNome('Dr. Pedro');
        $medico->setEspecialidade('Dermatologista');
        $medico->setHospital(null); // Simulate non-existent hospital

        $errors = $this->validator->validate($medico);
        $this->assertGreaterThan(0, $errors, "Medico should not be valid with a non-existent hospital.");
    }
}
