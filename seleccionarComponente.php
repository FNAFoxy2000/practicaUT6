<?php
require_once "BD.php";
if (isset($_GET["componente"])) {
    $nombre_tabla = $_GET["componente"];
    $componentes = BD::getTablaComponente($nombre_tabla);
    var_dump($componentes);

    if ($nombre_tabla == "disco_duro") {
        // Tabla disco duro
?>
        <!DOCTYPE html>
        <html lang="en">

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
        </body>
    <?php
    }
    if ($nombre_tabla == "placa_base") {
        // Tabla disco duro
    ?>
        <!DOCTYPE html>
        <html lang="en">

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
        </body>
<?php
    }
}
?>