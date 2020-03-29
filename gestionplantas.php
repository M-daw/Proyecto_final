<?php
//var_dump($_POST);
if (isset($_POST['modifPlanta'])) {
    $planta = new Planta();
    //$planta->edit($_POST);  //no puedo usar $_POST porque tb tengo datos en $_FILES
    $nombre_cientifico = $_POST['nombre_cientifico'];
    $nombre_castellano = $_POST['nombre_castellano'];
    $nombre_valenciano = $_POST['nombre_valenciano'];
    $nombre_ingles = $_POST['nombre_ingles'];
    $familia = $_POST['familia'];
    $caracteres_diagnosticos = $_POST['caracteres_diagnosticos'];
    $uso = $_POST['uso'];
    $biotipo = $_POST['biotipo'];
    $habitat = $_POST['habitat'];
    $distribucion = $_POST['distribucion'];
    $cat_UICN = $_POST['cat_UICN'];
    $floracion = $_POST['floracion'];
    $foto_general = subirImagen('foto_general');
    $foto_flor = subirImagen('foto_flor');
    $foto_hoja = subirImagen('foto_hoja');
    $foto_fruto = subirImagen('foto_fruto');
    $id_usuario = $_POST['id_usuario'];
    $id_planta = $_POST['id_planta'];
    $datos = array('nombre_cientifico' => $nombre_cientifico, 'nombre_castellano' => $nombre_castellano, 'nombre_valenciano' => $nombre_valenciano, 'nombre_ingles' => $nombre_ingles, 'familia' => $familia, 'caracteres_diagnosticos' => $caracteres_diagnosticos, 'uso' => $uso, 'biotipo' => $biotipo, 'habitat' => $habitat, 'distribucion' => $distribucion, 'cat_UICN' => $cat_UICN, 'floracion' => $floracion, 'foto_general' => $foto_general, 'foto_flor' => $foto_flor, 'foto_hoja' => $foto_hoja, 'foto_fruto' => $foto_fruto, 'id_usuario' => $id_usuario, 'id_planta' => $id_planta);
    $planta->edit($datos);
    $error = $planta->error;
    $msg = $planta->msg;
}
/* if (isset($_POST['borrSI'])) {
    $planta = new PLanta();
    $planta->delete($_POST['b']);
    $error = $planta->error;
    $msg = $planta->msg;
} 

if (isset($_GET['b'])) {

    echo "<form action='index.php?p=gp' method='POST' >";
    echo "Vas a borrar la planta " . $_GET['b'] . ". ¿Estás seguro?<br/><br/>";
    echo "<input type='submit' value='SI' name='borrSI'/>";
    echo "<input type='submit' value='NO' name='borrNO'/>";
    echo "<input type='hidden' value='{$_GET['b']}' name='b'/>";
    echo "</form>";
}
*/

