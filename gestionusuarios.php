<?php

if (isset($_POST['modifUser'])) {
    $usuario = new Usuario();
    $usuario->edit($_POST);
    $error = $usuario->error;
    $msg = $usuario->msg;
}
if (isset($_POST['borrSI'])) {
    $usuario = new Usuario();
    $usuario->delete($_POST['b']);
    $error = $usuario->error;
    $msg = $usuario->msg;
}

if (isset($_GET['b'])) {

    echo "<form action='index.php?p=gu' method='POST' >";
    echo "Vas a borrar al usuario " . $_GET['b'] . ". ¿Estás seguro?<br/><br/>";
    echo "<input type='submit' value='SI' name='borrSI'/>";
    echo "<input type='submit' value='NO' name='borrNO'/>";
    echo "<input type='hidden' value='{$_GET['b']}' name='b'/>";
    echo "</form>";
}


$usuario = new Usuario();
#capturo el error que devuelve si no hay archivo de configuración. Si no hay error, continuo
$error = $usuario->error;
if ($error === "") {
?>

    <div class="container table-responsive">
        <table class="table table-hover grad w-auto mx-auto my-5">

            <?php

            $usuario->get(); //esto es del original
            if (count($usuario->get_rows()) > 0) {
            ?>

                <thead>
                    <tr>
                        <?php
                        //el contenedor y la tabla se dejan fuera del if..else, para poder contener el botón de crear usuarios, que tiene que estar siempre disponible
                        $datos = $usuario->get_rows();
                        foreach ($datos as $indice => $fila) {
                            if ($indice == 0) { //solo pone las cabeceras la primera vez
                                foreach ($fila as $indice => $valor) {
                                    echo "<th class=\"pt-4\">";
                                    echo str_replace("_usuario", "", $indice);
                                    echo "</th>";
                                }
                        ?>
                                <th>borrar</th>
                                <th>modif.</th>
                    </tr>
                </thead>
    <?php
                            }
                            echo "<tr>";
                            echo "<td>" . $fila['id_usuario'] . "</td><td>" . $fila['nombre_usuario'] . "</td><td>" .
                                $fila['email_usuario'] . "</td><td>" . $fila['pass_usuario'] . "</td><td> " .
                                $fila['tipo_usuario'] . "</td><td class=\"text-center\"> ";
                            echo "<a href='index.php?p=gu&b={$fila['id_usuario']}'><i class=\"fas fa-user-times text-success\"></i> </a></td><td class=\"text-center\">";
                            echo "<a href='index.php?p=mu&m={$fila['id_usuario']}'><i class=\"fas fa-user-edit text-success\"></i> </a></td>";
                            echo "</tr>";
                        }
                    } else {
                        $msg = "NO HAY USUARIOS";
                    }
                    //el botón para crear usuarios tiene que estar siempre disponible. Se saca del if..else
    ?>
    <thead>
        <tr>
            <td colspan="<?= count($fila) + 2 ?>" class="pb-4">
                <form action='index.php?p=au' method='POST'>
                    <button type='submit' value='Alta usuarios' name='altausuarios' class="btn btn-outline-success bg-light px-2"> <i class="fas fa-user-plus px-\"></i> Alta usuarios</button>
                </form>
            </td>
        </tr>
    </thead>
        </table>
    </div>
<?php
}
?>