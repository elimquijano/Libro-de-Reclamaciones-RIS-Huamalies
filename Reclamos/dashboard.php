<?php
//control de acceso
session_start();
if (!empty($_SESSION['id_access'])) {
    $id = $_SESSION['id_access'];
    //conexion a DB
    require_once 'php/conexion.php';
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    //consultas dashboard
    $consulta = "SELECT * FROM s_admin WHERE a_dni = '$id'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $admin = $resultado->fetchAll(PDO::FETCH_ASSOC);
    //contadores
    $consulta = "SELECT COUNT(*) as cantidad FROM s_mensajes";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $cont_mensaje = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $consulta = "SELECT COUNT(*) as cantidad FROM s_reclamo";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $cont_reclamo = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $consulta = "SELECT COUNT(*) as cantidad FROM s_contactos";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $cont_contacto = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $consulta = "SELECT COUNT(*) as cantidad FROM s_mensajes WHERE m_estado = 'Entregado'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $cont_sms_sin_ver = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $consulta = "SELECT COUNT(*) as cantidad FROM s_reclamo WHERE r_estado = 'pendiente'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $cont_reclamo_pendiente = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $consulta = "SELECT COUNT(*) as cantidad FROM s_reclamo WHERE r_estado = 'En Revisión'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $cont_reclamo_entregado = $resultado->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('Location: login.html');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administración de Reclamaciones</title>

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

    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <!-- Js personalizado -->
    <script type="text/javascript" src="asset/js/send-data-contactos.js"></script>
    <script type="text/javascript" src="asset/js/send-data-reclamos.js"></script>
    <script type="text/javascript" src="asset/js/send-data-mensajes.js"></script>
    <script type="text/javascript" src="asset/js/event-dash.js"></script>
    
    <!-- CSS personalizado -->
    <link type="text/css" rel="stylesheet" href="asset/css/estilos-dashboard.css">
</head>

<body class="container-fluid m-0 p-0">
    <!-- Menú de Navegación -->
    <nav id="menu">
        <ul class="nav nav-justified">
            <li data-bs-toggle="tooltip" data-bs-placement="right" title="Abrir/Cerrar menú">
                <a href="#" id="menu-toggle" class="nav-link"><i class="bx bx-menu"></i><span class="hidden-pc">Admin Control</span></a>
            </li>
            <li data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                <a class="nav-link active" data-bs-toggle="pill" href="#dashboard"><i class="bx bxs-dashboard"></i><span class="hidden-pc">Dashboard</span></a>
            </li>
            <li data-bs-toggle="tooltip" data-bs-placement="right" title="Reclamos">
                <a class="nav-link" data-bs-toggle="pill" href="#reclamos"><i class="bx bxs-error"></i><span class="hidden-pc">Reclamos</span></a>
            </li>
            <li data-bs-toggle="tooltip" data-bs-placement="right" title="Mensajes">
                <a class="nav-link" data-bs-toggle="pill" href="#mensajes"><i class="bx bxs-message"></i><span class="hidden-pc">Mensajes</span></a>
            </li>
            <li data-bs-toggle="tooltip" data-bs-placement="right" title="Contactos">
                <a class="nav-link" data-bs-toggle="pill" href="#contactos"><i class="bx bxs-group"></i><span class="hidden-pc">Contactos</span></a>
            </li>
            <li data-bs-toggle="tooltip" data-bs-placement="right" title="Configuración">
                <a class="nav-link" data-bs-toggle="pill" href="#configuracion"><i class="bx bxs-user-circle"></i><span class="hidden-pc">Cuenta</span></a>
            </li>
            <li data-bs-toggle="tooltip" data-bs-placement="right" title="Cerrar Sesión">
                <a class="nav-link" id="cerrarSesion" href="#"><i class="bx bxs-log-out-circle"></i><span class="hidden-pc">Cerrar Sesión</span></a>
            </li>
        </ul>
    </nav>

    <!-- Secciones -->
    <main class="tab-content">
        <div class="tab-pane active p-2" id="dashboard">
            <!-- cabecera -->
            <div>
                <ul class="list-unstyled d-flex">
                    <li>
                        <a href="#" class="text-black-50 text-decoration-none">Dashboard</a>
                    </li>
                    <li><i class="bx bx-chevron-right px-2"></i></li>
                    <li>
                        <a class="text-decoration-none" href="#">Home</a>
                    </li>
                </ul>
            </div>
            <!-- main -->
            <div class="row m-0">
                <div class="col-12 col-md-3 p-2">
                    <div class="card bg-primary text-white p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <i class="fs-1 bx bxs-message m-0"></i>
                            <div class="">
                                <span>Mensajes Nuevos</span>
                                <h2><?php echo $cont_sms_sin_ver[0]['cantidad'] ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 p-2">
                    <div class="card bg-danger text-white p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <i class="fs-1 bx bxs-error m-0"></i>
                            <div class="">
                                <span>Reclamos Por Enviar</span>
                                <h2><?php echo $cont_reclamo_pendiente[0]['cantidad'] ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 p-2">
                    <div class="card bg-warning text-white p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <i class="fs-1 bx bxs-error m-0"></i>
                            <div class="">
                                <span>Reclamos en Revisión</span>
                                <h2><?php echo $cont_reclamo_entregado[0]['cantidad'] ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3 p-2">
                    <div class="card bg-success text-white p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <i class="fs-1 bx bxs-group m-0"></i>
                            <div class="">
                                <span>Contactos</span>
                                <h2><?php echo $cont_contacto[0]['cantidad'] ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- recordatorios -->
            <h4 class="py-2">Notificaciones</h4>
            <div class="row m-0">
                <div class="col-12 col-md-6 p-4">
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>¡ATENCION!</strong> recuerde que si es su primer acceso, por motivos de seguridad le recomendamos cambiar sus datos personales en la sección de configuración de cuenta.
                    </div>
                    <div class="alert alert-primary alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        HISTORIAL: <br><br>
                        Total de Reclamos: <?php echo $cont_reclamo[0]['cantidad'] ?><br>
                        Total de Mensajes: <?php echo $cont_mensaje[0]['cantidad'] ?><br>
                    </div>

                </div>
                <div class="col-12 col-md-6 d-inline d-md-flex border border-1 rounded-1 bg-secondary bg-opacity-10 p-2">
                    <div class="">
                        <h2>¡Bienvenido <?php echo $admin[0]["a_username"] ?>!</h2>
                        <p>
                            Este en tu panel de control, en la parte izquierda de la
                            pantalla tienes a tu disposición la barra de navegación con la
                            cual puedes acceder a las diversas tareas que se le ofrece.
                        </p>
                    </div>
                    <div class="p-1 d-flex justify-content-center">
                        <img style="width: 250px" src="https://img.freepik.com/vector-gratis/espacio-trabajo-disenador-grafico_23-2148113899.jpg?size=338&ext=jpg&ga=GA1.2.1705676397.1646793772" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade p-2" id="reclamos">
            <!-- cabecera -->
            <div>
                <ul class="list-unstyled d-flex">
                    <li>
                        <a href="#" class="text-black-50 text-decoration-none">Reclamos</a>
                    </li>
                    <li><i class="bx bx-chevron-right px-2"></i></li>
                    <li>
                        <a class="text-decoration-none" href="#">Home</a>
                    </li>
                </ul>
            </div>
            <!-- cuerpo -->
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="tablaReclamos" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th>CÓDIGO</th>
                                            <th>DESCRIPCIÓN</th>
                                            <th>ARCHIVO ADJUNTO</th>
                                            <th>FECHA</th>
                                            <th>ESTADO</th>
                                            <th>USUARIO</th>
                                            <th>EMAIL</th>
                                            <th>TELEFONO</th>
                                            <th>DNI</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade p-2" id="mensajes">
            <!-- cabecera -->
            <div>
                <ul class="list-unstyled d-flex">
                    <li>
                        <a href="#" class="text-black-50 text-decoration-none">Mensajes</a>
                    </li>
                    <li><i class="bx bx-chevron-right px-2"></i></li>
                    <li>
                        <a class="text-decoration-none" href="#">Home</a>
                    </li>
                </ul>
            </div>
            <!-- cuerpo -->
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="tablaMensajes" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>CÓDIGO</th>
                                            <th>FECHA</th>
                                            <th>DE</th>
                                            <th>MENSAJE</th>
                                            <th>ESTADO</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade p-2" id="contactos">
            <!-- cabecera -->
            <div>
                <ul class="list-unstyled d-flex">
                    <li>
                        <a href="#" class="text-black-50 text-decoration-none">Contactos</a>
                    </li>
                    <li><i class="bx bx-chevron-right px-2"></i></li>
                    <li>
                        <a class="text-decoration-none" href="#">Home</a>
                    </li>
                </ul>
            </div>
            <!-- cuerpo -->
            <div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <button id="btnNuevo" type="button" class="btn btn-info d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCONTACTO"><i class="material-icons">library_add</i><span class="p-2">Agregar</span></button>
                        </div>
                    </div>
                </div>
                <br>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="tablaContactos" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th>CÓDIGO</th>
                                            <th>NOMBRE</th>
                                            <th>AREA</th>
                                            <th>CARGO</th>
                                            <th>E-MAIL</th>
                                            <th>TELÉFONO</th>
                                            <th>ACCIÓN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade p-2" id="configuracion">
            <!-- cabecera -->
            <div>
                <ul class="list-unstyled d-flex">
                    <li>
                        <a href="#" class="text-black-50 text-decoration-none">Configuración</a>
                    </li>
                    <li><i class="bx bx-chevron-right px-2"></i></li>
                    <li>
                        <a class="text-decoration-none" href="#">Home</a>
                    </li>
                </ul>
            </div>
            <!-- cuerpo -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4 text-center">
                        <img src="https://www.pngkit.com/png/full/901-9019040_business-user-lock-1-image-business-user.png" style="width: 100%" alt="">
                        <!-- <img style="width: 100%" src="https://www.gpslink.co.uk/static/asset/img/login.png" alt=""> -->
                    </div>
                    <div class="col-12 col-md-8">
                        <!-- alerta -->
                        <div class="alert alert-dismissible text-center" id="sms">
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
                            <strong></strong>
                        </div>

                        <div class="table-responsive">
                            <h2 class="col-12">Configuración General de la Cuenta</h2>
                            <hr>
                            <table class="table table-hover table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Número de DNI</strong></td>
                                        <td id="admin_id"><?php echo $admin[0]['a_dni'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nombre de Usuario</strong></td>
                                        <td><?php echo $admin[0]['a_username'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Correo Electrónico Principal</strong></td>
                                        <td><?php echo $admin[0]['a_email'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Correo Electrónico de Respaldo</strong></td>
                                        <td><?php echo $admin[0]['a_email_respaldo'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contraseña</strong></td>
                                        <td><?php echo $admin[0]['a_password'] ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <!-- Button to Open the Modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCUENTA">
                                                Editar Datos
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="alert alert-dismissible alert-warning">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>NOTA 1: </strong>Para poder ver los cambios es necesario actualizar la página<br>
                                <strong>NOTA 2: </strong>Si actualiza el número de DNI, es necesario cerrar sesión e iniciar nuevamente
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!--Modal para CRUD RECLAMOS-->
    <div class="modal fade" id="modalRECLAMOS" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formRECLAMOS">
                    <div class="modal-body">
                        <div class="row">
                            <strong>Datos del Reclamo</strong>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Código:</label>
                                    <input type="number" class="form-control" id="dbr_id" readonly required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Nombre de Usuario:</label>
                                    <input type="text" class="form-control" id="dbr_username" readonly required />
                                </div>
                            </div>
                        </div>
                        <div hidden class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Fecha:</label>
                                    <input type="text" class="form-control" id="dbr_date" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Estado:</label>
                                    <input type="text" class="form-control" id="dbr_estado" required />
                                </div>
                            </div>
                        </div>
                        <div hidden class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">DNI:</label>
                                    <input type="number" class="form-control" id="dbr_dni" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">E-mail:</label>
                                    <input type="text" class="form-control" id="dbr_email" required />
                                </div>
                            </div>
                        </div>
                        <div hidden class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Teléfono:</label>
                                    <input type="number" class="form-control" id="dbr_telefono" required />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Pruebas Adjuntadas:</label>
                                    <input type="text" class="form-control" id="dbr_archivo" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Descripcion:</label>
                                    <textarea id="dbr_descripcion" class="form-control" readonly></textarea>
                                </div>
                            </div>
                            <strong><br>Datos del Envío</strong>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="col-form-label">E-mail al cuál se va a enviar:</label>
                                    <input type="email" class="form-control" id="dr_email" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar2" class="btn btn-success">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal para CRUD CONTACTO-->
    <div class="modal fade" id="modalCONTACTO" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCONTACTO">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="username" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Área:</label>
                                    <input type="text" class="form-control" id="area" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Cargo</label>
                                    <input type="text" class="form-control" id="cargo" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Teléfono:</label>
                                    <input type="text" class="form-control" id="telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="" class="col-form-label">E-mail:</label>
                                    <input type="text" class="form-control" id="email" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal para Config. Cuenta-->
    <div class="modal fade" id="modalCUENTA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #17a2b8; color: white;">
                    <h5 class="modal-title">Modificar Datos de la Cuenta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCUENTA">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 py-2">
                                <div class="form-group">
                                    <input hidden type="number" class="form-control" id="dbaold_dni" value="<?php echo $admin[0]['a_dni'] ?>" required>
                                    <input type="number" class="form-control" id="dba_dni" value="<?php echo $admin[0]['a_dni'] ?>" placeholder="DNI" required>
                                </div>
                            </div>
                            <div class="col-lg-6 py-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="dba_username" value="<?php echo $admin[0]['a_username'] ?>" placeholder="Nombres" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 py-2">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="dba_email" value="<?php echo $admin[0]['a_email'] ?>" placeholder="Correo Electrónico" required>
                                </div>
                            </div>
                            <div class="col-lg-12 py-2">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="dba_email_respaldo" value="<?php echo $admin[0]['a_email_respaldo'] ?>" placeholder="Correo Electrónico Respaldo" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 py-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="dba_password_new" placeholder="Contraseña Nueva" required>
                                </div>
                            </div>
                            <div class="col-lg-12 py-2">
                                <br><strong><i>NOTA: Para poder cambiar los datos actuales necesita ingresar la contraseña actual:</i></strong>
                                <div class="form-group py-2">
                                    <input type="text" class="form-control" id="dba_password" placeholder="Ingrese aquí la contraseña" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnActualizar" class="btn btn-success">Actualizar Datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>