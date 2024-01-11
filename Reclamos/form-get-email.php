<?php
//coneccion db
require_once 'php/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

if (isset($_GET['ctr_accs']) && isset($_GET['u_eml']) && isset($_GET['i_rcm'])) {
    $email = $_GET['u_eml'];
    $dbr_id = $_GET['i_rcm'];

    $consulta = "SELECT * FROM `s_reclamo` WHERE r_id ='$dbr_id'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($data)) {
        if ($data[0]['r_estado'] === 'En Revisión') { ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8" />
                <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>Formulario de Respuesta</title>
                <!-- Iconos -->
                <link href="asset/icons/boxicons.min.css" rel="stylesheet" />
                <!-- Boxicons Alternativo-->
                <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" rel="stylesheet" />
                <link href="asset/icons/icon.css" rel="stylesheet">
                <!-- Bootstrap 5 -->
                <link rel="stylesheet" type="text/css" href="asset/bootstrap5/bootstrap.min.css" />
                <script type="text/javascript" src="asset/bootstrap5/bootstrap.bundle.min.js"></script>

                <!-- jQuery, Popper.js -->
                <script type="text/javascript" src="asset/jquery/jquery-3.6.0.min.js"></script>
                <script type="text/javascript" src="asset/popper/popper.min.js"></script>
            </head>

            <body class="container bg-success">
                <div class="p-4">
                    <form class="card" action="php/get-email.php" enctype="multipart/form-data" method="post">
                        <div class="card-header">
                            <h1 class="text-center">Formulario de Respuesta</h1>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div hidden class="col-12 py-3">
                                    <input class="form-control" type="text" name="email_comision" id="email_comision" value="<?php echo $email; ?>" />
                                </div>
                                <div hidden class="col-12 py-3">
                                    <input class="form-control" type="text" name="id_reclamo" id="id_reclamo" value="<?php echo $dbr_id; ?>" />
                                </div>
                                <div class="col-12 col-md-6 py-3">
                                    <input class="form-check-input" type="radio" name="estado" id="ir1" value="Aceptado" required /><label class="form-label px-2" for="ir1">Aceptar reclamo</label>
                                </div>
                                <div class="col-12 col-md-6 py-3">
                                    <input class="form-check-input" type="radio" name="estado" id="ir2" value="Rechazado" required /><label class="form-label px-2" for="ir2">Rechazar reclamo</label>
                                </div>
                                <div class="col-12 py-3">
                                    <label for="sms">Adjuntar tu respuesta:</label>
                                    <textarea class="form-control" name="sms" id="sms" placeholder="Escribe aquí..." required></textarea>
                                </div>
                                <div class="col-12 py-3">
                                    <label for="archivo">Aduntar archivo(PDF):</label>
                                    <input class="form-control" type="file" name="archivo" id="archivo" accept="application/pdf" />
                                </div>
                                <div class="col-12 py-3">
                                    <input class="btn btn-primary form-control" type="submit" value="Enviar Respuesta" name="btn" />
                                </div>
                                <div class="col-12 text-center">
                                    <em>
                                        NOTA: Es obligatorio responder desde este formulario y completar
                                        todos los campos...
                                    </em>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </body>

            </html>
<?php
        } else {
            echo '<h1 align="center" style="padding: 20px;">Ya respondió este reclamo...</h1>';
        }
    } else {
        echo '<h1 align="center" style="padding: 20px;">El reclamo no existe...</h1>';
    }
} else {
    echo '<h1 align="center" style="padding: 20px;">Acceso Denegado</h1>';
}
