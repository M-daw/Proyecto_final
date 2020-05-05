<?php
session_start();  //al principio, en el header

//en local
/*$raiz = realpath($_SERVER["DOCUMENT_ROOT"]);
require $raiz . "/Proyecto/lib/functions.php";
require $raiz . "/Proyecto/lib/varios.php";
*/
//en host
require "./lib/functions.php";
require "./lib/varios.php";


/*    ##### Sesiones ##### */
$tipoS = "";
$nombreS = "";
$id_usuarioS = "";
$emailS = "";
$msg = "";
$error = "";
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

/**
 * Funciones para loguear/desloguar
 * 
 * Si un usuario se loguea sus datos se pasan a la sesión. Se usan las sesiones de tipo (para definir varios permisos), 
 * el nombre (mostrar login/logout y saludo en la barra de navegación) y la id (parámetro que se pasará en la 
 * incorporación de elementos a la BD). La sesión de email no se usa de momento.
 * 
 * Cuando el usuario desloguea se destruyen las variables de sesión, y se elimina el contenido de sus variables asociadas
 */

if (isset($_GET['lgo'])) {
    $msg = "Adios, $nombreS, esperamos verte pronto.";
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

//registro de usuarios
if (isset($_POST['registro'])) { //ESTO NO funciona
    $pass = $_POST['passRegistro'];
    $email = $_POST['emailRegistro'];
    $nombre = $_POST['nombreRegistro'];
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    $from = $email;
    $to = "losgatoscuanticos@gmail.com";
    $subject = "Registro en Herbario on-line";
    $message = "PHP mail works just fine";
    $headers = "From:" . $from ."\r\nReply-To: ".$from."\r\nX-Mailer: PHP/" . phpversion();
    mail($to, $subject, $message, $headers);
    $msg = "The email message was sent.";
}

?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Herbario On-line</title>
    <meta name="description" content="HTML5">
    <meta name="author" content="M-DAW">
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
        <nav class="navbar navbar-expand-lg bg-success navbar-dark ">
            <a class="navbar-brand" href="index.php?p=ini">Herbario On-Line</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".menuColapsable">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center menuColapsable">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php
                                            if (!isset($_GET['p']) || $_GET['p'] == "ini") :
                                                echo 'active';
                                            endif; ?>" href="index.php?p=ini"><i class="fas fa-home fa-fw"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php
                                            if (isset($_GET['p']) && $_GET['p'] == "col") :
                                                echo 'active';
                                            endif; ?>" href="index.php?p=col"><i class="fab fa-pagelines fa-fw"></i> Colección</a>
                    </li>
                    <?php if ($tipoS != "") : ?>
                        <li class="nav-item">
                            <a class="nav-link <?php
                                                if (isset($_GET['p']) && $_GET['p'] == "glu") :
                                                    echo 'active';
                                                endif; ?>" href="index.php?p=glu"><i class="far fa-images fa-fw"></i> Mis imágenes</a>
                        </li>

                        <?php if ($tipoS != "Usuario") : ?>
                            <li class="nav-item">
                                <a class="nav-link <?php
                                                    if (isset($_GET['p']) && $_GET['p'] == "gp") :
                                                        echo 'active';
                                                    endif; ?>" href="index.php?p=gp"><i class="fas fa-leaf fa-fw"></i> Gestión de Plantas</a>
                            </li>
                        <?php endif;

                        if ($tipoS == "Administrador") : ?>
                            <li class="nav-item">
                                <a class="nav-link <?php
                                                    if (isset($_GET['p']) && $_GET['p'] == "gu") :
                                                        echo 'active';
                                                    endif; ?>" href="index.php?p=gu"><i class="fas fa-users fa-fw"></i> Gestión de Usuarios</a>
                            </li>
                    <?php endif;
                    endif; ?>
                </ul>
            </div>
            <div class="collapse navbar-collapse justify-content-end menuColapsable">
                <span class="navbar-text mr-3">
                    Hola, <?php
                            if ($nombreS != "") :
                                echo " " . $nombreS;
                            else :
                                echo " visitante";
                            endif; ?>
                </span>
                <ul class="nav navbar-nav">
                    <li class="nav-item dropdown" id="desplegableRegistro">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user-plus fa-fw"></i> Registro</a>
                        <ul class="dropdown-menu mt-2">
                            <li class="px-3 py-2">
                                <form action="index.php" method="POST" enctype="multipart/form-data" name="formRegistro" class="">
                                    <div class="form-group">
                                        <input id="nombreRegistro" name="nombreRegistro" placeholder="Nombre" class="form-control form-control-sm" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="emailRegistro" name="emailRegistro" placeholder="Email" class="form-control form-control-sm" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="passRegistro" name="passRegistro" placeholder="Password" class="form-control form-control-sm" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="form-control rounded-pill bg-success text-white" value="Registro" id="registro" name="registro">
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown" id="desplegableLogin">
                        <?php
                        if ($nombreS == "") :
                        ?>
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user fa-fw"></i> Login</a>
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
                        <?php //si hay usuario conectado se muestra logout en lugar de login
                        else : ?>
                            <a class="nav-link" href="index.php?lgo=lgo"><i class=" fas fa-sign-out-alt fa-fw"></i> Logout</a>
                        <?php endif; ?>

                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="text-right">
        <?php
        if ($msg != "") {
            echo "<div class=\"w-100 alert alert-warning alert-dismissible mensaje\">";
            echo $msg;
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>";
            echo "</div>";
        }
        if ($error != "") {
            echo "<div class=\"w-100 alert alert-danger alert-dismissible mensaje\">";
            echo $error;
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
              </button>";
            echo "</div>";
        }
        ?>
    </div>