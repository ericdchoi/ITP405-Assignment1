<?php
    require(__DIR__ . '/vendor/autoload.php');

    if (file_exists(__DIR__ . '/.env')) {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }
    
    $pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);
    $sql = "SELECT * FROM invoices";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $invoices = $statement->fetchAll(PDO::FETCH_OBJ);
    var_dump($invoices);
?>