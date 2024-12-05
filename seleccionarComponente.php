<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titulo segun el componente -->
    <title><?= str_replace("_"," ",ucfirst($_GET["componente"])) ?></title>
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
                        <td><?= $c["placa_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>

                        <td><a href="pagOrdenador.php?tipo_componente=placa_id&componente_id=<?= $c["placa_id"] ?>">Seleccionar</td>
                    </tr>
                <?php endforeach; ?>
            </table>
<?php
        }
        if ($nombre_tabla == "caja") {
            // Tabla Caja
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
                        <td><?= $c["marca_nombre"] ?></td>

                        <td><a href="pagOrdenador.php?tipo_componente=caja_id&componente_id=<?= $c["caja_id"] ?>">Seleccionar</td>
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
                        <td><?= $c["discoDuro_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>

                        <td><a href="pagOrdenador.php?tipo_componente=discoDuro_id&componente_id=<?= $c["discoDuro_id"] ?>">Seleccionar</td>
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
                        <td><?= $c["proc_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>

                        <td><a href="pagOrdenador.php?tipo_componente=proc_id&componente_id=<?= $c["proc_id"] ?>">Seleccionar</td>
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
                        <td><?= $c["marca_nombre"] ?></td>

                        <td><a href="pagOrdenador.php?tipo_componente=ram_id&componente_id=<?= $c["ram_id"] ?>">Seleccionar</td>
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
                        <td><?= $c["rtx"] ? "Si" : "No" ?></td>
                        <td><?= $c["grafica_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>

                        <td><a href="pagOrdenador.php?tipo_componente=grafica_id&componente_id=<?= $c["grafica_id"] ?>">Seleccionar</td>
                    </tr>
                <?php endforeach; ?>
            </table>
<?php
        }
    }
?>
<br>
    <form action="pagOrdenador.php" method="post">
        <button type="submit">Volver atrás</button>
    </form>
    <br>
    <form action="index.php" method="post">
        <button type="submit">Volver al inicio</button>
    </form>

</body>