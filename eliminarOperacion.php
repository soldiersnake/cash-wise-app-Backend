<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_operacion'])    ) {
    $id_operacion = $data['id_operacion'];
    
    $respuesta = eliminarOperacion($id_operacion);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}

echo json_encode($respuesta);
?>
