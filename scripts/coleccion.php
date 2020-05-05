<?php

/**
 * Lógica de la página
 */
//var_dump($_POST);
$planta = new Planta();
#capturo el mensaje que devuelve si no hay archivo de configuración. Si no hay error, continuo
$error = $planta->error;
//si hay archivo de configuración continuo. No hay un else, porque el mensaje de error se muestra en index.php, después de las páginas
if ($error === "") {
    $msgFiltrado = "";
    $errorFiltrado = "";
    $familiabuscado = "";
    $valorbuscado = "";
    if (isset($_POST['q']))
        $valorbuscado = $_POST['q'];
    if (isset($_POST['familia']))
        $familiabuscado = $_POST['familia'];

    $planta->get();   //búsqueda de todas las plantas de la base de datos
    if (count($planta->get_rows()) > 0) {  //si hay alguna planta en la base de datos...

        if (isset($_POST['buscar']) || isset($_POST['filtrar'])) {  //uso el mismo formulario para filtrar y buscar, compruebo ambos submit
            $busqueda = trim($_POST["q"]);
            //primero compruebo si hay un término de búsqueda
            if (empty($busqueda) && isset($_POST['buscar'])) {
                $msgFiltrado = "No se ha introducido término a buscar";  //no uso el $msg y creo una nueva variable para mostrarla antes de la tabla de resultados
            } else if (!empty($busqueda)) {
                $plantaB = new Planta();  //si existe el término de búsqueda se crea un nuevo objeto planta, que contiene el resultado de hacer un select a la BD con ese término
                $plantaB->buscar($busqueda);
                $msgFiltrado = $plantaB->msg;
            }
            //defino cual va a ser mi array de datos, según si he buscado algo o no
            if (isset($plantaB) && count($plantaB->get_rows()) > 0) {
                $datos = $plantaB->get_rows();
            } else {
                $datos = $planta->get_rows();
            }
            //y una vez tengo el array de datos, lo filtro en función de la/s familia/s seleccionadas
            if (!empty($_POST['familia'])) {
                $aux = array();  //creo un array auxiliar para introducir las filas que se ajustan al filtro
                foreach ($datos as $indice => $fila) {
                    if ($fila['familia'] == $_POST['familia']) {
                        $aux[] = $fila;
                    }
                }
                $datos = $aux;  //sustituyo el array de datos por el auxiliar, para usar siempre $datos como mi array 
            }
        } else {
            //si no pulsado ninguno de los botones de mi formulario de filtrado+búasqueda, defino el array de datos
            $datos = $planta->get_rows();
        }
        /**
         * Vista de la página
         */
?>
        <div class="container table-responsive">
            <div class="container mt-5">
                <form id="buscador" name="buscador" method="post" action="index.php?p=col">
                    <div class="input-group border rounded-pill bg-white col-sm-10 col-md-7 col-lg-6 mx-auto">
                        <div class="input-group-prepend">
                            <button name="buscar" type="submit" class="btn btn-link text-success">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <input type="search" class="form-control border-0 rounded-pill" name="q" value="
                        <?php if (isset($valorbuscado)) :
                            echo $valorbuscado;
                        endif; ?>" placeholder="Buscar..." minlength="3">
                    </div>
                    <div class="form-group row mt-4">
                        <div class="col-sm-6 col-md-4 ml-auto">
                            <?php
                            $familias =  new Planta();
                            $familias->getFamilies();
                            if (count($familias->get_rows()) > 0) :
                                $html = dibuja_select("familia", $familias->get_rows(), "familia", $familiabuscado, "", "", true);
                                echo $html;
                            endif; ?>
                        </div>
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mt-2 mt-sm-0 mr-auto">
                            <input type="submit" class="form-control rounded-pill bg-success text-white" name="filtrar" value="Filtrar">
                        </div>
                    </div>
                </form>
            </div>
            <div class="container">
                <div class="row">
                    <?php if ($msgFiltrado != "") :
                        echo "<div class=\"alert alert-warning\">";
                        echo $msgFiltrado;
                        echo "</div>";
                    endif;
                    if ($errorFiltrado != "") :
                        echo "<div class=\"alert alert-danger\">";
                        echo $errorFiltrado;
                        echo "</div>";
                    endif; ?>
                </div>
            </div>
            <table class="table table-hover w-auto mx-auto my-5 grad">
                <thead class="bg-hoja">
                    <tr>
                        <?php
                        array_sort_by($datos, 'nombre_cientifico', $order = SORT_ASC); //por defecto los ordeno por nombre científico.
                        foreach ($datos as $indice => $fila) :
                            //solo pone las cabeceras la primera vez. Las pongo "a mano" porque las cabeceras de la base de datos no tienen acentos
                            if ($indice == 0) : ?>
                                <script>
                                    var datos = '<?= json_encode($datos); ?>'; //recojo los datos para enviarlos por AJAX. ¡comillas simples, con dobles NO FUNCIONA!
                                </script>
                                <th class="pt-4">
                                    <button class="btn pl-0 font-weight-bold ordenar" data-col="nombre_cientifico">
                                        Nombre científico<i class="fas fa-sort-up"></i>
                                    </button>
                                </th>
                                <th>
                                    <button class="btn pl-0 font-weight-bold ordenar" data-col="nombre_castellano">
                                        Nombre castellano<i class="fas fa-sort-up"></i>
                                    </button>
                                </th>
                                <th>
                                    <button class="btn pl-0 font-weight-bold ordenar" data-col="nombre_valenciano">
                                        Nombre valenciano<i class="fas fa-sort-up"></i>
                                    </button>
                                </th>
                                <th>
                                    <button class="btn pl-0 font-weight-bold ordenar" data-col="familia">
                                        Familia<i class="fas fa-sort-up"></i>
                                    </button>
                                </th>
                                <th></th>
                            <?php endif; ?>
                    </tr>
                </thead>
                <tr>
                    <td>
                        <a class="text-decoration-none text-white font-weight-bold" href="index.php?p=fp&f=<?= $fila['id_planta']; ?>">
                            <?= $fila['nombre_cientifico'] ?>
                        </a>
                    </td>
                    <td><?= $fila['nombre_castellano'] ?></td>
                    <td><?= $fila['nombre_valenciano'] ?></td>
                    <td><?= $fila['familia'] ?></td>
                    <td>
                        <a href="index.php?p=fp&f=<?= $fila['id_planta']; ?>">
                            <img width="75px" src="<?php if ($fila['foto_general'] != "") :
                                                        echo $fila['foto_general'];
                                                    else :
                                                        echo 'img/plantas/planta_default.jpg';
                                                    endif; ?>" alt="miniatura de <?= $fila['nombre_cientifico'] ?>">
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>
            <div class="col-6 col-sm-4 col-lg-3 col-form-label mx-auto">
                <button class="form-control rounded-pill btn btn-success">
                    <a class="text-decoration-none text-white" href="scripts/listar.php" target="_blank">Listar las plantas</a>
                </button>
            </div>
        </div> <!-- fin contenedor para tabla responsiva-->
<?php
    } else {  //si aún no hay plantas en la base de datos
        $msg = "NO HAY PLANTAS GUARDADAS";
    }
}
?>