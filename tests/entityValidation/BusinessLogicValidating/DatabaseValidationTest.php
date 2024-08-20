<?php
// tests/Integration/DatabaseConnectionTest.php
namespace App\Tests\Integration;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DatabaseValidationTest extends KernelTestCase
{
    private ?Connection $connection = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->connection = self::getContainer()->get('doctrine.dbal.default_connection');
    }

    public function testDatabaseConnection(): void
    {
        $this->assertNotNull($this->connection, 'A conexão com o banco de dados não deveria ser nula.');

        try {
            // Execute a simples consulta para verificar a conexão
            $result = $this->connection->fetchAllAssociative('SELECT 1');
            $this->assertNotEmpty($result, 'A consulta ao banco de dados não retornou resultados esperados.');
        } catch (\Exception $e) {
            $this->fail('A conexão com o banco de dados falhou: ' . $e->getMessage());
        }
    }

    protected function tearDown(): void
    {
        // Não precisamos fazer nada aqui para um teste de conexão
        $this->connection = null;
        parent::tearDown();
    }
}
