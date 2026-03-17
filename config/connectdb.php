<?php
// config/connectdb.php

$hostDB = "127.0.0.1";
$nameDB = "tienda_tecnologica_nueva";
$userDB = "Zelko";
$pwDB   = "Zelko1004190181";

try {
    $hostPDO = "mysql:host=$hostDB;dbname=$nameDB;charset=utf8mb4";
    $myPDO = new PDO($hostPDO, $userDB, $pwDB, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}