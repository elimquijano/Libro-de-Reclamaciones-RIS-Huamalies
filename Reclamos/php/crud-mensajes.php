<?php
//conecion a DB
require_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//obtener data
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$dbm_id = (isset($_POST['dbm_id'])) ? $_POST['dbm_id'] : '';


switch ($opcion) {
  case 1: //Marcar como Leído
    $consulta = "UPDATE `s_mensajes` SET `m_estado`='Visto' WHERE m_id = '$dbm_id'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();

    $consulta = "SELECT * FROM `s_mensajes` WHERE m_id='$dbm_id' ";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
  case 2: //Eliminar
    $consulta = "DELETE FROM `s_mensajes` WHERE m_id ='$dbm_id'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    break;
  case 3: //Mostrar Todo
    $consulta = "SELECT * FROM `s_mensajes`";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //envio del array en formato json a AJAX
$conexion = null;
