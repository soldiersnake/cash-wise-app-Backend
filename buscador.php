<?php
include_once "cors.php";
include_once "funciones.php";
// $respuesta=buscador("Ropa",2);
header("Content-Type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

if ( isset($data['filtro']) && isset($data['idusuario']) ) {
    $filtro = $data['filtro'];
    $idusuario = $data['idusuario'];
    
    $respuesta = buscador($filtro, $idusuario);
} else {
    $respuesta = array('mensaje' => 'Faltan datos requeridos');
}
echo json_encode($respuesta);
?>
