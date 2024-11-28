<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    // Si no tiene la sesion iniciada deberá registrarse o iniciar sesion
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

if (isset($_SESSION["usuario"])){
    // Comprobar si es admin

    // Si es admin Redirigir a ventana de admin

    // Si no es admin Redirigir a ventana usuario
    
}

if(isset($_POST["email"])){
    // Si tiene email significa que está registrandose

    // Insert a base de datos
}
if(!isset($_POST["email"])){
    // Si NO tiene email significa que está logeando

    // Comprobar usuario y contraseña con la base de datos
}