<?php
include_once "cors.php";

if (!isset($_GET["user"])) {
    echo json_encode(null);
    exit;
}

$user = $_GET["user"];

include_once "funciones.php";

$usuario = obtenerUsuario($user);
echo json_encode($usuario);
?>