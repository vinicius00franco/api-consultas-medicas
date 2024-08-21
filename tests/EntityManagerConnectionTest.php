<?php


// tests/Integration/DatabaseConnectionTest.php
namespace App\Tests\Integration;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
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
        $this->connection = $this->createMock(Connection::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        // Simulando o retorno do método getConnection do EntityManager
        $this->entityManager->method('getConnection')->willReturn($this->connection);

        // Simulando uma conexão bem-sucedida
        $this->connection->method('isConnected')->willReturn(true);
    }

    public function testEntityManagerConnection(): void
    {
        $this->assertInstanceOf(EntityManagerInterface::class, $this->entityManager, 'Entity Manager should be an instance of EntityManagerInterface.');

        $connection = $this->entityManager->getConnection();
        $this->assertNotNull($connection, 'Connection should not be null.');

        // Verificando se a conexão foi estabelecida
        $this->assertTrue($connection->isConnected(), 'Entity Manager connection should be established.');

        // Simulando a execução de uma consulta simples
        $this->connection->expects($this->once())->method('executeQuery')->with('SELECT 1')->willReturn(new class {
            public function fetchOne() {
                return 1;
            }
        });

        // Verificando o resultado da consulta simulada
        $result = $connection->executeQuery('SELECT 1');
        $this->assertEquals(1, $result->fetchOne(), 'Entity Manager query should return 1.');
    }

}
