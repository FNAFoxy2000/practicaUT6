<?php
session_start();
require_once "BD.php";
$usuario = $_SESSION["usuario"];
$usuario_id = (int)BD::getUsuarioId($usuario);

if(isset($_GET["tipo_componente"]) && isset($_GET["componente_id"])){
    BD::agregarComponenteOrdenador($usuario_id, $_GET["tipo_componente"], $_GET["componente_id"]);
}

$ordenador = BD::getOrdenador($usuario_id);
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
            <td></td>
            <td><a href="seleccionarComponente.php?componente=placa_base">Seleccionar</td>
        </tr>
        <tr>
            <td>Caja</td>
            <td></td>
            <td><a href="seleccionarComponente.php?componente=caja">Seleccionar</td>
        </tr>
        <tr>
            <td>Disco Duro</td>
            <td></td>
            <td><a href="seleccionarComponente.php?componente=disco_duro">Seleccionar</td>
        </tr>
        <tr>
            <td>Procesador</td>
            <td></td>
            <td><a href="seleccionarComponente.php?componente=procesador">Seleccionar</td>
        </tr>
        <tr>
            <td>RAM</td>
            <td></td>
            <td><a href="seleccionarComponente.php?componente=ram">Seleccionar</td>
        </tr>
        <tr>
            <td>Tarjeta Gráfica</td>
            <td></td>
            <td><a href="seleccionarComponente.php?componente=tarjeta_grafica">Seleccionar</td>
        </tr>
    </table>
</body>