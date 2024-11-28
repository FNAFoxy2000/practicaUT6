<?php
session_start();

if (!isset($_SESSION["usuario"])) {
?>
    <h1>Configurador de Ordenadores</h1>
    <form action="registro.php" method="POST">
        <button type="submit" value="registro">Registrarse</button>
    </form>
    <form action="login.php" method="POST">
        <button type="submit" value="login">Iniciar sesión</button>
    </form>
<?
}