<?php

include 'Migrations.php';

require_once 'db_config.php';

//подключаемся к базе данных
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $login, $pass);
} catch (PDOException $e) {
    die($e->getMessage());
}


$migrationObject = new Migrations($pdo);
$migrationObject->init();




