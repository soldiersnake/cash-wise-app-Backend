<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['monto']) && isset($data['idusuario']) && isset($data['tipo_gasto_id'])) {
    $monto = $data['monto'];
    $idusuario = $data['idusuario'];
    $tipo_gasto_id = $data['tipo_gasto_id'];
    $fechaoperacion = date('Y-m-d H:i:s');

    $respuesta = editarGasto($monto, $fechaoperacion, $idusuario, $tipo_gasto_id);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}
echo json_encode($respuesta);
?>
