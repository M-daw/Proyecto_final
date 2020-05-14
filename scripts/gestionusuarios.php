<?php
//var_dump($_POST);echo EMAIL_ADMIN;
/**
 * Lógica de la página
 */

if (isset($_POST['modifUser'])) {
    $usuario = new Usuario();
    $usuario->edit($_POST);
    $error = $usuario->error;
    $msg = $usuario->msg;
}

if (isset($_POST['altaUser'])) {
    $usuario = new Usuario();
    $usuario->set($_POST);  //no hace falta recoger los inputs en variables, le puedo pasar $_POST como array de datos al método set
    $error = $usuario->error;
    $msg = $usuario->msg;
}

$usuario = new Usuario();

if (isset($tipoS) && $tipoS == "Administrador") {
    //solo puede acceder a la vista si es administrador. Bloqueo accesos por url

    /**
     * Vista de la página
     */
?>
    <div class="container my-5">
        <h1 class="text-success text-center my-3 dekko">Gestión de Usuarios</h1>
        <div class="table-responsive">
            <table class="table table-hover w-auto mx-auto grad">
                <?php
                $usuario->get(); //este código es de los ejercicios modelo
                if (count($usuario->get_rows()) > 0) :
                ?>
                    <thead class="bg-success">
                        <tr>
                            <?php
                            //el contenedor y la tabla se dejan fuera del if..else, para poder contener el botón de crear usuarios, que tiene que estar siempre disponible
                            $datos = $usuario->get_rows();
                            foreach ($datos as $indice => $fila) :
                                if ($indice == 0) :
                                    //solo pone las cabeceras la primera vuelta. Como no tengo acentos tomo las cabeceras de los nombres de las columnas de mi tabla
                                    foreach ($fila as $indice => $valor) : ?>
                                        <th class="pt-4">
                                            <?php echo str_replace("_usuario", "", $indice); ?>
                                        </th>
                                    <?php endforeach; ?>
                                    <th>modif.</th>
                                    <th>borrar</th>
                                <?php endif; ?>
                        </tr>
                    </thead>

                    <tr>
                        <td><?= $fila['id_usuario'] ?></td>
                        <td><?= $fila['nombre_usuario'] ?></td>
                        <td><?= $fila['email_usuario'] ?></td>
                        <td><?= $fila['pass_usuario'] ?></td>
                        <td> <?= $fila['tipo_usuario'] ?></td>
                        <td class="text-center">
                            <a href="index.php?p=mu&m=<?= $fila['id_usuario'] ?>">
                                <i class="fas fa-user-edit text-success"></i>
                            </a>
                        </td>
                        <?php
                                /*el enlace para borrar llama a un modal que muestra la confirmación del borrado.
                         Uso la librería bootbox de JQuery para construirlo. Necesito hacer una llamada AJAX y el borrado
                         debe estar en otro archivo php, en este caso, en el que contiene las funciones.
                         Un administrador no se podrá borrar a si mismo, ni al administrador principal, que tendrá la id 1
                         */
                                if ($id_usuarioS != $fila['id_usuario'] && $fila['id_usuario'] != 1) : ?>
                            <td class="text-center">
                                <a href="javascript:void(0)" class="botonBorrar" data-tipo="usuario" data-id="<?= $fila['id_usuario'] ?>">
                                    <i class="fas fa-user-times text-success"></i>
                                </a>
                            </td>
                        <?php else : ?>
                            <td></td>
                        <?php endif; ?>

                    </tr>
            <?php
                            endforeach;
                        else :
                            $msg = "NO HAY USUARIOS";
                        endif;
                        //el botón para crear usuarios tiene que estar siempre disponible, cuando hay y cuando no hay usuarios. Se saca del if..else
            ?>
            <thead>
                <tr>
                    <td colspan="<?= count($fila) + 2 ?>" class="pb-4">
                        <form action="index.php?p=au" method="POST">
                            <button type="submit" class="btn btn-outline-success bg-light px-2" name="altausuarios" value="Alta usuarios">
                                <i class="fas fa-user-plus px-\"></i> Alta usuarios
                            </button>
                        </form>
                    </td>
                </tr>
            </thead>
            </table>
        </div>
    </div>
<?php
} else {
    echo "<script>window.location.replace(\"index.php?p=404\");</script>";
}
?>