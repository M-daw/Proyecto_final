<?php
require("header.php");
?>

<main>

    <?php
    $msg = "";
    $error = "";
    $opcion = "ini";
    //if (isset($usuario)) {   //para bloquear el acceso por querystring a las páginas si no está logueado el admin
    if (isset($_GET['p']))
        $opcion = $_GET['p'];
    if ($opcion == "ini") {
        $actual = "INICIO";
        $pagina = "home.php";
    }
    if ($opcion == "col") {
        $actual = "COLECCIÓN";
        $pagina = "coleccion.php";
    }
    if ($opcion == "gp") {
        $actual = "GESTIÓN PLANTAS";
        $pagina = "gestionplantas.php";
    }
    if ($opcion == "ga") {
        $actual = "GESTIÓN ALUMNOS";
        $pagina = "gestionalumnps.php";
    }

    //}else{
    //$pagina = "home.php";
    //$actual = "INICIO";
    //}
    ?>

    <?php
    require($pagina);
    ?>

</main>
<?php
require_once("footer.php");
?>