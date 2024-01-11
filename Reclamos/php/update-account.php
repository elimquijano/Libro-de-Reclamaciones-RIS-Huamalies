<?php

// conexión a DB
require_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//obtener data
$dbaold_dni = $_POST['dbaold_dni'];
$dba_dni = $_POST['dba_dni'];
$dba_username = $_POST['dba_username'];
$dba_email = $_POST['dba_email'];
$dba_email_respaldo = $_POST['dba_email_respaldo'];
$dba_password_new = $_POST['dba_password_new'];
$dba_password = $_POST['dba_password'];

//consulta
$consulta = "SELECT * FROM `s_admin` WHERE a_dni = $dbaold_dni";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$database = $resultado->fetchAll(PDO::FETCH_ASSOC);

if (base64_encode($dba_password) === $database[0]['a_password']) {
    //encrypt pass
    $dba_password_new = base64_encode($dba_password_new);
    //consulta2
    $consulta = "UPDATE `s_admin` SET `a_dni`='$dba_dni',`a_username`='$dba_username',`a_email`='$dba_email',`a_password`='$dba_password_new',`a_email_respaldo`='$dba_email_respaldo' WHERE a_dni = $dbaold_dni";
    $resultado = $conexion->prepare($consulta);
    $resultado = $resultado->execute();
    if ($resultado) {
        $data = ['type' => 'alert-primary', 'message' => 'Actualización Exitosa'];
    } else {
        $data = ['type' => 'alert-warning', 'message' => 'Algo salió mal, inténtelo más tarde'];
    }
} else {
    $data = ['type' => 'alert-danger', 'message' => 'Contraseña Incorrecta, no se pudo actualizar los datos'];
}
print json_encode($data);
