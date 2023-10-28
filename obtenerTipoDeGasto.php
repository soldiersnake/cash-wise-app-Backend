<?php
include_once "cors.php";
include_once "funciones.php";

$tipo_de_gasto = obtenerTipoDeGasto();
echo json_encode($tipo_de_gasto);
?>