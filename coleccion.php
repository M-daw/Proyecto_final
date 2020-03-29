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
                        foreach ($datos as $indice => $fila) {
                            if ($indice == 0) { //solo pone las cabeceras la primera vez. Las pongo "a mano"
                                echo "<th class=\"pt-4\">";
                                echo "Nombre científico </th><th>Nombre castellano </th><th>Nombre valenciano </th><th>Familia";
                                echo "</th>";
                            }
                        ?>
                    </tr>
                </thead>
            <?php

                            echo "<tr>";
                            echo "<td> <a class=\"text-decoration-none text-white font-weight-bold\"href='index.php?p=fp&f={$fila['id_planta']}'>" . $fila['nombre_cientifico'] . "</a></td><td>" .
                                $fila['nombre_castellano'] . "</td><td>" . $fila['nombre_valenciano'] . "</td><td> " .
                                $fila['familia'] . "</td><td class=\"text-center\"> </tr>";
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