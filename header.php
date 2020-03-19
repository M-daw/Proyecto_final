<?php

require("clases/db_abstract_model.php");
require("clases/usuarios_model.php");
require("clases/plantas_model.php");
require("lib/functions.php");
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
    <link rel=”shortcut icon” type=”image/png” href=”/favicon.png”/> <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="util/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="util/swiper/css/swiper.min.css">
    <!-- librerías -->
    <script src="jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
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
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-paw fa-fw"></i> Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-paw fa-fw"></i> Login</a></li>
                </ul>
            </div>
            <span class="navbar-text">
                Texto que queda dentro bonito
            </span>
        </nav>
    </header>