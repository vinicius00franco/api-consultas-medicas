<?php


namespace App\Tests\EndToEnd;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BeneficiarioTest extends WebTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $client = static::createClient();
        $this->entityManager = $client->getContainer()->get('doctrine')->getManager();
        $this->entityManager->beginTransaction();
    }
    

    public function testCreateAndListBeneficiario(): void
    {
        $client = static::createClient();
        
        // Criando um beneficiário
        $client->request('POST', '/beneficiarios', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'nome' => 'John Doe',
            'email' => 'john.doe@example.com',
            'data_nascimento' => '2000-01-01'
        ]));
        
        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());

        // Listando beneficiários
        $client->request('GET', '/beneficiarios');
        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($responseData);
        $this->assertCount(1, $responseData);
        $this->assertEquals('John Doe', $responseData[0]['nome']);
    }

    public function testUpdateBeneficiario(): void
    {
        $client = static::createClient();
        
        // Atualizando o beneficiário
        $client->request('PUT', '/beneficiarios/1', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'nome' => 'John Doe Updated',
            'email' => 'john.updated@example.com',
            'data_nascimento' => '2000-01-01'
        ]));

        $this->assertResponseIsSuccessful();
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testDeleteBeneficiario(): void
    {
        $client = static::createClient();
        
        // Deletando o beneficiário
        $client->request('DELETE', '/beneficiarios/1');
        $this->assertResponseStatusCodeSame(204);
    }

    protected function tearDown(): void
    {
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this->entityManager->rollback();
        }
        parent::tearDown();
    }


}
