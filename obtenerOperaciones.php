<?php
include_once "cors.php";
include_once "funciones.php";

$operaciones = obtenerOperaciones();
echo json_encode($operaciones);
?>