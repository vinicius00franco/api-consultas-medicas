<?php
$baseUrl = 'http://localhost:8000';

// Testar Listagem de Beneficiários
echo "Listar Beneficiários:\n";
$options = [
    'http' => [
        "header" => "User-Agent: PHP",
        'method'  => 'GET',
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
];
$context = stream_context_create($options);
$response = file_get_contents($baseUrl . '/beneficiarios', false, $context);
echo $response . "\n";

// Testar Criação de Beneficiário
echo "Criar Beneficiário:\n";
$data = json_encode(['nome' => 'John Doe', 'email' => 'john@example.com', 'data_nascimento' => '2000-01-01']);
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => $data,
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
];
$context  = stream_context_create($options);
$response = file_get_contents($baseUrl . '/beneficiarios', false, $context);
echo $response . "\n";

// Testar Atualização de Beneficiário
echo "Atualizar Beneficiário:\n";
$data = json_encode(['nome' => 'John Doe Updated', 'email' => 'john_updated@example.com', 'data_nascimento' => '2000-01-01']);
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'PUT',
        'content' => $data,
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
];
$context  = stream_context_create($options);
$response = file_get_contents($baseUrl . '/beneficiarios/1', false, $context);
echo $response . "\n";

// Testar Exclusão de Beneficiário
echo "Deletar Beneficiário:\n";
$options = [
    'http' => [
        'method'  => 'DELETE',
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
];
$context  = stream_context_create($options);
$response = file_get_contents($baseUrl . '/beneficiarios/1', false, $context);
echo $response . "\n";
