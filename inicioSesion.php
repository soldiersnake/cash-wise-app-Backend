<?php
include_once "cors.php";
include_once "funciones.php";

session_start();

$_SESSION['idSesion'] = session_create_id();
echo json_encode($_SESSION['idSesion']);

?>