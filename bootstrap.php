<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src'],
    isDevMode: true,
);

$connectionParams = [
    'dbname' => 'hms_db',
    'user' => 'root',
    'password' => 'password',
    'host' => '127.0.0.1',
    'driver' => 'pdo_mysql', // Or other driver
];
$conn = DriverManager::getConnection($connectionParams);



// obtaining the entity manager
$entityManager = new EntityManager($conn, $config);
$queryBuilder = $conn->createQueryBuilder();