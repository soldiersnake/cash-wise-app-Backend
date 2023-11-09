<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_gasto']) && isset($data['descripcion']) &&  isset($data['color']) ) {
    $id_gasto = $data['id_gasto'];
    $descripcion = $data['descripcion'];
    $color = $data['color'];
    
    $respuesta = editarGasto($id_gasto,$descripcion,$color);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}

echo json_encode($respuesta);
?>
