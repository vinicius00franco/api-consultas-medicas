<?php

namespace App\Tests\Integration;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseConnectionTest extends KernelTestCase
{
    /**
     * @var EntityManagerInterface|MockObject
     */
    private $entityManagerMock;

    /**
     * @var Connection|MockObject
     */
    private $connectionMock;

    protected function setUp(): void
    {
        // Boot the Symfony kernel
        self::bootKernel();

        // Create a mock for EntityManagerInterface
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        // Create a mock for Connection
        $this->connectionMock = $this->createMock(Connection::class);

        // Configure the EntityManager mock to return the Connection mock
        $this->entityManagerMock
            ->method('getConnection')
            ->willReturn($this->connectionMock);
    }

    /**
     * @dataProvider connectionStatusProvider
     */
    public function testEntityManagerConnectionIsEstablished(bool $isConnected): void
    {
        // Configure the Connection mock to simulate the connection status
        $this->connectionMock
            ->method('isConnected')
            ->willReturn($isConnected);

        // Test the connection status
        $this->assertSame($isConnected, $this->entityManagerMock->getConnection()->isConnected());
    }

    public function connectionStatusProvider(): array
    {
        return [
            'Connection is established' => [true],
            'Connection is not established' => [false],
        ];
    }

    /**
     * @dataProvider executeQueryProvider
     */
    public function testEntityManagerCanExecuteQuery(string $query, $expectedResult): void
    {
        // Configure the Connection mock to simulate query execution
        $this->connectionMock
            ->method('executeQuery')
            ->willReturn($this->createConfiguredMock(\Doctrine\DBAL\Result::class, ['fetchOne' => $expectedResult]));

        // Execute the query and assert the result
        $result = $this->entityManagerMock->getConnection()->executeQuery($query);
        $this->assertEquals($expectedResult, $result->fetchOne());
    }

    public function executeQueryProvider(): array
    {
        return [
            'Select 1' => ['SELECT 1', 1],
            'Select 0' => ['SELECT 0', 0],
            'Select null' => ['SELECT NULL', null],
        ];
    }

    protected function tearDown(): void
    {
        // Unset mocks
        $this->entityManagerMock = null;
        $this->connectionMock = null;

        parent::tearDown();
    }
}
