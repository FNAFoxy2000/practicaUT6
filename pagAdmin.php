<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    
</body>
</html>
<?php
    echo "<h1>¿Qué gestión quiere hacer?</h1>";
?>
<form action="listadoUsuarios.php" method="get">
    <input type="submit" value="Listar usuarios">
</form>
<form action="listadoComponentes.php" method="get">
    <input type="submit" value="Listar componentes">
</form>
<form action="index.php" method="post">
        <button type="submit">Volver al inicio</button>
    </form>

