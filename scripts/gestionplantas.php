<?php
//var_dump($_FILES); 
//var_dump($_POST);
if (isset($_POST['modifPlanta'])) {
    $planta = new Planta();
    //$planta->edit($_POST);  //no puedo usar $_POST porque tb tengo datos en $_FILES
    $id_planta = $_POST['id_planta'];
    $planta->get($id_planta); //de forma provisional, recupero los datos de la planta a modificar, para poder acceder a sus imágenes
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
    if ($foto_general == "")
        $foto_general = $planta->foto_general; //si no he actualizado la foto, tomo la que tenía guardada, para evitar borrarla durante la actualización
    $foto_flor = subirImagen('foto_flor');
    if ($foto_flor == "")
        $foto_flor = $planta->foto_flor;
    $foto_hoja = subirImagen('foto_hoja');
    if ($foto_hoja == "")
        $foto_hoja = $planta->foto_hoja;
    $foto_fruto = subirImagen('foto_fruto');
    if ($foto_fruto == "")
        $foto_fruto = $planta->foto_fruto;
    $id_usuario = $_POST['id_usuario'];
    $datos = array('nombre_cientifico' => $nombre_cientifico, 'nombre_castellano' => $nombre_castellano, 'nombre_valenciano' => $nombre_valenciano, 'nombre_ingles' => $nombre_ingles, 'familia' => $familia, 'caracteres_diagnosticos' => $caracteres_diagnosticos, 'uso' => $uso, 'biotipo' => $biotipo, 'habitat' => $habitat, 'distribucion' => $distribucion, 'cat_UICN' => $cat_UICN, 'floracion' => $floracion, 'foto_general' => $foto_general, 'foto_flor' => $foto_flor, 'foto_hoja' => $foto_hoja, 'foto_fruto' => $foto_fruto, 'id_usuario' => $id_usuario, 'id_planta' => $id_planta);
    $planta->edit($datos);
    $error = $planta->error;
    $msg = $planta->msg;
}
/* 
//antes de añadir el modal se borraba y se pedía la confirmación en esta misma página
if (isset($_POST['borrSI'])) {
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
if ($error === "") {
?>

    <div class="container table-responsive">
        <table class="table table-hover grad w-auto mx-auto my-5">

            <?php
            //el contenedor y la tabla se dejan fuera del if..else, para poder contener el botón de crear plantas, que tiene que estar siempre disponibles
            $planta->get();  //este código es de los ejercicios modelo
            if (count($planta->get_rows()) > 0) : ?>
                <thead>
                    <tr>
                        <?php
                        $datos = $planta->get_rows();
                        foreach ($datos as $indice => $fila) :
                            //solo se ponen las cabeceras la primera vuelta. Se escriben a mano porque los nombres de las columnas en las tablas no tienen acentos
                            if ($indice == 0) : ?>
                                <th class="pt-4">Id</th>
                                <th>Nombre científico</th>
                                <th>Nombre castellano</th>
                                <th>Nombre valenciano</th>
                                <th>Familia</th>
                                <th>modif.</th>
                                <?php
                                //solo los usuarios de tipo Administrador pueden borrar plantas de la base de datos
                                if ($tipoS == "Administrador") : ?>
                                    <th>borrar</th>
                                <?php endif; ?>          
                            <?php endif; ?>
                    </tr>
                </thead>

                <tr>
                    <th><?= $fila['id_planta'] ?></th>
                    <th><?= $fila['nombre_cientifico'] ?></th>
                    <td><?= $fila['nombre_castellano'] ?></td>
                    <td><?= $fila['nombre_valenciano'] ?></td>
                    <td><?= $fila['familia'] ?></td>
                    <td class="text-center"><a href="index.php?p=mp&m=<?= $fila['id_planta'] ?>"><i class="fas fa-user-edit text-success"></i> </a></td>
                    <?php
                            if ($tipoS == "Administrador") :  ?>
                        <!-- <a href="index.php?p=gp&b=<?= $fila['id_planta'] ?>"><i class="fas fa-user-times text-success"></i></a></td>  botón" cuando se borraba en esta misma página -->
                        <td class="text-center"><a href='javascript:void(0)' class="botonBorrar" data-tipo="planta" data-id="<?= $fila['id_planta'] ?>"><i class="fas fa-user-times text-success"></i></a></td>

                    <?php endif; ?>
                </tr>
        <?php
                        endforeach;
                    else :
                        $msg = "NO HAY PLANTAS";
                    endif;
                    //el botón para crear plantas tiene que estar siempre disponible. Se saca del if..else
        ?>
        <thead>
            <tr>
                <td colspan="<?= count($fila) + 2 ?>" class="pb-4">
                    <form action="index.php?p=ap" method="POST">
                        <button type="submit" class="btn btn-outline-success bg-light px-2" name="altaplantas" value="Alta Plantas">
                            <i class="fas fa-user-plus px-\"></i> Alta plantas
                        </button>
                    </form>
                </td>
            </tr>
        </thead>
        </table>
    </div>

<?php
}
?>