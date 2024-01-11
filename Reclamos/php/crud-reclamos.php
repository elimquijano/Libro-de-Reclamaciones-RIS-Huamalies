<?php
//conexion a DB
require_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//obtener data
$dbr_username = (isset($_POST['dbr_username'])) ? $_POST['dbr_username'] : '';
$dbr_date = (isset($_POST['dbr_date'])) ? $_POST['dbr_date'] : '';
$dbr_dni = (isset($_POST['dbr_dni'])) ? $_POST['dbr_dni'] : '';
$dbr_email = (isset($_POST['dbr_email'])) ? $_POST['dbr_email'] : '';
$dr_email = (isset($_POST['dr_email'])) ? $_POST['dr_email'] : '';
$dbr_telefono = (isset($_POST['dbr_telefono'])) ? $_POST['dbr_telefono'] : '';
$dbr_descripcion = (isset($_POST['dbr_descripcion'])) ? $_POST['dbr_descripcion'] : '';
$dbr_estado = (isset($_POST['dbr_estado'])) ? $_POST['dbr_estado'] : '';
$dbr_archivo = (isset($_POST['dbr_archivo'])) ? $_POST['dbr_archivo'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$dbr_id = (isset($_POST['dbr_id'])) ? $_POST['dbr_id'] : '';

switch ($opcion) {
  case 1: //Enviar email

    //data admin
    $id = $_SESSION['id_access'];
    $consulta = "SELECT * FROM s_admin WHERE a_dni = '$id'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $admin = $resultado->fetchAll(PDO::FETCH_ASSOC);
    // Las 2 primeras lineas habilitan el informe de errores
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //OBTENER URL ACTUAL
    $path = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    //SEPARA PATH CON /PHP/RECLAMO.PHP
    $link = explode('/php', $path);
    $URL_PATH = $link[0] . "/form-get-email.php?u_eml=$dr_email&i_rcm=$dbr_id&ctr_accs=true";
    $from = $admin[0]['a_email'];
    $dba_username = $admin[0]['a_email'];
    $to = $dr_email;
    $subject = "!ATENCIÓN: Nuevo Reclamo Regristrado en el Libro de Reclamaciones!";
    include_once 'Formato Email/email-comision.php';//mensaje
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html; charset=iso-8859-1" . "\r\n";

    //Enviar mail

    $consulta = "SELECT * FROM `s_reclamo` WHERE r_id='$dbr_id' ";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    if ($data[0]['r_estado'] == 'pendiente') {
      $sendMail = mail($to, $subject, $mensaje, $headers);
      if ($sendMail) {
        $consulta = "UPDATE `s_reclamo` SET `r_estado`='En Revisión' WHERE r_id='$dbr_id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
      }
    }


    break;
  case 2: //borrar reclamo(opcional)

    //borrar img adjuntada
    $consulta = "SELECT * FROM `s_reclamo` WHERE r_id ='$dbr_id'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    if ($data[0]['r_archivo'] !== 'No Registrado') {
      $link = explode('/img/', $data[0]['r_archivo']);
      $name_image = $link[1];
    
      $borrar = unlink("../img/$name_image");
    }
    $consulta = "DELETE FROM `s_reclamo` WHERE r_id ='$dbr_id'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    break;
  case 3: //mostrar reclamos
    $consulta = "SELECT * FROM `s_reclamo`";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //envio del array en formato json a AJAX
$conexion = null;
