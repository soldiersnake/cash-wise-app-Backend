<?php
include_once "cors.php";
include_once "funciones.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['descripcion']) && isset($data['monto']) && isset($data['fuente']) && isset($data['idusuario'])) {
    $descripcion = $data['descripcion'];
    $monto = $data['monto'];
    $fuente = $data['fuente'];
    $idusuario = $data['idusuario'];

    $respuesta = registrarIngreso($fuente, $descripcion, $monto, $idusuario);
} else {
    $respuesta = array('mensaje' => 'Complete todos los campos');
}

echo json_encode($respuesta);
?>
