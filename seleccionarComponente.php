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
    require_once "BD.php";
    if (isset($_GET["componente"])) {
        $nombre_tabla = $_GET["componente"];
        $componentes = BD::getTablaComponente($nombre_tabla);
        //var_dump($componentes);
        if ($nombre_tabla == "placa_base") {
            // Tabla Placa base
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
                        <td><?= $c["placa_precio"] ?></td>
                        <td></td>

                        <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
                    </tr>
                <?php endforeach; ?>
            </table>
<?php
        }
        if ($nombre_tabla == "caja") {
            // Tabla Placa base
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
                        <td><?= $c["caja_precio"] ?></td>
                        <td></td>
                        <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
                    </tr>
                <?php endforeach; ?>
            </table>
<?php
        }
        if ($nombre_tabla == "disco_duro") {
            // Tabla Disco duro
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
                        <td><?= $c["discoDuro_precio"] ?></td>
                        <td></td>
                        <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php
        }

        if ($nombre_tabla == "procesador") {
            // Tabla Procesador
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
                        <td><?= $c["procesador_precio"] ?></td>
                        <td></td>

                        <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
                    </tr>
                <?php endforeach; ?>
            </table>
<?php
        }
        if ($nombre_tabla == "ram") {
            // Tabla RAM
        ?>
            <table>
                <thead>
                    <td>Nombre</td>
                    <td>Capacidad</td>
                    <td>Precio</td>
                    <td>Marca</td>
                </thead>
                <?php foreach ($componentes as $c): ?>
                    <tr>
                        <td><?= $c["ram_nombre"] ?></td>
                        <td><?= $c["ram_gb"] ?></td>
                        <td><?= $c["ram"] ?></td>
                        <td><?= $c["caja_precio"] ?></td>
                        <td></td>

                        <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
                    </tr>
                <?php endforeach; ?>
            </table>
<?php
        }

        if ($nombre_tabla == "tarjeta_grafica") {
            // Tabla Tarjeta Gráfica
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
                        <td><?= $c["rtx"] ? "Tiene RTX" : "No tiene RTX" ?></td>
                        <td><?= $c["grafica_precio"] ?></td>
                        <td></td>

                        <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
                    </tr>
                <?php endforeach; ?>
            </table>
<?php
        }
    }
?>
</body>