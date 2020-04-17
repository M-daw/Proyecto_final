<?php
$planta = new Planta();
#capturo el error que devuelve si no hay archivo de configuración. Si no hay error, continuo
$error = $planta->error;
if ($error === "") {

    $planta->get();
    if (count($planta->get_rows()) > 0) {
?>
        <div class="container table-responsive">
            <table class="table table-hover grad w-auto mx-auto my-5">
                <thead>
                    <tr>
                        <?php
                        $datos = $planta->get_rows();
                        array_sort_by($datos, 'nombre_cientifico', $order = SORT_ASC); //los ordeno por nombre científico.
                        foreach ($datos as $indice => $fila) {
                            if ($indice == 0) { //solo pone las cabeceras la primera vez. Las pongo "a mano"
                        ?>
                                <script>
                                    var datos = '<?php echo json_encode($datos); ?>';
                                </script>

                                <th class="pt-4">
                                    <button class="btn pl-0 font-weight-bold ordenar" data-col="nombre_cientifico">Nombre científico<i class="fas fa-sort-up"></i>
                                    </button>
                                </th>
                                <th>
                                    <button class="btn pl-0 font-weight-bold ordenar" data-col="nombre_castellano">Nombre castellano<i class="fas fa-sort-up"></i>
                                    </button>
                                </th>
                                <th>
                                    <button class="btn pl-0 font-weight-bold ordenar" data-col="nombre_valenciano">Nombre valenciano<i class="fas fa-sort-up"></i>
                                    </button>
                                </th>
                                <th>
                                    <button class="btn pl-0 font-weight-bold ordenar" data-col="familia">Familia<i class="fas fa-sort-up"></i>
                                    </button>
                                </th>
                            <?php
                            }
                            ?>
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
                            <img width='75px' src='<?php
                                                    if ($fila['foto_general'] != "") {
                                                        echo $fila['foto_general'];
                                                    } else {
                                                        echo 'img/plantas/planta_default.jpg';
                                                    }
                                                    ?>'>
                        </a>
                    </td>

                </tr>
            <?php
                        }
            ?>
            </table>
        </div>
<?php
    } else {
        $msg = "NO HAY PLANTAS";
    }
}
?>