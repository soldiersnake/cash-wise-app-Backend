<?php
include_once "cors.php";
include_once "funciones.php";

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$correo = $_POST["correo"];
$mensaje = $_POST["mensaje"];
// $nombre = $_POST["nombre"];
// $apellido = $_POST["apellido"];
// $correo = $_POST["correo"];
// $mensaje = $_POST["mensaje"];


$respuesta = registrarContacto($nombre,$apellido,$correo,$mensaje );
echo json_encode($respuesta);
?>