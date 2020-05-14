<?php
require("scripts/header.php");

?>

<main>
    <?php
    $msg = "";
    $error = "";
    $opcion = "ini";

    if (isset($_GET['p']))
        $opcion = $_GET['p'];

    if ($opcion == "ini") {
        $pagina = "scripts/home.php";
    } else
    if ($opcion == "col") {
        $pagina = "scripts/coleccion.php";
    } else
    if ($opcion == "gp") {
        $pagina = "scripts/gestionplantas.php";
    } else
    if ($opcion == "gu") {
        $pagina = "scripts/gestionusuarios.php";
    } else
    if ($opcion == "au") {
        $pagina = "scripts/altausuarios.php";
    } else
    if ($opcion == "ap") {
        $pagina = "scripts/altaplantas.php";
    } else
    if ($opcion == "mu") {
        $pagina = "scripts/modifusuarios.php";
    } else
    if ($opcion == "mp") {
        $pagina = "scripts/modifplantas.php";
    } else
    if ($opcion == "fp") {
        $pagina = "scripts/fichaplanta.php";
    } else
    if ($opcion == "bi") {
        $pagina = "scripts/borrarimagenes.php";
    } else
    if ($opcion == "glu") {
        $pagina = "scripts/galeriausuarios.php";
    } else
    if ($opcion == "404") {
        $pagina = "scripts/404.php";
    } else {
        $pagina = "scripts/404.php";
    }

    require($pagina);

    //se imprimen errores y mensajes, si los hay, después de cargar la página
    ?>

    <div class="container my-5" id="mensajes-y-errores">
        <div class="row">
            <?php
            if ($msg != "") {
                echo "<div class=\"alert alert-success\">";
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
</main>
<?php
require_once("scripts/footer.php");
?>