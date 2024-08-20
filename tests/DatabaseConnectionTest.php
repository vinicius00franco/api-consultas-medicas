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

        if (!$this->entityManager) {
            throw new \Exception('Entity Manager could not be instantiated.');
        }

        var_dump(getenv('DATABASE_URL'));
    }

    public function testEntityManagerConnection(): void
    {
        $this->assertInstanceOf(EntityManagerInterface::class, $this->entityManager, 'Entity Manager should be an instance of EntityManagerInterface.');

        $connection = $this->entityManager->getConnection();
        $this->assertNotNull($connection, 'Connection should not be null.');

        try {

            $this->assertTrue($connection->isConnected(), 'Entity Manager connection should be established.');
        } catch (\Exception $e) {
            $this->fail('Failed to establish connection: ' . $e->getMessage());
        }

        try {
            $result = $connection->executeQuery('SELECT 1');
            $this->assertEquals(1, $result->fetchOne(), 'Entity Manager query should return 1.');
        } catch (\Exception $e) {
            $this->fail('Query execution failed: ' . $e->getMessage());
        }
    }

    protected function tearDown(): void
    {
        if ($this->entityManager->isOpen()) {
            $this->entityManager->close();
        }

        parent::tearDown();
    }
}
