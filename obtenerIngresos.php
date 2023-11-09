<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['idusuario'])) {
    $idusuario = $data['idusuario'];

    $respuesta = array('mensaje' => obtenerIngresos($idusuario));
} else {
    $respuesta = array('mensaje' => 'Error al cargar los ingreso');
}

echo json_encode($respuesta);
?>