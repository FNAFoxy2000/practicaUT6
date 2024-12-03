<?php
session_start();
require_once "BD.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <?php
    $usuario = $_SESSION["usuario"];
    $nombre_tabla = "placa_base";
    $componentes = BD::getTablaComponente($nombre_tabla);
    ?>
    <table>
        <thead>
            <td>Nombre</td>
            <td>Precio</td>
            <td>Marca</td>
        </thead>
        <?php foreach ($componentes as $c): ?>
            <tr>
                <td><?= $c["placa_nombre"] ?></td>
                <td><?= $c["placa_precio"] ?> €</td>
                <td></td>
                <td><a href="pagOrdenador.php?nombre_tabla=<?php $nombre_tabla ?>&componente_id=<?= $c[$nombre_tabla."_id"] ?>&tipo_componente=placa_id">Eliminar</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
    $nombre_tabla = "caja";
    $componentes = BD::getTablaComponente($nombre_tabla);
    ?>
    <table>
        <thead>
            <td>Nombre</td>
            <td>Precio</td>
            <td>Marca</td>
        </thead>
        <?php foreach ($componentes as $c): ?>
            <tr>
                <td><?= $c["caja_nombre"] ?></td>
                <td><?= $c["caja_precio"] ?> €</td>
                <td></td>
                <td><a href="listadoComponentes.php?nombre_tabla=<?= $nombre_tabla?>&caja_id=<?php $c["caja_id"]?>">Eliminar</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
    $nombre_tabla = "disco_duro";
    $componentes = BD::getTablaComponente($nombre_tabla);
    ?>
    <table>
        <thead>
            <td>Nombre</td>
            <td>Capacidad</td>
            <td>Tipo</td>
            <td>Precio</td>
            <td>Marca</td>
        </thead>
        <?php foreach ($componentes as $c): ?>
            <tr>
                <td><?= $c["discoDuro_nombre"] ?></td>
                <td><?= $c["capacidad"] ?></td>
                <td><?= $c["tipo"] ?></td>
                <td><?= $c["discoDuro_precio"] ?> €</td>
                <td></td>
                <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
    $nombre_tabla = "procesador";
    $componentes = BD::getTablaComponente($nombre_tabla);
    ?>
    <table>
        <thead>
            <td>Nombre</td>
            <td>GHz</td>
            <td>Núcleos</td>
            <td>Precio</td>
            <td>Marca</td>
        </thead>
        <?php foreach ($componentes as $c): ?>
            <tr>
                <td><?= $c["proc_nombre"] ?></td>
                <td><?= $c["gHz"] ?></td>
                <td><?= $c["nucleos"] ?></td>
                <td><?= $c["proc_precio"] ?> €</td>
                <td></td>

                <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
    $nombre_tabla = "ram";
    $componentes = BD::getTablaComponente($nombre_tabla);
    ?>
    <table>
        <thead>
            <td>Nombre</td>
            <td>Capacidad</td>
            <td>MHz</td>
            <td>Precio</td>
            <td>Marca</td>
        </thead>
        <?php foreach ($componentes as $c): ?>
            <tr>
                <td><?= $c["ram_nombre"] ?></td>
                <td><?= $c["ram_gb"] ?></td>
                <td><?= $c["ram_mhz"] ?></td>
                <td><?= $c["ram_precio"] ?> €</td>
                <td></td>

                <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
    $nombre_tabla = "tarjeta_grafica";
    $componentes = BD::getTablaComponente($nombre_tabla);
    ?>
    <table>
        <thead>
            <td>Nombre</td>
            <td>Capacidad</td>
            <td>RTX</td>
            <td>Precio</td>
            <td>Marca</td>
        </thead>
        <?php foreach ($componentes as $c): ?>
            <tr>
                <td><?= $c["grafica_nombre"] ?></td>
                <td><?= $c["grafica_Gb"] ?></td>
                <td><?= $c["rtx"] ? "Si" : "No" ?></td>
                <td><?= $c["grafica_precio"] ?> €</td>
                <td></td>

                <td><a href="pagOrdenador.php?grafica_nombre=<?= $c["grafica_nombre"] ?>">Eliminar</td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>