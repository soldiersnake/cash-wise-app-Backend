<?php
include_once "cors.php";

if (!isset($_GET["id"])) {
    echo json_encode(null);
    exit;
}

$id = $_GET["id"];

include_once "funciones.php";

$operaciones = obtenerOperaciones($id);
echo json_encode($operaciones);
?>