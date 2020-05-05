<?php
require("scripts/header.php");
?>

<main>
    <!--<div class="container pt-3"> -->
        <?php
        $msg = "";
        $error = "";
        $opcion = "ini";
        //if (isset($usuario)) {   //para bloquear el acceso por querystring a las páginas si no está logueado el admin
        if (isset($_GET['p']))
            $opcion = $_GET['p'];

        if ($opcion == "ini") {
            $pagina = "scripts/home.php";
        }
        if ($opcion == "col") {
            $pagina = "scripts/coleccion.php";
        }
        if ($opcion == "gp") {
            $pagina = "scripts/gestionplantas.php";
        }
        if ($opcion == "gu") {
            $pagina = "scripts/gestionusuarios.php";
        }
        if ($opcion == "au") {
            $pagina = "scripts/altausuarios.php";
        }
        if ($opcion == "ap") {
            $pagina = "scripts/altaplantas.php";
        }
        if ($opcion == "mu") {
            $pagina = "scripts/modifusuarios.php";
        }
        if ($opcion == "mp") {
            $pagina = "scripts/modifplantas.php";
        }
        if ($opcion == "fp") {
            $pagina = "scripts/fichaplanta.php";
        }
        if ($opcion == "bi") {
            $pagina = "scripts/borrarimagenes.php";
        }
        if ($opcion == "glu") {
            $pagina = "scripts/galeriausuarios.php";
        }

        //}else{
        //$pagina = "home.php";
        //}

        require($pagina);

        //se imprimen errores y mensajes, si los hay, después de cargar la página
        ?>

        <div class="container" id="mensajes-y-errores">
            <div class="row">
                <?php
                if ($msg != "") {
                    echo "<div class=\"alert alert-warning\">";
                    echo $msg;
                    echo "</div>";
                }
                if ($error != "") {
                    echo "<div class=\"alert alert-danger\">";
                    echo $error;
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    <!-- </div>  --> <!-- fin container -->
</main>
<?php
require_once("scripts/footer.php");
?>