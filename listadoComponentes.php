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
if (isset($_POST["placa_nombre"]) && isset($_POST["placa_precio"]) && isset($_POST["marca_id"])) {
    $placa_nombre = $_POST["placa_nombre"];
    $placa_precio = $_POST["placa_precio"];
    $marca_id = $_POST["marca_id"];
    BD::anadirPlacaBase($placa_nombre, $placa_precio, $marca_id);
    header("Location: listadoComponentes.php");
}
//Añadir caja
if (isset($_POST["caja_nombre"]) && isset($_POST["caja_precio"]) && isset($_POST["marca_id"])) {
    $caja_nombre = $_POST["caja_nombre"];
    $caja_precio = $_POST["caja_precio"];
    $marca_id = $_POST["marca_id"];
    BD::anadirCaja($caja_nombre, $caja_precio, $marca_id);
    header("Location: listadoComponentes.php");
}
//Añadir Disco duro
if (isset($_POST["discoDuro_nombre"]) && isset($_POST["capacidad"]) && isset($_POST["tipo"]) && isset($_POST["discoDuro_precio"]) && isset($_POST["marca_id"])) {
    $discoDuro_nombre = $_POST["discoDuro_nombre"];
    $capacidad = $_POST["capacidad"];
    $tipo = $_POST["tipo"];
    $discoDuro_precio = $_POST["discoDuro_precio"];
    $marca_id = $_POST["marca_id"];
    BD::anadirDiscoDuro($discoDuro_nombre, $capacidad, $tipo, $discoDuro_precio, $marca_id);
    header("Location: listadoComponentes.php");
}

//Añadir Procesador
if (isset($_POST["proc_nombre"]) && isset($_POST["gHz"]) && isset($_POST["nucleos"]) && isset($_POST["proc_precio"]) && isset($_POST["marca_id"])) {
    $proc_nombre = $_POST["proc_nombre"];
    $gHz = $_POST["gHz"];
    $nucleos = $_POST["nucleos"];
    $proc_precio = $_POST["proc_precio"];
    $marca_id = $_POST["marca_id"];
    BD::anadirProcesador($proc_nombre, $gHz, $nucleos, $proc_precio, $marca_id);
    header("Location: listadoComponentes.php");
}

