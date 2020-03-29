<?php
session_start();  //al principio, en el header

require("clases/db_abstract_model.php");
require("clases/usuarios_model.php");
require("clases/plantas_model.php");
require("lib/functions.php");

/*    ##### Sesiones #####*/

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
    <link rel="shortcut icon" type="image/png" href="img/favicon.ico" /> <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="util/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="util/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="util/swiper/css/swiper.min.css">
    <!-- librerías -->
    <script src="jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="util/bootstrap/js/bootstrap.min.js"></script>
    <script src="util/bootbox/bootbox.min.js"></script>
    <script src="util/bootbox/bootbox.locales.min.js"></script>
    <script src="util/swiper/js/swiper.min.js"></script>

    <script src="js/scripts.js"></script>

</head>

<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-md bg-success navbar-dark ">
            <a class="navbar-brand" href="index.php?p=ini">Herbario On-Line</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".menuCompasable">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center menuCompasable">
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
                    <li class="nav-item">
                        <a class="nav-link <?php
                                            if (isset($_GET['p']) && $_GET['p'] == "gp") {
                                                echo 'active';
                                            } ?>" href="index.php?p=gp"><i class="fas fa-leaf fa-fw"></i>Gestión de Plantas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php
                                            if (isset($_GET['p']) && $_GET['p'] == "gu") {
                                                echo 'active';
                                            } ?>" href="index.php?p=gu"><i class="fas fa-users fa-fw"></i>Gestión de Usuarios</a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse justify-content-end menuCompasable">
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
                                        <button type="submit" class="btn btn-success btn-block" id="submitRegistro">Registro</button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-paw fa-fw"></i> Login</a>
                        <ul class="dropdown-menu mt-2">
                            <li class="px-3 py-2">
                                <form action="index.php" method="POST" enctype="multipart/form-data" name="formLogin" class="">
                                    <div class="form-group">
                                        <input id="emailLogin" placeholder="Email" class="form-control form-control-sm" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <input id="passwordLogin" placeholder="Password" class="form-control form-control-sm" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-block" id="submitLogin">Login</button>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </li>





                </ul>
            </div>
            <span class="navbar-text">
                Hola, usuario
            </span>
        </nav>
    </header>