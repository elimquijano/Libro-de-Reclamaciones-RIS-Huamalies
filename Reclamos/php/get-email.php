<?php
//coneccion db
require_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();


//obtener datos desde el correo
$estado = $_POST['estado'];
$archivo = $_FILES['archivo'];
$sms = $_POST['sms'];
$email = $_POST['email_comision'];
$id_reclamo = $_POST['id_reclamo'];
$btn = $_POST['btn'];

if (!empty($btn) && !empty($estado)) {
    // Cargando el fichero en la carpeta "subidas"
    $type = explode('/', $archivo['type']);
    $arch_ext = end($type);
    $size_arch = (int)$archivo['size'];
    if($arch_ext === 'pdf' && $size_arch <= 10000000){
        //OBTENER URL ACTUAL
        $path = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        //SEPARA PATH CON /PHP/RECLAMO.PHP
        $link = explode('/php/', $path);
        $URL_PATH = $link[0] . "/pdf/DOC-" . $archivo["name"];
        $mover = move_uploaded_file($archivo["tmp_name"], "../pdf/DOC-" . $archivo["name"]);
        if($mover){
            date_default_timezone_set('America/Lima');
            $date = date('d-m-Y h:i:s a', time());
            $consulta = "INSERT INTO `s_mensajes`(`m_datetime`, `m_emisor`, `m_contenido`, `m_estado`) VALUES ('$date','$email','$sms','Entregado')";
            $resultado = $conexion->prepare($consulta);
            $resultado = $resultado->execute();
            if ($resultado) {
                //actualizar estado de reclamo
                $consulta = "UPDATE `s_reclamo` SET `r_estado`='$estado' WHERE r_id = '$id_reclamo'";
                $resultado2 = $conexion->prepare($consulta);
                $resultado2 = $resultado2->execute();
                //enviar email al usuario
                $consulta = "SELECT * FROM `s_reclamo` WHERE r_id ='$id_reclamo'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                $r_id = $data[0]['r_id'];
                $r_date = $data[0]['r_date'];
                $r_username = $data[0]['r_username'];
                $r_descripcion = $data[0]['r_descripcion'];
                $r_estado = $data[0]['r_estado'];
                //email
                $from = $email;
                $to = $data[0]['r_email'];
                $subject = '¡IMPORTANTE!, se dió respuesta a tu reclamo';
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html; charset=iso-8859-1" . "\r\n";
                include_once 'Formato Email/email-usuario.php';
                
                if($resultado2){
                    $sendEmail = mail($to, $subject, $mensaje, $headers);
                    if($sendEmail){
                        echo 'Respuesta enviada correctamente';
                    }else{
                        echo 'Error al actualizar estado de reclamo';
                    }
                }else{
                    echo 'Error al enviar el email al usuario';
                }
            }else{
                echo 'Error al enviar el mensaje al administrador';
            }
        }else{
            echo 'no se subió el archivo';
        }
    }else{
        echo '¡ADVERTENCIA! El archivo no es tipo PDF o es de un tamaño muy grande';
    }
} else {
    echo '¡ADVERTENCIA! Mensaje no enviado, inténtelo más tarde';
}
