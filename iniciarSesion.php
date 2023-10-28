<?php
include_once "cors.php";
include_once "funciones.php";


session_start();

$data = json_decode(file_get_contents("php://input"), true);

$User = $data["usuario"];
$Pass = $data["contrasena"];

// echo json_encode("Hola Inicio SESSION " . $User . " " . $Pass);

$Usuarios = obtenerUsuarios();
$usuarioEncontrado = false;

foreach ($Usuarios as $Usuario) {
    if ($Usuario->correo == $User) {
        if ($Usuario->clave == $Pass) {
            $usuarioEncontrado = true;
        }
    }
}
if ($usuarioEncontrado) {
    echo json_encode("Usuario Encontrado");
} else {
    session_destroy();
    echo json_encode("No se encontró el usuario");
}


// if (!isset($_POST["User"])) {
//     if (!isset($_SESSION['idSesion'])) {
//         header('location: ./formlogin.php   ');
//         exit();
//     } else {
//         header('location: ./app/index.php');
//         exit();
//     }
// }

// $User = $_POST["User"];
// $Clave = md5($_POST["Clave"]);
// $UserBd = "";
// $Pass = "";
// $ContadorBd = 0;


// if ($User != $UserBd || $Clave != $Pass) {
//     session_destroy();
//     header('location: ./formlogin.php');
//     exit();
// } else {
//     if (!isset($_SESSION['idSesion'])) {
//         $ContadorBd = $ContadorBd + 1;

//         $dbname = "bp1azblnzxmij8pldru8";
//         $host= "bp1azblnzxmij8pldru8-mysql.services.clever-cloud.com";
//         $user= "uglmtkepy9esmn6b";
//         $password= "DYyh9jutqVtiyr6P2CBI";
//         $respuesta_estado = "";

//         try {
//             $dsn = "mysql:host=$host;dbname=$dbname";
//             $dbh = new PDO($dsn, $user, $password);

//             $sql = "UPDATE Usuarios SET Contador = :ContadorBd WHERE Pass = :Pass";
//             $stmt = $dbh->prepare($sql);

//             $stmt->bindParam(":Pass", $Pass);
//             $stmt->bindParam(":ContadorBd", $ContadorBd);

//             $stmt->execute();
//             $dbh = null;
//         } catch (PDOException $e) {
//             echo $e->getMessage();
//         }
        
//         /* NO ME DEJA UTILIZAR session_create_id() 
//         De forma local anda lo mas bien pero en el webhost me salta 
//         lo sig: Warning: session_create_id(): Failed to create new ID in /storage/ssd2/446/20587446/public_html/PHP/ejerSesion/iniciosesion.php on line 60*/
//         //$_SESSION['idSesion'] = session_create_id();
//         //$_SESSION['idSesion'] = session_regenerate_id();
//         session_regenerate_id();
//         $_SESSION['idSesion'] = substr(bin2hex(random_bytes(13)), 0, 26);
//         $_SESSION['User'] = $User;
//         $_SESSION['Contador'] = $ContadorBd;
//     }
// }
?>