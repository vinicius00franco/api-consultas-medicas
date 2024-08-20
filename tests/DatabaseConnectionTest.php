<?php
// tests/Integration/DatabaseConnectionTest.php
namespace App\Tests\Integration;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseConnectionTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $this->entityManager = $container->get(EntityManagerInterface::class);
    }

    public function testEntityManagerConnection(): void
    {
        $this->assertInstanceOf(EntityManagerInterface::class, $this->entityManager, 'Entity Manager should be an instance of EntityManagerInterface.');

        $connection = $this->entityManager->getConnection();
        $this->assertTrue($connection->isConnected(), 'Entity Manager connection should be established.');

        $result = $connection->executeQuery('SELECT 1');
        $this->assertEquals(1, $result->fetchOne(), 'Entity Manager query should return 1.');
    }

    protected function tearDown(): void
    {
        $this->entityManager->close();

        parent::tearDown();
    }
}
