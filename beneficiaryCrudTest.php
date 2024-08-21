<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

// Configuração do cliente HTTP
$client = HttpClient::create(['base_uri' => 'http://localhost:8000/']);

// Função para testar a criação de um beneficiário
function testCreateBeneficiario($client) {
    $response = $client->request('POST', 'beneficiarios', [
        'json' => [
            'nome' => 'João Silva',
            'email' => 'joao.silva@example.com',
            'data_nascimento' => '2000-01-01'
        ]
    ]);

    echo "Create Beneficiario: " . $response->getStatusCode() . "\n";
    echo $response->getContent() . "\n";
}

// Função para testar a listagem de beneficiários
function testListBeneficiarios($client) {
    $response = $client->request('GET', 'beneficiarios');

    echo "List Beneficiarios: " . $response->getStatusCode() . "\n";
    echo $response->getContent() . "\n";
}

// Função para testar a atualização de um beneficiário
function testUpdateBeneficiario($client, $id) {
    $response = $client->request('PUT', "beneficiarios/{$id}", [
        'json' => [
            'nome' => 'João da Silva'
        ]
    ]);

    echo "Update Beneficiario: " . $response->getStatusCode() . "\n";
    echo $response->getContent() . "\n";
}

// Função para testar a deleção de um beneficiário
function testDeleteBeneficiario($client, $id) {
    $response = $client->request('DELETE', "beneficiarios/{$id}");

    echo "Delete Beneficiario: " . $response->getStatusCode() . "\n";
}

// Testar CRUD para Beneficiário
echo "Testing Beneficiario CRUD\n";
testCreateBeneficiario($client);
testListBeneficiarios($client);

// Supondo que o ID do beneficiário criado é 1
$beneficiarioId = 1; // Você pode ajustar conforme necessário
testUpdateBeneficiario($client, $beneficiarioId);
testDeleteBeneficiario($client, $beneficiarioId);

// Testar CRUD para Médico, Hospital e Consulta
// Repetir o mesmo processo para os endpoints médicos, hospitais e consultas

echo "Testing Medico CRUD\n";
// Adicione funções similares para Medico e teste seus CRUDs

echo "Testing Hospital CRUD\n";
// Adicione funções similares para Hospital e teste seus CRUDs

echo "Testing Consulta CRUD\n";
// Adicione funções similares para Consulta e teste seus CRUDs