//Añadir RAM
if (isset($_POST["ram_nombre"]) && isset($_POST["ram_gb"]) && isset($_POST["ram_mhz"]) && isset($_POST["ram_precio"]) && isset($_POST["marca_id"])) {
    $ram_nombre = $_POST["ram_nombre"];
    $ram_gb = $_POST["ram_gb"];
    $ram_mhz = $_POST["ram_mhz"];
    $ram_precio = $_POST["ram_precio"];
    $marca_id = $_POST["marca_id"];
    BD::anadirRam($ram_nombre, $ram_gb, $ram_mhz, $ram_precio, $marca_id);
    header("Location: listadoComponentes.php");
}
//Añadir Gráfica
if (isset($_POST["grafica_nombre"]) && isset($_POST["grafica_Gb"]) && isset($_POST["rtx"]) && isset($_POST["grafica_precio"]) && isset($_POST["marca_id"])) {
    $grafica_nombre = $_POST["grafica_nombre"];
    $grafica_Gb = $_POST["grafica_Gb"];
    $rtx = $_POST["rtx"];
    $grafica_precio = $_POST["grafica_precio"];
    $marca_id = $_POST["marca_id"];
    BD::anadirRam($grafica_nombre, $grafica_Gb, $rtx, $grafica_precio, $marca_id);
    header("Location: listadoComponentes.php");
}

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

        select {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    $usuario = $_SESSION["usuario"];
    $nombre_tabla = "placa_base";
    $componentes = BD::getTablaComponente($nombre_tabla);
    $marcas = BD::getMarcas();
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
                        <td><a href="listadoComponentes.php?nombre_tabla=placa_base&id=<?= $c["placa_id"] ?>&tipo_componente=placa_id">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
                <!-- Añadir -->
                <tr>
                    <td><input type="text" name="placa_nombre"></td>
                    <td><input type="number" name="placa_precio" step="any" required min="0"></td>
                    <td><select name="marca_id">
                            <option value="" selected disabled hidden> - </option>
                            <?php foreach ($marcas as $m): ?>
                                <option value=<?= $m["marca_id"] ?>><?= $m["marca_nombre"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Añadir"></td>
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
                <!-- Añadir -->
                <tr>
                    <td><input type="text" name="caja_nombre"></td>
                    <td><input type="number" name="caja_precio"></td>
                    <td><select name="marca_id">
                            <option value="" selected disabled hidden> - </option>
                            <?php foreach ($marcas as $m): ?>
                                <option value=<?= $m["marca_id"] ?>><?= $m["marca_nombre"] ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Añadir"></td>
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
                        <td><?= $c["capacidad"] ?> GB</td>
                        <td><?= $c["tipo"] ?></td>
                        <td><?= $c["discoDuro_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>
                        <td><a href="listadoComponentes.php?nombre_tabla=disco_duro&id=<?= $c["discoDuro_id"] ?>&tipo_componente=discoDuro_id">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
                <!-- Añadir -->
                <tr>
                    <td><input type="text" name="discoDuro_nombre"></td>
                    <td><input type="text" name="capacidad"> GB</td>
                    <td><select name="tipo">
                            <option value="" selected disabled hidden> - </option>
                            <option value="HDD">HDD</option>
                            <option value="SSD">SSD</option>
                        </select>
                    </td>
                    <td><input type="number" name="discoDuro_precio"></td>
                    <td><select name="marca_id">
                            <option value="" selected disabled hidden> - </option>
                            <?php foreach ($marcas as $m): ?>
                                <option value=<?= $m["marca_id"] ?>><?= $m["marca_nombre"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Añadir"></td>
                </tr>
            </form>
        </table>
        <?php
        $nombre_tabla = "procesador";
        $componentes = BD::getTablaComponente($nombre_tabla);
        ?>
        <table>
            <form action="listadoComponentes.php" method="post">
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
                <!-- Añadir -->
                <tr>
                    <td><input type="text" name="proc_nombre"></td>
                    <td><input type="text" name="gHz"></td>
                    <td><input type="text" name="nucleos"></td>
                    <td><input type="text" name="proc_precio"></td>
                    <td><select name="marca_id">
                            <option value="" selected disabled hidden> - </option>
                            <?php foreach ($marcas as $m): ?>
                                <option value=<?= $m["marca_id"] ?>><?= $m["marca_nombre"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Añadir"></td>
                </tr>
            </form>
        </table>
        <?php
        $nombre_tabla = "ram";
        $componentes = BD::getTablaComponente($nombre_tabla);
        ?>
        <table>
            <form action="listadoComponentes.php" method="post">
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
                        <td><?= $c["ram_gb"] ?> GB</td>
                        <td><?= $c["ram_mhz"] ?></td>
                        <td><?= $c["ram_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>
                        <td><a href="listadoComponentes.php?nombre_tabla=ram&id=<?= $c["ram_id"] ?>&tipo_componente=ram_id">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
                <!-- Añadir -->
                <tr>
                    <td><input type="text" name="ram_nombre"></td>
                    <td><select name="ram_gb">
                            <option value="" selected disabled hidden> - </option>
                            <option value="4">4</option>
                            <option value="8">8</option>
                            <option value="16">16</option>
                            <option value="32">32</option>
                        </select> GB
                    </td>
                    <td><input type="text" name="ram_mhz"></td>
                    <td><input type="text" name="ram_precio"></td>
                    <td><select name="marca_id">
                            <option value="" selected disabled hidden> - </option>
                            <?php foreach ($marcas as $m): ?>
                                <option value=<?= $m["marca_id"] ?>><?= $m["marca_nombre"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Añadir"></td>
                </tr>
            </form>
        </table>
        <?php
        $nombre_tabla = "tarjeta_grafica";
        $componentes = BD::getTablaComponente($nombre_tabla);
        ?>
        <table>
            <form action="listadoComponentes.php" method="post">
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
                        <td><?= $c["grafica_Gb"] ?> GB</td>
                        <td><?= $c["rtx"] ? "Si" : "No" ?></td>
                        <td><?= $c["grafica_precio"] ?> €</td>
                        <td><?= $c["marca_nombre"] ?></td>
                        <td><a href="listadoComponentes.php?nombre_tabla=tarjeta_grafica&id=<?= $c["grafica_id"] ?>&tipo_componente=grafica_id">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
                <!-- Añadir -->
                <tr>
                    <td><input type="text" name="grafica_nombre"></td>
                    <td><input type="number" name="grafica_Gb"> GB</td>
                    <td><select name="rtx">
                            <option value="" selected disabled hidden> - </option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </td>
                    <td><input type="number" name="grafica_precio"></td>
                    <td><select name="marca_id">
                            <option value="" selected disabled hidden> - </option>
                            <?php foreach ($marcas as $m): ?>
                                <option value=<?= $m["marca_id"] ?>><?= $m["marca_nombre"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Añadir"></td>
                </tr>
            </form>
        </table>
        <?php
        //marcas
        $nombre_tabla = "marca";
        $componentes = BD::getTablaComponente($nombre_tabla);
        ?>
        <table>
            <form action="listadoComponentes.php" method="post">
                <thead>
                    <th colspan="1">Marcas</th>
                </thead>
                <!-- <thead>
                    <th>Nombre</th>
                </thead> -->
                <?php foreach ($componentes as $c): ?>
                    <tr>

                        <td><?= $c["marca_nombre"] ?></td>
                        <td><a href="listadoComponentes.php?nombre_tabla=marca&id=<?= $c["marca_id"] ?>&tipo_componente=marca_id">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td><input type="text" name="marca_nombre"></td>
                    <td><input type="submit" value="Añadir"></td>
                </tr>
            </form>
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
<?php
//PONER SELECTS EN MARCAS y RTX, TIPO DISCO
// añadir un comp
// añadir tabla marcas para añadirlas