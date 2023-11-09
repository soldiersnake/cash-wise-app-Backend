<?php
header("Content-Type: application/json");


function obtenerIngresos($idusuario)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT * FROM ingresos WHERE id_usuario = :idusuario");
    $sentencia->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
    $sentencia->execute();
    return $sentencia->fetchAll();
}

function setEstado($idusuario, $estado )
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("UPDATE usuarios SET estado = :estado WHERE idusuario = :idusuario");
    $sentencia->bindParam(':estado', $estado, PDO::PARAM_INT);
    $sentencia->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
    
    if ($sentencia->execute()) {
        return array('mensaje' => 'true');; 
    } else {
        return array('mensaje' => 'false');; 
    }
}


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



function obtenerCliente($id)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT * FROM cliente WHERE idusuario = ?");
    $sentencia->execute([$id]);
    return $sentencia->fetchObject();
}



function obtenerOperaciones($id)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT operaciones.*, tipo_gasto.descripcion AS tipo_gasto_descripcion
    FROM operaciones
    INNER JOIN tipo_gasto ON operaciones.tipo_gasto_id = tipo_gasto.id_gasto
    WHERE operaciones.cliente_idusuario = :id
    ");
    $sentencia->bindParam(':id', $id, PDO::PARAM_INT);
    $sentencia->execute();
    return $sentencia->fetchAll();
}

function obtenerOperacionPorID_O($id_operacion)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT * from operaciones WHERE id_operacion = :id");
    $sentencia->bindParam(':id', $id_operacion);
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
function registrarNuevoUsuario($nombre, $apellido, $correo, $clave, $tipousuario, $sueldomensual, $fecharegistro)
{
    // Obtener una conexión a la base de datos
    $bd = obtenerConexion();

    // Insertar nuevo usuario en la tabla usuarios
    $sentencia = "INSERT INTO usuarios (admin, nombre, apellido, correo, clave, fecharegistro, estado)VALUES (0, :nombre, :apellido, :correo, :clave, :fecharegistro, 1)";

    $stmtUsuario = $bd->prepare($sentencia);
    $stmtUsuario->bindParam(':nombre', $nombre);
    $stmtUsuario->bindParam(':apellido', $apellido);
    $stmtUsuario->bindParam(':correo', $correo);
    $stmtUsuario->bindParam(':clave', $clave);
    $stmtUsuario->bindParam(':fecharegistro', $fecharegistro);

    if ($stmtUsuario->execute()) {
        // Obtener el ID del nuevo usuario insertado
        $idUsuario = $bd->lastInsertId();

        $sentencia = "INSERT INTO cliente (idusuario, tipousuario, sueldomensual) VALUES (:idusuario, :tipousuario, :sueldomensual)";

        $stmtCliente = $bd->prepare($sentencia);
        $stmtCliente->bindParam(':idusuario', $idUsuario);
        $stmtCliente->bindParam(':tipousuario', $tipousuario);
        $stmtCliente->bindParam(':sueldomensual', $sueldomensual);

        if ($stmtCliente->execute()) {
            $respuesta = array('mensaje' => 'Nuevo usuario/cliente registrado con éxito');
            return $respuesta;
        } else {
            $respuesta = array('mensaje' => 'Error al registrar el cliente: ');
            return $respuesta;
        }
    } else {
        $respuesta = array('mensaje' => 'Error al registrar el usuario: ');
        return $respuesta;
    }
}

