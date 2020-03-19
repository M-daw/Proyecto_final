<?php
require("header.php");
?>

<main>
    <div class="container pt-3">
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
        if ($opcion == "gu") {
            $actual = "GESTIÓN USUARIOS";
            $pagina = "gestionusuarios.php";
        }
        if ($opcion == "au") {
            $actual = "ALTA USUARIOS";
            $pagina = "altausuarios.php";
        }
        if ($opcion == "ap") {
            $actual = "ALTA PLANTAS";
            $pagina = "altaplantas.php";
        }
        if ($opcion == "mu") {
            $actual = "MODIFICACIÓN USUARIOS";
            $pagina = "modifusuarios.php";
        }
        if ($opcion == "mp") {
            $actual = "MODIFICACIÓN PLANTAS";
            $pagina = "modifplantas.php";
        }
        if ($opcion == "fp") {
            $actual = "FICHA PLANTA";
            $pagina = "fichaplanta.php";
        }


        //}else{
        //$pagina = "home.php";
        //$actual = "INICIO";
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
    </div><!-- fin container -->
</main>
<?php
require_once("footer.php");
?>