<?php
//conexion a DB
require_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//consulta admin account
$consulta = "SELECT * FROM s_admin";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$admin = $resultado->fetchAll(PDO::FETCH_ASSOC);
$dba_username = $admin[0]['a_email'];
$dba_password = base64_decode($admin[0]['a_password']);
$from = 'support.account@gmail.com';
$subject = 'INFORMACION DE LA CUENTA DE ADMINISTRADOR';
$to1 = $admin[0]['a_email'];
$to2 = $admin[0]['a_email_respaldo'];
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html; charset=iso-8859-1" . "\r\n";

include_once 'Formato Email/email-cuenta.php';//mensajeCuenta

$sendEmail = mail($to1, $subject, $mensaje, $headers);
$sendEmail2 = mail($to2, $subject, $mensaje, $headers);


if ($sendEmail && $sendEmail2) { ?>
    <h1>Datos de cuenta enviadas a:</h1><br>
    <ul>
        <li><?php echo $to1 ?></li>
        <li><?php echo $to2 ?></li>
    </ul>
<?php
} else {
    echo 'Ocurrió un error, inténtelo más tarde';
}
?>