<?php

//conexion a DB
require_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//obtener data
if (isset($_POST['b_dni'])) {

    $dni = $_POST['b_dni'];

    $consulta = "SELECT * FROM `s_reclamo` WHERE r_dni = $dni";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $dat0 = $resultado->fetchAll(PDO::FETCH_ASSOC);

    if ($dat0) {
        //ocultar llaves de DB
        $i = 0;
        foreach ($dat0 as $item) {
            $data[$i] = ['nombre' => $item['r_username'], 'fecha' => $item['r_date'], 'status' => $item['r_estado']];
            $i++;
        }
    
        print json_encode($data); //envio del array en formato json a AJAX
        $conexion = null;
    }
}
