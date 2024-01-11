<?php
//conexion a DB
require_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

if (!empty($_POST["username"]) && !empty($_POST["dni"]) && !empty($_POST["email"]) && !empty($_POST["telefono"]) && !empty($_POST["descripcion"])) {
    $u_name = $_POST["username"];
    $u_dni = $_POST["dni"];
    $u_email = $_POST["email"];
    $u_telefono = $_POST["telefono"];
    $u_descripcion = $_POST["descripcion"];

    //verificar email

    // Initializar CURL:
    $ch = curl_init('https://garridodiaz.com/emailvalidator/index.php?email=' . $u_email);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Recibir la data:
    $json = curl_exec($ch);
    curl_close($ch);

    // Convertir a formato JSON:
    $validationResult = json_decode($json, true);
    if ($validationResult['valid'] === true) {

        //tratamiento de la imagen
        if (isset($_FILES['image']['name'])) {
            $img_name = $_FILES['image']['name'];
            $img_type = $_FILES['image']['type'];
            $tmp_name = $_FILES['image']['tmp_name'];

            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode);
            $extensions = ["jpeg", "png", "jpg"];
            if (in_array($img_ext, $extensions) === true) {
                $types = ["image/jpeg", "image/jpg", "image/png"];
                if (in_array($img_type, $types) === true) {
                    $time = time();
                    $new_img_name = $time . $img_name;

                    //mover la imagen
                    if (move_uploaded_file($tmp_name, "../img/" . $new_img_name)) {
                        //OBTENER URL ACTUAL
                        $path = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        //SEPARA PATH CON /PHP/RECLAMO.PHP
                        $link = explode('/php', $path);
                        $URL_PATH = $link[0] . "/img/";
                        $u_archivo = $URL_PATH . $new_img_name;
                    } else {
                        $u_archivo = 'No Registrado';
                    }
                } else {
                    $u_archivo = 'No Registrado';
                }
            } else {
                $u_archivo = 'No Registrado';
            }
        } else {
            $u_archivo = 'No Registrado';
        }

        //obtener fecha de maquina
        date_default_timezone_set('America/Lima');
        $date = date('d-m-Y h:i:s a', time());
        $consulta = "INSERT INTO `s_reclamo`(`r_date`, `r_username`, `r_dni`, `r_email`, `r_telefono`, `r_descripcion`, `r_archivo`) VALUES ('$date','$u_name','$u_dni','$u_email','$u_telefono','$u_descripcion','$u_archivo')";
        $resultado = $conexion->prepare($consulta);
        $resultado = $resultado->execute();
        if ($resultado) {
            echo "Su reclamo fue registrado";
        } else {
            echo "Ocurrió un error, inténtelo más tarde";
        }
    } else {
        echo "¡ERROR! el correo electrónico no existe";
    }
} else {
    echo "¡ADVERTENCIA! Rellene todos los campos";
}
