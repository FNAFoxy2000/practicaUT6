<?php
require_once "BD.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>

<body>


    <?php
    if (isset($_POST["cerrarSesion"])) {
        session_unset();
        session_destroy();
        echo "Sesión cerrada";
    }

    // Si tiene email significa que está registrandose  
    if (isset($_POST["email"]) && isset($_POST["usuario"]) && isset($_POST["password"])) {
        // Insert a base de datos
        $registro = BD::RegistrarUsuario($_POST["usuario"], $_POST["password"], $_POST["email"]);
        if ($registro) {
            echo "<p>Usuario registrado correctamente</p>";
        } else {
            echo "<p>No se pudo registrar</p>";
        }
    }

    // Si NO tiene email significa que quiere iniciar sesion
    if (!isset($_POST["email"]) && isset($_POST["usuario"]) && isset($_POST["password"])) {
        $login = BD::Login($_POST["usuario"], $_POST["password"]);
        if ($login) {
            $_SESSION["usuario"] = $_POST["usuario"];
            echo "<p>Sesion iniciada correctamente</p>";
        } else {
            echo "<p>No se pudo iniciar sesion</p>";
        }
    }


    // Si no tiene la sesion iniciada deberá registrarse o iniciar sesion
    if (!isset($_SESSION["usuario"])) {
    ?>
        <h1>Configurador de Ordenadores</h1>
        <form action="registro.php" method="POST">
            <button type="submit" value="registro">Registrarse</button>
        </form>
        <form action="login.php" method="POST">
            <button type="submit" value="login">Iniciar sesión</button>
        </form>
    <?php
    } else if (isset($_SESSION["usuario"])) { // Si tiene iniciada sesión
    ?>
        <h1>Configurador de Ordenadores</h1>
        <form action="pagOrdenador.php" method="POST">
            <button type="submit">Mi ordenador</button>
        </form>
        <?php
        // Comprobar si es admin
        if (BD::esAdmin($_SESSION["usuario"])) {
        ?>
            <form action="pagAdmin.php" method="POST">
                <button type="submit">Administrar</button>
            </form>
        <?php
        }
        ?>
        <form action="index.php" method="POST">
            <button type="submit" name="cerrarSesion">Cerrar Sesion</button>
        </form>
    <?php
    }
    ?>
</body>

</html>