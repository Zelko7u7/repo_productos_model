<?php

$hostDB = "db";
$nameDB = "tienda_tecnologia";
$userDB = "zelko";
$pwDB   = "zelko123";

try {
    $hostPDO = "mysql:host=$hostDB;dbname=$nameDB;charset=utf8mb4";
    $myPDO = new PDO($hostPDO, $userDB, $pwDB, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}