<?php
session_start();
require_once "BD.php";
$usuario = $_SESSION["usuario"];
$usuario_id = (int)BD::getUsuarioId($usuario);

// Si recibe GET significa que ha seleccionado un componente
if(isset($_GET["tipo_componente"]) && isset($_GET["componente_id"])){
    BD::agregarComponenteOrdenador($usuario_id, $_GET["tipo_componente"], $_GET["componente_id"]);
}

$ordenador = BD::getComponentesOrdenador($usuario_id);
var_dump($ordenador);
$tipo_componentes = ["placa", "caja", "proc", "grafica", "ram", "discoDuro"];
$nombreTablaComponentes = ["placa_base", "caja", "procesador", "tarjeta_grafica", "ram", "disco_duro"];

$nombresComponentes = [];
for($i = 0; $i < count($tipo_componentes); $i++){
    echo $nombreTablaComponentes[$i] . "<br>";
    echo $tipo_componentes[$i] . "<br>";
    echo $ordenador[$i] . "<br>";
    $nombresComponentes = BD::obtenerNombrePorId($nombreTablaComponentes[$i], $tipo_componentes[$i], $ordenador[$i]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuracion ordenador</title>
    <style>
        table {
            border-collapse: collapse;
        }

        td {
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <table>
        <th>
        <td>Ordenador</td>
        </th>
        <tr>
            <td>Placa base</td>
            <td><?= $nombresComponentes[0] ?></td>
            <td><a href="seleccionarComponente.php?componente=placa_base">Seleccionar</td>
        </tr>
        <tr>
            <td>Caja</td>
            <td><?= $nombresComponentes[1] ?></td>
            <td><a href="seleccionarComponente.php?componente=caja">Seleccionar</td>
        </tr>
        <tr>
            <td>Disco Duro</td>
            <td><?= $nombresComponentes[2] ?></td>
            <td><a href="seleccionarComponente.php?componente=disco_duro">Seleccionar</td>
        </tr>
        <tr>
            <td>Procesador</td>
            <td><?= $nombresComponentes[3] ?></td>
            <td><a href="seleccionarComponente.php?componente=procesador">Seleccionar</td>
        </tr>
        <tr>
            <td>RAM</td>
            <td><?= $nombresComponentes[4] ?></td>
            <td><a href="seleccionarComponente.php?componente=ram">Seleccionar</td>
        </tr>
        <tr>
            <td>Tarjeta Gráfica</td>
            <td><?= $nombresComponentes[5] ?></td>
            <td><a href="seleccionarComponente.php?componente=tarjeta_grafica">Seleccionar</td>
        </tr>
    </table>
</body>