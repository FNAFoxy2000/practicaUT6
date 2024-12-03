<?php
require_once "BD.php";
// Si recibe el usuario_nombre en el get significa que quiere eliminarlo
if (isset($_GET["usuario_nombre"])) {
    $usuario = $_GET["usuario_nombre"];
    BD::borrarUsuario($usuario);
}

// Cargar tabla usuarios
$usuarios = BD::getListaUsuarios();

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
            <td>Usuario</td>
            <td>Email</td>
            <td>Es admin</td>
            
        </thead>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u["usuario_nombre"] ?></td>
                <td><?= $u["email"] ?></td>
                <td><?= $u["admin"] ? "SI" : "NO" ?></td>
                <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"] ?>">Eliminar</td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form action="index.php" method="post">
        <button type="submit">Volver al inicio</button>
    </form>
    <form action="pagAdmin.php" method="post">
        <button type="submit">Volver atrás</button>
    </form>

</body>

</html>