function editarGasto($id_gasto, $descripcion, $color)
{
    // Obtener una conexión a la base de datos
    $bd = obtenerConexion();

    // Insertar nuevo usuario en la tabla usuarios
    $sentencia = $bd->prepare("UPDATE tipo_gasto
                               SET descripcion = :nuevo_descripcion, color = :nuevo_color
                               WHERE id_gasto = :id_gasto");

    $sentencia->bindParam(':nuevo_descripcion', $descripcion); // Cambié aquí
    $sentencia->bindParam(':nuevo_color', $color); // Cambié aquí
    $sentencia->bindParam(':id_gasto', $id_gasto);

    if ($sentencia->execute()) {
        $respuesta = array('mensaje' => 'true');
        return $respuesta;
    } else {
        $respuesta = array('mensaje' => "Error al actualizar los datos");
        return $respuesta;
    }
}

function registrarTipoGasto($descripcion, $color)
{
    // Obtener una conexión a la base de datos
    $bd = obtenerConexion();

    // Insertar nuevo usuario en la tabla usuarios
    $sentencia = "INSERT INTO tipo_gasto (descripcion, color)
    VALUES ( :descripcion, :color);";

    $sentencia = $bd->prepare($sentencia);
    $sentencia->bindParam(':descripcion', $descripcion);
    $sentencia->bindParam(':color', $color);
    if ($sentencia->execute()) {
        $respuesta = array('mensaje' => 'true');
        return $respuesta;
    } else {
        $respuesta = array('mensaje' => "false");
        return $respuesta;
    }
}

function eliminarGasto($id_gasto)
{
    $bd = obtenerConexion();

    if (!$bd) {
        return array('mensaje' => 'Error en la conexión a la base de datos');
    }

    try {
        $sentencia = $bd->prepare("DELETE FROM tipo_gasto
                                   WHERE id_gasto = :id_gasto");

        $sentencia->bindParam(':id_gasto', $id_gasto);

        if ($sentencia->execute()) {
            $respuesta = array('mensaje' => 'true');
            return $respuesta;
        } else {
            $respuesta = array('mensaje' => 'Error al eliminar la operación');
            return $respuesta;
        }
    } catch (PDOException $e) {
        $respuesta = array('mensaje' => 'Error en la consulta: ' . $e->getMessage());
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
        $respuesta = array('mensaje' => 'Se envio la informacion correctamente');
        return $respuesta;
    } else {
        $respuesta = array('mensaje' => "Error al registrar los datos ");
        return $respuesta;
    }
}

function registrarGasto($monto, $fechaoperacion, $idusuario, $tipo_gasto_id)
{
    // Obtener una conexión a la base de datos
    $bd = obtenerConexion();

    // Insertar nuevo usuario en la tabla usuarios
    $sentencia = "INSERT INTO `operaciones` (`monto`, `fechaoperacion`, `cliente_idusuario`, `tipo_gasto_id`)
    VALUES (:monto,:fechaoperacion , :idusuario, :tipo_gasto_id);";

    $sentencia = $bd->prepare($sentencia);
    $sentencia->bindParam(':monto', $monto);
    $sentencia->bindParam(':fechaoperacion', $fechaoperacion);
    $sentencia->bindParam(':idusuario', $idusuario);
    $sentencia->bindParam(':tipo_gasto_id', $tipo_gasto_id);
    if ($sentencia->execute()) {
        $respuesta = array('mensaje' => 'Se registro la informacion correctamente');
        return $respuesta;
    } else {
        $respuesta = array('mensaje' => "Error al registrar los datos ");
        return $respuesta;
    }
}

function editarOperacion($id_operacion, $monto, $fechaoperacion, $tipo_gasto_id)
{
    // Obtener una conexión a la base de datos
    $bd = obtenerConexion();

    // Insertar nuevo usuario en la tabla usuarios
    $sentencia = $bd->prepare("UPDATE operaciones
                               SET monto = :nuevo_monto, fechaoperacion = :nueva_fecha, tipo_gasto_id = :nuevo_tipo_gasto
                               WHERE id_operacion = :id_operacion");

    $sentencia->bindParam(':nuevo_monto', $monto); // Cambié aquí
    $sentencia->bindParam(':nueva_fecha', $fechaoperacion); // Cambié aquí
    $sentencia->bindParam(':nuevo_tipo_gasto', $tipo_gasto_id); // Cambié aquí
    $sentencia->bindParam(':id_operacion', $id_operacion);

    if ($sentencia->execute()) {
        $respuesta = array('mensaje' => 'true');
        return $respuesta;
    } else {
        $respuesta = array('mensaje' => "Error al actualizar los datos");
        return $respuesta;
    }
}

function eliminarOperacion($id_operacion)
{
    $bd = obtenerConexion();

    if (!$bd) {
        return array('mensaje' => 'Error en la conexión a la base de datos');
    }

    try {
        $sentencia = $bd->prepare("DELETE FROM operaciones
                                   WHERE id_operacion = :id_operacion");

        $sentencia->bindParam(':id_operacion', $id_operacion);

        if ($sentencia->execute()) {
            $respuesta = array('mensaje' => 'Se eliminó la operación correctamente');
            return $respuesta;
        } else {
            $respuesta = array('mensaje' => 'Error al eliminar la operación');
            return $respuesta;
        }
    } catch (PDOException $e) {
        $respuesta = array('mensaje' => 'Error en la consulta: ' . $e->getMessage());
        return $respuesta;
    }
}
function buscador($filtro, $idusuario)
{
    $bd = obtenerConexion();

    // Verifica si la conexión a la base de datos fue exitosa
    if (!$bd) {
        return array('mensaje' => 'Error en la conexión a la base de datos');
    }

    try {
        // Preparar la consulta SQL con un marcador de posición
        $filtro_monto = '%' . $filtro . '%'; // Agregar comodines % para búsqueda parcial
        $filtro_descripcion = '%' . $filtro . '%';
        $filtro_fecha = '%' . $filtro . '%';

        $sql = "SELECT o.id_operacion, o.monto, o.fechaoperacion, o.cliente_idusuario, tg.descripcion AS tipo_gasto_descripcion
                FROM operaciones o
                INNER JOIN tipo_gasto tg ON o.tipo_gasto_id = tg.id_gasto
                WHERE (o.monto LIKE :filtro_monto OR tg.descripcion LIKE :filtro_descripcion
                        OR o.fechaoperacion LIKE :filtro_fecha)
                AND o.cliente_idusuario = :idusuario";

        $sentencia = $bd->prepare($sql);

        $sentencia->bindParam(':filtro_monto', $filtro_monto);
        $sentencia->bindParam(':filtro_descripcion', $filtro_descripcion);
        $sentencia->bindParam(':filtro_fecha', $filtro_fecha);
        $sentencia->bindParam(':idusuario', $idusuario);

        if ($sentencia->execute()) {
            // Recupera los resultados
            $resultados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultados;
        } else {
            $respuesta = array('mensaje' => 'Error en la consulta');
            return $respuesta;
        }
    } catch (PDOException $e) {
        $respuesta = array('mensaje' => 'Error en la consulta: ' . $e->getMessage());
        return $respuesta;
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
