<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['nombre']) && isset($data['apellido']) && isset($data['correo']) && isset($data['clave']) && isset($data['sueldomensual'])) {
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $correo = $data['correo'];
    $clave = md5($data['clave']);
    $tipousuario = "cliente";
    $sueldomensual = $data['sueldomensual'];
    $fecharegistro = date('Y-m-d H:i:s');
    $respuesta = registrarNuevoUsuario($nombre, $apellido, $correo, $clave, $tipousuario, $sueldomensual, $fecharegistro);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}

echo json_encode($respuesta);
?>
