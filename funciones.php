<?php
function obtenerUsuarios()
{
    $bd = obtenerConexion();
    $sentencia = $bd->query("SELECT * FROM usuarios");
    return $sentencia->fetchAll();
}

function obtenerUsuario($id)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT * FROM usuarios WHERE idusuario = ?");
    $sentencia->execute([$id]);
    return $sentencia->fetchObject();
}

function obtenerOperaciones()
{
    $bd = obtenerConexion();
    $sentencia = $bd->query("SELECT * FROM operaciones");
    return $sentencia->fetchAll();
}

function obtenerTipoDeGasto()
{
    $bd = obtenerConexion();
    $sentencia = $bd->query("SELECT * FROM tipo_gasto");
    return $sentencia->fetchAll();
}

function obtenerConexion()
{
    $dbName = "bw9is5cg7nkeccmci5nc";
    $host = "bw9is5cg7nkeccmci5nc-mysql.services.clever-cloud.com";
    $user = "udxdiw02an5765ke";
    $password = "eeC6V00hsf6PVXyb46XM";

    try {
        $database = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $user, $password);
        $database->query("set names utf8;");
        $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $database;

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>