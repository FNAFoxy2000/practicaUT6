<?php
require_once "BD.php";
BD::Conectar();
$usuarios = BD::getListaUsuarios();
if(isset($_GET["usuario_nombre"])){
    $usuario = $_GET["usuario_nombre"];
    BD::borrarUsuario($usuario);
    header("Refresh:0");
}
var_dump($usuarios);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            border: 2px solid black;
        }
        td{
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <table>
        <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u["usuario_nombre"] ?></td>
                <td><?= $u["email"] ?></td>
                <td><?= $u["admin"] ?></td>
                <td><a href="listadoUsuarios.php?usuario_nombre=<?= $u["usuario_nombre"]?>">Eliminar</td>
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
