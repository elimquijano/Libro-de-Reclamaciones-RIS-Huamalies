<?php
// conexión a DB
require_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//obtener data
$username = (isset($_POST['username'])) ? $_POST['username'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$cargo = (isset($_POST['cargo'])) ? $_POST['cargo'] : '';
$email = (isset($_POST['email'])) ? $_POST['email'] : '';
$telefono = (isset($_POST['telefono'])) ? $_POST['telefono'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$user_id = (isset($_POST['user_id'])) ? $_POST['user_id'] : '';


switch ($opcion) {
    case 1: //agregar contactos
        $consulta = "INSERT INTO `s_contactos`(`c_nombre`, `c_area`, `c_cargo`, `c_email`, `c_telefono`) VALUES ('$username','$area','$cargo','$email','$telefono')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM `s_contactos` ORDER BY `c_id` DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificar contactos
        $consulta = "UPDATE `s_contactos` SET `c_nombre`='$username',`c_area`='$area',`c_cargo`='$cargo',`c_email`='$email',`c_telefono`='$telefono' WHERE `c_id`='$user_id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM `s_contactos` WHERE `c_id`='$user_id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3: //borrar contactos
        $consulta = "DELETE FROM `s_contactos` WHERE `c_id`='$user_id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        break;
    case 4: //mostrar contactos
        $consulta = "SELECT * FROM `s_contactos`";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //envio del array en formato json a AJAX
$conexion = null;
