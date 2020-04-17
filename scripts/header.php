<?php
session_start();  //al principio, en el header

$raiz = realpath($_SERVER["DOCUMENT_ROOT"]);
require $raiz . "/Proyecto/lib/functions.php";
/* require "./lib/functions.php";
require "./clases/db_abstract_model.php";
require "./clases/usuarios_model.php";
require "./clases/plantas_model.php"; */


/*    ##### Sesiones #####*/
$tipoS = "";
$nombreS = "";
$id_usuarioS = "";
$emailS = "";
$msg = "";
if (isset($_SESSION['email'])) //la sesión email no se usa de momento
    $emailS = $_SESSION['email'];
if (isset($_SESSION['tipo']))
    $tipoS = $_SESSION['tipo'];
if (isset($_SESSION['nombre']))
    $nombreS = $_SESSION['nombre'];
if (isset($_SESSION['id_usuario']))
    $id_usuarioS = $_SESSION['id_usuario'];

//var_dump($_SESSION);
//echo "nombre: $nombreS email: $emailS tipo: $tipoS id. $id_usuarioS";

if (isset($_GET['lg'])) {
    $tipoS = "";
    $nombreS = "";
    $id_usuarioS = "";
    $emailS = "";
    unset($_SESSION['email']);
    unset($_SESSION['tipo']);
    unset($_SESSION['nombre']);
    unset($_SESSION['id_usuario']);
    session_destroy();
}
if (isset($_POST['login'])) {
    $pass = $_POST['passLogin'];
    $email = $_POST['emailLogin'];
    $usuario = new Usuario();
    $usuario->login($email, $pass);
    $tipoS = $usuario->tipo_usuario;
    $emailS = $usuario->email_usuario;
    $nombreS = $usuario->nombre_usuario;
    $id_usuarioS = $usuario->id_usuario;
    $error = $usuario->error;
    $msg = $usuario->msg;
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Herbario On-line</title>
    <meta name="description" content="HTML5">
    <meta name="author" content="M">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="img/favicon.ico" />
    <!-- links CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="util/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="util/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="util/swiper/css/swiper.min.css">
    <!-- librerías JS -->
    <script src="util/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="util/bootstrap/js/bootstrap.min.js"></script>
    <script src="util/bootbox/bootbox.min.js"></script>
    <script src="util/bootbox/bootbox.locales.min.js"></script>
    <script src="util/swiper/js/swiper.min.js"></script>
    <script src="util/jquery.validate.min.js"></script>
    <script src="js/scripts.js"></script>

</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md bg-success navbar-dark ">
            <a class="navbar-brand" href="index.php?p=ini">Herbario On-Line</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".menuColapsable">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center menuColapsable">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php
                                            if (!isset($_GET['p']) || $_GET['p'] == "ini") {
                                                echo 'active';
                                            } ?>" href="index.php?p=ini"><i class="fas fa-home fa-fw"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php
                                            if (isset($_GET['p']) && $_GET['p'] == "col") {
                                                echo 'active';
                                            } ?>" href="index.php?p=col"><i class="fab fa-pagelines fa-fw"></i>Colección</a>
                    </li>
                    <?php
                    if ($tipoS != "" && $tipoS != "Usuario") {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php
                                                if (isset($_GET['p']) && $_GET['p'] == "gp") {
                                                    echo 'active';
                                                } ?>" href="index.php?p=gp"><i class="fas fa-leaf fa-fw"></i>Gestión de Plantas</a>
                        </li>
                    <?php
                    }

                    if ($tipoS == "Administrador") {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php
                                                if (isset($_GET['p']) && $_GET['p'] == "gu") {
                                                    echo 'active';
                                                } ?>" href="index.php?p=gu"><i class="fas fa-users fa-fw"></i>Gestión de Usuarios</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="collapse navbar-collapse justify-content-end menuColapsable">
                <span class="navbar-text mr-3">
                    Hola, <?php
                            if ($nombreS != "")
                                echo " " . $nombreS;
                            else
                                echo " visitante";
                            ?>
                </span>
                <ul class="nav navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-paw fa-fw"></i>Registro</a>
                        <ul class="dropdown-menu mt-2">
                            <li class="px-3 py-2">
                                <form action="index.php" method="POST" enctype="multipart/form-data" name="formRegistro" class="">
                                    <div class="form-group">
                                        <input id="nombreRegistro" placeholder="Nombre" class="form-control form-control-sm" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="emailRegistro" placeholder="Email" class="form-control form-control-sm" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="passwordRegistro" placeholder="Password" class="form-control form-control-sm" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="form-control rounded-pill bg-success text-white" value="Registro" id="registro" name="registro">
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <?php
                        if ($nombreS == "") {
                        ?>
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-paw fa-fw"></i> Login</a>
                            <ul class="dropdown-menu dropdown-menu-right mt-2">
                                <li class="px-3 py-2">
                                    <form action="index.php" method="POST" enctype="multipart/form-data" name="formLogin" class="">
                                        <div class="form-group">
                                            <input id="emailLogin" name="emailLogin" placeholder="Email" class="form-control form-control-sm" type="text">
                                        </div>
                                        <div class="form-group">
                                            <input id="passLogin" name="passLogin" placeholder="Password" class="form-control form-control-sm" type="password">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="form-control rounded-pill bg-success text-white" value="Login" id="login" name="login">
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        <?php
                        } else {
                            //si hay usuario conectado se muestra logout en lugar de login
                        ?>
                            <a class="nav-link" href="index.php?lg=lg"><i class=" fas fa-paw fa-fw"></i> Logout</a>
                        <?php
                        }
                        ?>

                    </li>
                </ul>
            </div>
        </nav>
    </header>