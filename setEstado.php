<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['idusuario']) && isset($data['estado'])) {
    $idusuario = $data['idusuario'];
    $estado = $data['estado'];

    $respuesta = setEstado($idusuario, $estado);
} else {
    $respuesta = array('mensaje' => 'Error al cambiar el estado del usuario');
}

echo json_encode($respuesta);
?>
