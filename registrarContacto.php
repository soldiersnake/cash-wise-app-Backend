<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['nombre']) && isset($data['apellido']) && isset($data['correo']) && isset($data['mensaje']) ) {
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $correo = $data['correo'];
    $mensaje = $data['mensaje'];
    
    $respuesta = registrarContacto($nombre,$apellido,$correo,$mensaje);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}
echo json_encode($respuesta);
?>
