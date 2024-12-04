<?php
session_start();
require_once "BD.php";
//Borrar componente
if (isset($_GET['nombre_tabla'], $_GET['id'], $_GET['tipo_componente'])) {
    $nombre_tabla = $_GET['nombre_tabla'];
    $tipo_componente = $_GET['tipo_componente'];
    $id = (int) $_GET['id'];
    BD::borrarComponente($nombre_tabla, $tipo_componente, $id);
    header("Location: listadoComponentes.php");
}
//Añadir placa base
if (isset($_POST["placa_nombre"]) && isset($_POST["placa_precio"]) && isset($_POST["placa_marca"])) {
    $placa_nombre = $_GET["placa_nombre"];
    $placa_precio = $_GET["placa_precio"];
    $placa_marca = $_GET["placa_marca"];
    BD::anadirPlacaBase($nombre_placa, $placa_precio, $placa_marca);
    header("Location: listadoComponentes.php");
}
//Añadir caja
if (isset($_POST["caja_nombre"]) && isset($_POST["caja_precio"]) && isset($_POST["caja_marca"])) {
    $caja_nombre = $_GET["caja_nombre"];
    $caja_precio = $_GET["caja_precio"];
    $caja_marca = $_GET["caja_marca"];
    BD::anadirCaja($caja_nombre, $caja_precio, $caja_marca);
    header("Location: listadoComponentes.php");
}
//Añadir Disco duro

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

        td,
        th {
            border: 2px solid black;
            text-align: center;
        }

        .contenedorTablas {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: flex-start;
        }
    </style>
</head>

<body>
    <?php
    $usuario = $_SESSION["usuario"];
    $nombre_tabla = "placa_base";
    $componentes = BD::getTablaComponente($nombre_tabla);
    ?>
    <div class="contenedorTablas">
        <table>
            <form action="listadoComponentes.php" method="post">
            <thead>
                <th colspan="3">Placas base</th>
            </thead>
                <thead>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Marca</th>
                </thead>
                <?php foreach ($componentes as $c): ?>
                    <tr>
                        <td><?= $c["placa_nombre"] ?></td>
                        <td><?= $c["placa_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>
                        <td><a href="anadirComponente.php?nombre_tabla=placa_base&id=<?= $c["placa_id"] ?>&tipo_componente=placa_id">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td><input type="text" name="placa_nombre"></td>
                    <td><input type="number" name="placa_precio"></td>
                    <td><input type="text" name="placa_marca"></td>
                    <td><input type="submit" name="" value="Añadir"></td>
                </tr>
            </form>
        </table>
        <br>

        <?php
        $nombre_tabla = "caja";
        $componentes = BD::getTablaComponente($nombre_tabla);
        ?>

        <table>
            <form action="listadoComponentes.php" method="post">
            <thead>
                <th colspan="3">Cajas</th>
            </thead>
                <thead>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Marca</th>
                </thead>
                <?php foreach ($componentes as $c): ?>
                    <tr>
                        <td><?= $c["caja_nombre"] ?></td>
                        <td><?= $c["caja_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>
                        <td><a href="listadoComponentes.php?nombre_tabla=caja&id=<?= $c["caja_id"] ?>&tipo_componente=caja_id">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td><input type="text" name="caja_nombre"></td>
                    <td><input type="number" name="caja_precio"></td>
                    <td><input type="number" name="caja_marca"></td>
                    <td><input type="submit" name="" value="Añadir"></td>
                </tr>
            </form>

        </table>
        <?php
        $nombre_tabla = "disco_duro";
        $componentes = BD::getTablaComponente($nombre_tabla);
        ?>
        <table>
            <form action="listadoComponentes.php" method="post">
            <thead>
                <th colspan="5">Discos duros</th>
            </thead>
                <thead>
                    <th>Nombre</th>
                    <th>Capacidad</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                    <th>Marca</th>
                </thead>
                <?php foreach ($componentes as $c): ?>
                    <tr>
                        <td><?= $c["discoDuro_nombre"] ?></td>
                        <td><?= $c["capacidad"] ?></td>
                        <td><?= $c["tipo"] ?></td>
                        <td><?= $c["discoDuro_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>
                        <td><a href="listadoComponentes.php?nombre_tabla=disco_duro&id=<?= $c["discoDuro_id"] ?>&tipo_componente=discoDuro_id">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td><input type="text" name="caja_nombre"></td>
                    <td><input type="text" name="caja_precio"></td>
                    <td><input type="text" name="caja_marca"></td>
                    <td><input type="submit" name="" value="Añadir"></td>
                </tr>
            </form>
        </table>
        <?php
        $nombre_tabla = "procesador";
        $componentes = BD::getTablaComponente($nombre_tabla);
        ?>
        <table>
            <thead>
                <th colspan="5">Procesadores</th>
            </thead>
            <thead>
                <th>Nombre</th>
                <th>GHz</th>
                <th>Núcleos</th>
                <th>Precio</th>
                <th>Marca</th>
            </thead>
            <?php foreach ($componentes as $c): ?>
                <tr>
                    <td><?= $c["proc_nombre"] ?></td>
                    <td><?= $c["gHz"] ?></td>
                    <td><?= $c["nucleos"] ?></td>
                    <td><?= $c["proc_precio"] ?> €</td>
                    <td><?= $c["marca_nombre"] ?></td>
                    <td><a href="listadoComponentes.php?nombre_tabla=procesador&id=<?= $c["proc_id"] ?>&tipo_componente=proc_id">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
        $nombre_tabla = "ram";
        $componentes = BD::getTablaComponente($nombre_tabla);
        ?>
        <table>
            <thead>
                <th colspan="5">RAM</th>
            </thead>
            <thead>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>MHz</th>
                <th>Precio</th>
                <th>Marca</th>
            </thead>
            <?php foreach ($componentes as $c): ?>
                <tr>
                    <td><?= $c["ram_nombre"] ?></td>
                    <td><?= $c["ram_gb"] ?></td>
                    <td><?= $c["ram_mhz"] ?></td>
                    <td><?= $c["ram_precio"] ?> €</td>
                    <td><?= $c["marca_nombre"] ?></td>
                    <td><a href="listadoComponentes.php?nombre_tabla=ram&id=<?= $c["ram_id"] ?>&tipo_componente=ram_id">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
        $nombre_tabla = "tarjeta_grafica";
        $componentes = BD::getTablaComponente($nombre_tabla);
        ?>
        <table>
            <thead>
                <th colspan="5">Tarjetas gráficas</th>
            </thead>
            <thead>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>RTX</th>
                <th>Precio</th>
                <th>Marca</th>
            </thead>
            <?php foreach ($componentes as $c): ?>
                <tr>
                    <td><?= $c["grafica_nombre"] ?></td>
                    <td><?= $c["grafica_Gb"] ?></td>
                    <td><?= $c["rtx"] ? "Si" : "No" ?></td>
                    <td><?= $c["grafica_precio"] ?> €</td>
                    <td><?= $c["marca_nombre"] ?></td>
                    <td><a href="listadoComponentes.php?nombre_tabla=tarjeta_grafica&id=<?= $c["grafica_id"] ?>&tipo_componente=grafica_id">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <br>
    <form action="pagAdmin.php" method="post">
        <button type="submit">Volver atrás</button>
    </form>
    <br>
    <form action="index.php" method="post">
        <button type="submit">Volver al inicio</button>
    </form>
</body>