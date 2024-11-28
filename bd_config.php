<?php

$destino = "mysql:host=localhost;dbname=Configurador_Ordenadores;charset=utf8mb4";
$user = "root";
$password = "";

try{
    // Crear conexion PDO
    $conn = new PDO($destino, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectado :)<br>";
} catch (PDOException $e){
    echo "Error en la conexion: " . $e->getMessage();
}