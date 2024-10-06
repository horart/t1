<?php
$DBuser = 'root';
$DBpass = $_ENV['MYSQL_ROOT_PASSWORD'];
$pdo = null;

try{
    $database = 'mysql:host=database:3306;dbname=t1';
    $pdo = new PDO($database, $DBuser, $DBpass);
} catch(PDOException $e) {
    exit();
}