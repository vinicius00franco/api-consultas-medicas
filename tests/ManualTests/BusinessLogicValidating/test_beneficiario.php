<?php

require_once 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Validator\Validation;
use Doctrine\ORM\ORMSetup;

// Caminhos para suas classes de entidade
$paths = ["/path/to/entity-files"];
$isDevMode = true;

// Configuração do Doctrine
$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

// Configuração do cache
$metadataCache = new PhpFilesAdapter('doctrine_metadata');
$queryCache = new PhpFilesAdapter('doctrine_queries');
$config->setMetadataCache($metadataCache);
$config->setQueryCache($queryCache);

// Configuração do proxy
$config->setProxyDir('/path/to/proxies');
$config->setProxyNamespace('MyProject\Proxies');
$config->setAutoGenerateProxyClasses($isDevMode);

// Configuração da conexão usando variáveis de ambiente
$conn = [
    'driver' => 'pdo_mysql',
    'user' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'dbname' => getenv('DB_NAME'),
];
    
// Criação do EntityManager
$connection = DriverManager::getConnection($conn);
$entityManager = new EntityManager($connection, $config);

// Criação do Validador
$validator = Validation::createValidator();


echo"Teste de Beneficiário - Idade Mínima:\n";

$beneficiario = new \App\Entity\Beneficiario();

// Beneficiário com data de nascimento válida$beneficiario = new\App\Entity\Beneficiario();
$beneficiario->setNome('Ana');
$beneficiario->setDataNascimento(new \DateTime('-20 years')); // Mais de 18 anos$errors = $validator->validate($beneficiario);
$errors = $validator->validate($beneficiario);

if (count($errors) > 0) {
    echo"Erro ao criar Beneficiário com data de nascimento válida:\n";
    foreach ($errors as $error) {
        echo$error->getMessage() . "\n";
    }
} else {
    echo"Beneficiário com data de nascimento válida criado com sucesso.\n";
}

// Beneficiário com data de nascimento inválida$beneficiario->setDataNascimento(new\DateTime('-16 years')); // Menos de 18 anos$errors = $validator->validate($beneficiario);
if (count($errors) > 0) {
    echo"Erro ao criar Beneficiário com data de nascimento inválida:\n";
    foreach ($errors as $error) {
        echo$error->getMessage() . "\n";
    }
} else {
    echo"Beneficiário com data de nascimento inválida criado com sucesso (não esperado).\n";
}
