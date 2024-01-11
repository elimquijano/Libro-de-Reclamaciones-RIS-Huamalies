<?php
//control de acceso
session_start();
if (!empty($_SESSION['id_access'])) {
    header('Location: ../dashboard.php');
    exit();
}
//conexion a DB
require_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//array para mostrar mensaje
$rpta = ["value" => false, "mensaje" => "xd"];

//obtener parametros enviados del form
$email = $_POST['usuario'];
$password = $_POST['contraseña'];

if (!empty($email) && !empty($password)) {
    $consulta = "SELECT * FROM s_admin WHERE a_email = '$email'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    if ($data > 0) {
        //encriptamos la contraseña
        $user_pass = base64_encode($password);
        $enc_pass = $data[0]['a_password'];
        if ($user_pass === $enc_pass) {
            $_SESSION['id_access'] = $data[0]['a_dni'];
            $rpta["value"] = true;
            $rpta["mensaje"] = "dashboard.php";
        } else {
            $rpta["mensaje"] = "Email o Contraseña incorrecta!";
        }
    } else {
        $rpta["mensaje"] = "$email - Este email no existe!";
    }
} else {
    $rpta["mensaje"] = "Rellene todos los campos!";
}
echo json_encode($rpta);
