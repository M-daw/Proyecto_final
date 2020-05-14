<?php
session_start();  //al principio, en el header

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
    $pass = trim($_POST['passLogin']);
    $email = trim($_POST['emailLogin']);
    $usuario = new Usuario();
    $error = $usuario->error;
    if ($error == "") {
        $usuario->login($email, $pass);
        $tipoS = $usuario->tipo_usuario;
        $emailS = $usuario->email_usuario;
        $nombreS = $usuario->nombre_usuario;
        $id_usuarioS = $usuario->id_usuario;
        $error = $usuario->error;
        $msg = $usuario->msg;
    }
}

//registro de usuarios
if (isset($_POST['registro'])) {
    $passRegistro = trim($_POST['passRegistro']);
    $emailRegistro = trim($_POST['emailRegistro']);
    $nombreRegistro = trim($_POST['nombreRegistro']);
    $devuelto = enviarMail($emailRegistro, $nombreRegistro, $passRegistro);
    if ($devuelto[0] == "N") {
        $error = $devuelto;
    } else {
        $msg = $devuelto;
    }
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php
            if (isset($_GET['f'])) :
                $id = $_GET['f'];
                $prefijo = new Planta();
                $error = $prefijo->error;
                if ($error === "") :
                    $prefijo->get($id);
                endif;
                echo $prefijo->nombre_cientifico;
            endif;

            if (isset($_GET['p'])) :
                $opcion = $_GET['p'];
            else :
                $opcion = "ini";
            endif;
            if (!array_key_exists($opcion, $titulos)) :
                $opcion = "ini";
            endif;
            echo  $titulos[$opcion];
            ?></title>
    <meta name="description" content="<?php
                                        /*la meta-description y título van a depender de la página. Los arrays con las descripciones y títulos se encuentran en 
    el archivo functions.php y no todas las páginas van a tener una descripción. Compruebo la página en la que me encuentro, y 
    después compruebo si esa página tiene descripción propia. Por defecto se muestra la descripción del Home*/
                                        if (isset($_GET['f'])) :
                                            $id = $_GET['f'];
                                            $prefijo = new Planta();
                                            $error = $prefijo->error;
                                            if ($error === "") :
                                                $prefijo->get($id);
                                            endif;
                                            echo $prefijo->nombre_cientifico;
                                        endif;
                                        if (isset($_GET['p'])) :
                                            $opcion = $_GET['p'];
                                        else :
                                            $opcion = "ini";
                                        endif;
                                        if (!array_key_exists($opcion, $descripciones)) :
                                            $opcion = "ini";
                                        endif;
                                        echo  $descripciones[$opcion];
                                        ?>">
    <meta name="author" content="M-DAW">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="BSZyCWo24WHxU4DVV_JOOonVk6kox2ThBykTpGAxgxQ">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="img/web/favicon.ico">
    <!-- links CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/swiper.min.css">
    <!-- librerías JS -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootbox.min.js"></script>
    <script src="js/bootbox.locales.min.js"></script>
    <script src="js/swiper.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/scripts.js"></script>

</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg bg-hoja navbar-dark ">
            <a class="navbar-brand macondo rotado" href="index.php?p=ini">Herbario OnLine</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".menuColapsable">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end menuColapsable">
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
                <span class="navbar-text mr-3 d-none d-lg-block">
                    Hola, <?php
                            if ($nombreS != "") :
                                echo " " . $nombreS;
                            else :
                                echo " visitante";
                            endif; ?>
                </span>
                <ul class="nav navbar-nav">
                    <?php //si el usuario no está conectado se muestran login, y registro
                    if ($nombreS == "") :
                    ?>
                        <li class="nav-item dropdown" id="desplegableRegistro">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user-plus fa-fw"></i> Registro</a>
                            <ul class="dropdown-menu mt-2">
                                <li class="px-3 py-2">
                                    <form action="index.php" method="POST" enctype="multipart/form-data" name="formRegistro" class="">
                                        <div class="col-form-label-sm">Introduce tus datos</div>
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
                            <?php //si hay usuario conectado se muestra logout en lugar de login, y no se muestra la opción de registro
                        else : ?>
                                <li class="nav-item">
                                    <a class=" nav-link" href="index.php?lgo=lgo"><i class=" fas fa-sign-out-alt fa-fw"></i> Logout</a>
                                </li>
                            <?php endif; ?>

                            </ul>
                        </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="text-right">
        <?php
        if ($msg != "") {
            echo "<div class=\"w-100 alert alert-success alert-dismissible mensaje\">";
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