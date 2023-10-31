<?php
header("Content-Type: application/json");
function obtenerUsuarios()
{
    $bd = obtenerConexion();
    $sentencia = $bd->query("SELECT * FROM usuarios");
    return $sentencia->fetchAll();
}

function obtenerUsuario($user)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $sentencia->execute([$user]);
    return $sentencia->fetchObject();
}



function obtenerOperaciones($id)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT * FROM operaciones WHERE cliente_idusuario = :id");
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();
    return $sentencia->fetchAll();
}

function obtenerTipoDeGasto()
{
    $bd = obtenerConexion();
    $sentencia = $bd->query("SELECT * FROM tipo_gasto");
    return $sentencia->fetchAll();
}

//registrarNuevoUsuario('prueba','to','dd','dd','cliente','1000');
function registrarNuevoUsuario($nombre, $apellido, $correo, $clave, $tipousuario, $sueldomensual, $fecharegistro) {
    // Obtener una conexión a la base de datos
    $bd = obtenerConexion();
    
    // Insertar nuevo usuario en la tabla usuarios
    $sentencia = "INSERT INTO usuarios (admin, nombre, apellido, correo, clave, fecharegistro)
                   VALUES (0, :nombre, :apellido, :correo, :clave, :fecharegistro)";
    
    $stmtUsuario = $bd->prepare($sentencia);
    $stmtUsuario->bindParam(':nombre', $nombre);
    $stmtUsuario->bindParam(':apellido', $apellido);
    $stmtUsuario->bindParam(':correo', $correo);
    $stmtUsuario->bindParam(':clave', $clave);
    $stmtUsuario->bindParam(':fecharegistro', $fecharegistro);
    
    if ($stmtUsuario->execute()) {
        // Obtener el ID del nuevo usuario insertado
        $idUsuario = $bd->lastInsertId();
        
        $sentencia = "INSERT INTO cliente (idusuario, tipousuario, sueldomensual)
                       VALUES (:idusuario, :tipousuario, :sueldomensual)";
    
        $stmtCliente = $bd->prepare($sentencia);
        $stmtCliente->bindParam(':idusuario', $idUsuario);
        $stmtCliente->bindParam(':tipousuario', $tipousuario);
        $stmtCliente->bindParam(':sueldomensual', $sueldomensual);
        
        if ($stmtCliente->execute()) {
            $respuesta = array('mensaje' => 'Nuevo usuario/cliente registrado con éxito');
            return $respuesta;
        } else {
            $respuesta = array('mensaje' => 'Error al registrar el cliente: ' . implode(", ", $stmtCliente->errorInfo()));
            return $respuesta;
        }
    } else {
        $respuesta = array('mensaje' => 'Error al registrar el usuario: ' . implode(", ", $stmtUsuario->errorInfo()));
        return $respuesta;
    }
}



function registrarContacto($nombre, $apellido, $correo, $mensaje)
{
    // Obtener una conexión a la base de datos
    $bd = obtenerConexion();
    
    // Insertar nuevo usuario en la tabla usuarios
    $sentencia = "INSERT INTO contacto (nombre, apellido, correo, mensaje)
    VALUES (:nombre, :apellido, :correo, :mensaje);";
    
    $sentencia = $bd->prepare($sentencia);
    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':apellido', $apellido);
    $sentencia->bindParam(':correo', $correo);
    $sentencia->bindParam(':mensaje', $mensaje);
    if ($sentencia->execute()) {
        echo "Se envio la informacion correctamente";
    } else {
        echo "Error al registrar los datos: " . implode(", ", $sentencia->errorInfo());
    }
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