<?php
session_start();
require_once "BD.php";
$usuario = $_SESSION["usuario"];
$usuario_id = (int)BD::getId($usuario);

$ordenador = BD::getOrdenador($usuario_id);
?>
<table>
    <th>
        <tr>Caja</tr>
        <tr>Disco duro</tr>
        <tr>Placa Base</tr>
        <tr>Procesador</tr>
        <tr>RAM</tr>
        <tr>Tarjeta Gráfica</tr>
    </th>

</table>