<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi ordenador</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    
</body>
</html>
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
            <td><?= $ordenador["placa_nombre"] ?></td>
            <td><a href="seleccionarComponente.php?componente=placa_base">Seleccionar</td>
        </tr>
        <tr>
            <td>Caja</td>
            <td><?= $ordenador["caja_nombre"] ?></td>
            <td><a href="seleccionarComponente.php?componente=caja">Seleccionar</td>
        </tr>
        <tr>
            <td>Disco Duro</td>
            <td><?= $ordenador["discoDuro_nombre"] ?></td>
            <td><a href="seleccionarComponente.php?componente=disco_duro">Seleccionar</td>
        </tr>
        <tr>
            <td>Procesador</td>
            <td><?= $ordenador["proc_nombre"] ?></td>
            <td><a href="seleccionarComponente.php?componente=procesador">Seleccionar</td>
        </tr>
        <tr>
            <td>RAM</td>
            <td><?= $ordenador["ram_nombre"] ?></td>
            <td><a href="seleccionarComponente.php?componente=ram">Seleccionar</td>
        </tr>
        <tr>
            <td>Tarjeta Gráfica</td>
            <td><?= $ordenador["grafica_nombre"] ?></td>
            <td><a href="seleccionarComponente.php?componente=tarjeta_grafica">Seleccionar</td>
        </tr>
    </table>
    <br>
    <form action="index.php" method="post">
        <button type="submit">Volver al inicio</button>
    </form>

</body>