<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['idusuario']) && isset($data['nombre']) && isset($data['apellido']) && isset($data['sueldo'])) {
    $idusuario = $data['idusuario'];
    $nombre = $data['nombre'];
    $apellido = $data['apellido'];
    $sueldo = $data['sueldo'];

    $respuesta = editarUsuario($idusuario, $nombre, $apellido, $sueldo);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}

echo json_encode($respuesta);
?>