$nombre_cientifico = "";
$nombre_castellano = "";
$nombre_valenciano = "";
$nombre_ingles = "";
$familia = "";
$caracteres_diagnosticos = "";
$uso = "";
$biotipo = "";
$habitat = "";
$distribucion = "";
$cat_UICN = "";
$floracion = "";
$foto_general = "";
$foto_flor = "";
$foto_hoja = "";
$foto_fruto = "";
$id_usuario = "";
//$aux = new Planta();
//$biotipos = $aux->getSQLEnumArray('plantas', 'biotipo');
//$categorias = $aux->getSQLEnumArray('plantas', 'cat_UICN');
if (isset($_POST['altaPlanta'])) {
    $nombre_cientifico = $_POST['nombre_cientifico'];
    $nombre_castellano = $_POST['nombre_castellano'];
    $nombre_valenciano = $_POST['nombre_valenciano'];
    $nombre_ingles = $_POST['nombre_ingles'];
    $familia = $_POST['familia'];
    $caracteres_diagnosticos = $_POST['caracteres_diagnosticos'];
    $uso = $_POST['uso'];
    $biotipo = $_POST['biotipo'];
    $habitat = $_POST['habitat'];
    $distribucion = $_POST['distribucion'];
    $cat_UICN = $_POST['cat_UICN'];
    $floracion = $_POST['floracion'];
    $foto_general = subirImagen('foto_general');
    $foto_flor = subirImagen('foto_flor');
    $foto_hoja = subirImagen('foto_hoja');
    $foto_fruto = subirImagen('foto_fruto');
    $id_usuario = $_POST['id_usuario'];
    $planta = new Planta();
    //$planta->set($_POST); //no puedo usar $_POST porque las imágenes están en $_FILES
    $datos = array('nombre_cientifico' => $nombre_cientifico, 'nombre_castellano' => $nombre_castellano, 'nombre_valenciano' => $nombre_valenciano, 'nombre_ingles' => $nombre_ingles, 'familia' => $familia, 'caracteres_diagnosticos' => $caracteres_diagnosticos, 'uso' => $uso, 'biotipo' => $biotipo, 'habitat' => $habitat, 'distribucion' => $distribucion, 'cat_UICN' => $cat_UICN, 'floracion' => $floracion, 'foto_general' => $foto_general, 'foto_flor' => $foto_flor, 'foto_hoja' => $foto_hoja, 'foto_fruto' => $foto_fruto, 'id_usuario' => $id_usuario);
    $planta->set($datos);
    $error = $planta->error;
    $msg = $planta->msg;
}

$planta = new Planta();
#capturo el error que devuelve si no hay archivo de configuración. Si no hay error, continuo
$error = $planta->error;
//$error = $aux-> error;
if ($error === "") {

?>

    <div class="container table-responsive">
        <table class="table table-hover grad w-auto mx-auto my-5">

            <?php
            //el contenedor y la tabla se dejan fuera del if..else, para poder contener el botón de crear plantas, que tiene que estar siempre disponible
            $planta->get(); //esto es del original
            if (count($planta->get_rows()) > 0) {
            ?>
                <thead>
                    <tr>
                        <?php
                        $datos = $planta->get_rows();
                        foreach ($datos as $indice => $fila) {
                            if ($indice == 0) { //solo pone las cabeceras la primera vez

                                echo "<th class=\"pt-4\">";
                                echo "Nombre científico </th><th>Nombre castellano </th><th>Nombre valenciano </th><th>Familia";
                                echo "</th>";

                        ?>
                                <th>borrar</th>
                                <th>modif.</th>
                    </tr>
                </thead>
    <?php
                            }
                            echo "<tr>";
                            echo "<th>" . $fila['nombre_cientifico'] . "</th><td>" .
                                $fila['nombre_castellano'] . "</td><td>" . $fila['nombre_valenciano'] . "</td><td> " .
                                $fila['familia'] . "</td><td class=\"text-center\"> ";
                            //echo "<a href='index.php?p=gp&b={$fila['id_planta']}'><i class=\"fas fa-user-times text-success\"></i> </a></td><td class=\"text-center\">";
                            echo "<a href='javascript:void(0)' class='botonBorrar' data-tipo ='planta' data-id='{$fila['id_planta']}'><i class=\"fas fa-user-times text-success\"></i></a></td><td class=\"text-center\">";
                            echo "<a href='index.php?p=mp&m={$fila['id_planta']}'><i class=\"fas fa-user-edit text-success\"></i> </a></td>";
                            echo "</tr>";
                        }
                    } else {
                        $msg = "NO HAY PLANTAS";
                    }
                    //el botón para crear plantas tiene que estar siempre disponible. Se saca del if..else
    ?>
    <thead>
        <tr>
            <td colspan="<?= count($fila) + 2 ?>" class="pb-4">
                <form action='index.php?p=ap' method='POST'>
                    <button type='submit' value='Alta Plantas' name='altaplantas' class="btn btn-outline-success bg-light px-2"> <i class="fas fa-user-plus px-\"></i> Alta plantas</button>
                </form>
            </td>
        </tr>
    </thead>
        </table>
    </div>

<?php
}
?>