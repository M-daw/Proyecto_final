<?php

/**
 * Lógica de la página
 */
if (isset($tipoS) && $tipoS == "Administrador") {
    //solo puede acceder a la vista si es administrador. Bloqueo accesos por url
    $usuario = new Usuario();
    $usuario->get($_GET['m']);  //recojo los datos del usuario a modificar para pasarlos a los inputs
    $id = $usuario->id_usuario;
    $nombre = $usuario->nombre_usuario;
    $email = $usuario->email_usuario;
    $pass = $usuario->pass_usuario;
    $tipo = $usuario->tipo_usuario;
    $tipos = $usuario->getSQLEnumArray('usuarios', 'tipo_usuario'); //los tipos de usuarios para el select se van a coger de los permitidos en el enum definido en la base de datos. No voy a usar los valores que ya hay, porque cuando solo tengo definido mi admin no tengo usuarios de tipo colaborador o usuario para coger ese valor y construir mi select.

    /**
     * Vista de la página
     */
?>
    <div class="container my-5">
    <h1 class="text-success text-center dekko">Modificación de usuarios</h1>
        <div class="row ">
            <div class="card d-none d-lg-block col-lg-3 bg-light">
                <div class="card-body">
                    <h5 class="card-title text-center text-success">Datos del usuario</h5>
                </div>
                <img class="card-img-bottom" src="img/web/lateral-formulario.png" alt="imagen con flores para decorar el formulario" loading="lazy">
            </div>
            <div class="card card-body col-lg-9 col-xl-8">
                <form class="pt-5" action="index.php?p=gu" method="POST" enctype="multipart/form-data" name="formModiusuario" id="formModiusuario">
                    <input type="hidden" name="id_usuario" value="<?php if (isset($id)) :
                                                                        echo $id;
                                                                    endif; ?>" maxlength="10" size="40">

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Nombre:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill" name="nombre_usuario" value="<?php if (isset($nombre)) :
                                                                                                                    echo $nombre;
                                                                                                                endif; ?>" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>E-mail:</label>
                        <div class="col-md-10">
                            <input type="email" class="form-control rounded-pill" name="email_usuario" value="<?php if (isset($email)) :
                                                                                                                    echo $email;
                                                                                                                endif; ?>" maxlength="40" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Contraseña:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill" name="pass_usuario" value="<?php if (isset($pass)) :
                                                                                                                echo $pass;
                                                                                                            endif; ?>" minsize="6" maxlength="16" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tipo:</label>
                        <div class="col-6 col-sm-6 col-lg-5">
                            <?php if ($tipo != "Administrador") : ?>
                                <select class="form-control rounded-pill" name="tipo_usuario" id="tipo_usuario">
                                    <?php foreach ($tipos as $valor) :
                                        echo "<option value=\"$valor\" ";
                                        if ($tipo == $valor) :
                                            echo "selected=\"selected\"";
                                        endif;
                                        echo ">$valor</option>";
                                    endforeach; ?>
                                </select>
                            <?php else : ?>
                                <select class="form-control rounded-pill" name="tipo_usuario" id="tipo_usuario">
                                    <?php
                                    echo "<option value=\"$tipo\" ";
                                    echo "selected=\"selected\"";
                                    echo ">$tipo</option>";
                                    ?>
                                </select>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                            <input type="submit" class="form-control rounded-pill bg-success text-white" value="Modificar Usuario" name="modifUser">
                        </div>
                        <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                            <button class="form-control rounded-pill btn btn-success">
                                <a href="index.php?p=gu" class="text-decoration-none text-white">Cancelar</a>
                            </button>
                        </div>
                    </div>
                    <p class="small"><span class="text-danger">*</span>Datos requeridos</p>
                </form>
            </div> <!-- fin contenedor del formulario -->
        </div> <!-- fin row -->
    </div> <!-- fin container -->
<?php
} else {
    echo "<script>window.location.replace(\"index.php?p=404\");</script>";
}
?>