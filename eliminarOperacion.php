<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_operacion'])  &&  isset($data['idusuario'])  ) {
    $id_operacion = $data['id_operacion'];
    $idusuario = $data['idusuario'];
    
    $respuesta = eliminarOperacion($id_operacion,$idusuario);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}
echo json_encode($respuesta);
?>
