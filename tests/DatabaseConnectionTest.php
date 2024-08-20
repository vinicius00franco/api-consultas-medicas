<?php

// tests/Integration/DatabaseConnectionTest.php
namespace App\Tests\Integration;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseConnectionTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        // Boot the Symfony kernel to access the service container
        self::bootKernel();

        // Retrieve the entity manager from the container
        $this->entityManager = self::getContainer()->get('doctrine.orm.entity_manager');    }

    public function testDatabaseConnectionIsSuccessful(): void
    {
        // Verify that the entity manager and connection are not null
        $this->assertNotNull($this->entityManager, 'Entity Manager should not be null');

        // Get the connection from the entity manager
        $connection = $this->entityManager->getConnection();

        // Verify that the connection is established
        $this->assertTrue($connection->isConnected(), 'Database should be connected');

        // Execute a simple query and verify the result
        $result = $connection->executeQuery('SELECT 1');
        $this->assertEquals(1, $result->fetchOne(), 'Simple SELECT query should return 1');
    }

    protected function tearDown(): void
    {
        // Close the entity manager to ensure the connection is released
        if ($this->entityManager !== null) {
            $this->entityManager->close();
        }

        $this->entityManager = null;

        parent::tearDown();
    }
}
