<?php
require_once "BD.php";
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
<?php
}

// Si tiene la sesion iniciada
if (isset($_SESSION["usuario"])) {
    // Comprobar si es admin

    // Si es admin Redirigir a ventana de admin

    // Si no es admin Redirigir a ventana usuario

}

// Si tiene email significa que está registrandose  
if (isset($_POST["email"]) && isset($_POST["usuario"]) && isset($_POST["password"])) {   
    // Insert a base de datos
    $registro = BD::RegistrarUsuario($_POST["usuario"], $_POST["password"], $_POST["email"]);
    if($registro){
        echo "<p>Usuario registrado correctamente</p>";
    } else{
        echo "<p>No se pudo registrar</p>";
    }
}

// Si NO tiene email significa que quiere iniciar sesion
if (!isset($_POST["email"]) && isset($_POST["usuario"]) && isset($_POST["password"])) {    
    $login = BD::Login($_POST["usuario"], $_POST["password"]);
    if($login){
        echo "<p>Sesion iniciada correctamenet</p>";
    } else{
        echo "<p>No se pudo iniciar sesion</p>";
    }
}

?>