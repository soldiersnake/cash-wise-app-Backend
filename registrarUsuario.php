<?php
include_once "cors.php";
include_once "funciones.php";

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$correo = $_POST["correo"];
$clave = $_POST["clave"];
$fecharegistro = $_POST["fecharegistro"];
$tipousuario ="cliente";
$sueldomensual = $_POST["sueldomensual"];

$respuesta = registrarNuevoUsuario($nombre,$apellido,$correo,$clave,$fecharegistro,$tipousuario,$sueldomensual );
echo json_encode($respuesta);
?>