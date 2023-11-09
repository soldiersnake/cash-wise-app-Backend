<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if ( isset($data['id_ingreso']) ) {
    $id_ingreso = $data['id_ingreso'];
    
    $respuesta = eliminarIngreso($id_ingreso);
} else {
    $respuesta = array('mensaje' => 'Complete todos los campos');
}

echo json_encode($respuesta);
?>
