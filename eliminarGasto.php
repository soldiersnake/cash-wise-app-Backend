<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if ( isset($data['id_gasto']) ) {
    $id_gasto = $data['id_gasto'];
    
    $respuesta = eliminarGasto($id_gasto);
} else {
    $respuesta = array('mensaje' => 'Complete todos los campos');
}
// $respuesta =editarOperacion(1,"3500",date('Y-m-d H:i:s'),8);
echo json_encode($respuesta);
?>
