<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_operacion']) && isset($data['monto']) &&  isset($data['tipo_gasto_id']) ) {
    $id_operacion = $data['id_operacion'];
    $monto = $data['monto'];
    $tipo_gasto_id = $data['tipo_gasto_id'];
    $fechaoperacion = date('Y-m-d H:i:s');
    
    $respuesta = editarOperacion($id_operacion,$monto,$fechaoperacion,$tipo_gasto_id);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}

echo json_encode($respuesta);
?>
