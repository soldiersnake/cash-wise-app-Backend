<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_ingreso']) && isset($data['descripcion']) &&  isset($data['monto']) &&  isset($data['fuente'])  ) {
    $id_ingreso = $data['id_ingreso'];
    $descripcion = $data['descripcion'];
    $monto = $data['monto'];
    $fuente = $data['fuente'];
    
    $respuesta = editarIngreso($id_ingreso,$descripcion,$monto,$fuente);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}
echo json_encode($respuesta);
?>
