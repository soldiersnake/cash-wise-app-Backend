<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if ( isset($data['descripcion']) &&  isset($data['color']) ) {
    $descripcion = $data['descripcion'];
    $color = $data['color'];
    
    $respuesta = registrarTipoGasto($descripcion,$color);
} else {
    $respuesta = array('mensaje' => 'Complete todos los campos');
}

echo json_encode($respuesta);
?>
