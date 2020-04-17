<?php
//var_dump($_POST);
if (isset($_POST['modifUser'])) {
    $usuario = new Usuario();
    $usuario->edit($_POST);
    $error = $usuario->error;
    $msg = $usuario->msg;
}
/*
//antes de añadir el modal se borraba y se pedía la confirmación en esta misma página
if (isset($_POST['borrSI'])) {
    $usuario = new Usuario();
    $usuario->delete($_POST['b']);
    $error = $usuario->error;
    $msg = $usuario->msg;
}
if (isset($_GET['b'])) {
    //la confirmación del borrado se hace en un modal. Necesito hacer una llamada AJAX y el borrado debe estar en otro archivo php
    echo "<form action='index.php?p=gu' method='POST' >";
    echo "Vas a borrar al usuario " . $_GET['b'] . ". ¿Estás seguro?<br/><br/>";
    echo "<input type='submit' value='SI' name='borrSI'/>";
    echo "<input type='submit' value='NO' name='borrNO'/>";
    echo "<input type='hidden' value='{$_GET['b']}' name='b'/>";
    echo "</form>";
}
*/

if (isset($_POST['altaUser'])) {
    $usuario = new Usuario();
    $usuario->set($_POST);  //no hace falta recoger los inputs en variables, le puedo pasar $_POST como array de datos al método set
    $error = $usuario->error;
    $msg = $usuario->msg;
}

$usuario = new Usuario();
#capturo el error que devuelve si no hay archivo de configuración. Si no hay error, continuo
$error = $usuario->error;
if ($error === "") {
?>

    <div class="table-responsive">
        <table class="table table-hover w-auto mx-auto my-5 grad">

            <?php
            $usuario->get(); //este código es de los ejercicios modelo
            if (count($usuario->get_rows()) > 0) {
            ?>
                <thead>
                    <tr>
                        <?php
                        //el contenedor y la tabla se dejan fuera del if..else, para poder contener el botón de crear usuarios, que tiene que estar siempre disponible
                        $datos = $usuario->get_rows();
                        foreach ($datos as $indice => $fila) {
                            if ($indice == 0) { //solo pone las cabeceras la primera vuelta
                                foreach ($fila as $indice => $valor) { //como no tengo acentos tomo las cabeceras de los nombres de las columnas de mi tabla
                                    echo "<th class=\"pt-4\">";
                                    echo str_replace("_usuario", "", $indice);
                                    echo "</th>\n";
                                }
                        ?>
                                <th>borrar</th>
                                <th>modif.</th>
                    </tr>
                </thead>
    <?php
                            }
                            echo "<tr>\n";
                            echo "<td>" . $fila['id_usuario'] . "</td>\n<td>" . $fila['nombre_usuario'] . "</td>\n<td>" .
                                $fila['email_usuario'] . "</td>\n<td>" . $fila['pass_usuario'] . "</td>\n<td> " .
                                $fila['tipo_usuario'] . "</td>\n";
                            //echo "<a href='index.php?p=gu&b={$fila['id_usuario']}'><i class=\"fas fa-user-times text-success\"></i> </a></td>";  //"botón" cuando se borraba en esta misma página
                            //con el nuevp "botón" para borrar llamo a un modal que muestra la confirmación del borrado. Uso la librería bootbox de JQuery para construirlo. Necesito hacer una llamada AJAX y el borrado debe estar en otro archivo php, en este caso, en el que contiene las funciones
                            echo "<td class=\"text-center\"><a href='javascript:void(0)' class='botonBorrar' data-tipo ='usuario' data-id='{$fila['id_usuario']}'><i class=\"fas fa-user-times text-success\"></i></a></td>\n";
                            echo "<td class=\"text-center\"><a href='index.php?p=mu&m={$fila['id_usuario']}'><i class=\"fas fa-user-edit text-success\"></i> </a></td>\n";
                            echo "</tr>\n";
                        }
                    } else {
                        $msg = "NO HAY USUARIOS";
                    }
                    //el botón para crear usuarios tiene que estar siempre disponible, cuando hay y cuando no hay usuarios. Se saca del if..else
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