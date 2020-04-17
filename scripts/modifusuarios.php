<?php
$usuario = new Usuario();
$usuario->get($_GET['m']);  //recojo los datos del usuario a modificar para pasarlos a los inputs
$id = $usuario->id_usuario;
$nombre = $usuario->nombre_usuario;
$email = $usuario->email_usuario;
$pass = $usuario->pass_usuario;
$tipo = $usuario->tipo_usuario;
$tipos = $usuario->getSQLEnumArray('usuarios', 'tipo_usuario'); //los tipos de usuarios para el select se van a coger de los permitidos en el enum definido en la base de datos. No voy a usar los valores que ya hay, porque cuando solo tengo definido mi admin no tengo usuarios de tipo colaborador o usuario para coger ese valor y construir mi select.

?>

<div class="container my-5">

    <div class="row ">
        <div class="card d-none d-lg-block col-lg-3 bg-light">
            <div class="card-body">
                <h5 class="card-title text-center text-success">Datos del nuevo usuario</h5>
            </div>
            <img class="card-img-bottom" src="img/lateral_formulario.png" alt="formulario">
        </div>
        <div class="card card-body col-lg-9 col-xl-8">
            <form action="index.php?p=gu" method="POST" enctype="multipart/form-data" name="formModiusuario" id="formModiusuario">
    <!-- EL formulario redirige a la gestión de usuarios, tanto cuando se modifica como cuando se cancela -->
                <input type="hidden" name="id_usuario" maxlength="10" size="40" <?php if (isset($id)) {
                                                                                    echo "value='$id'";
                                                                                } ?>>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_usuario" maxlength="30" required <?php if (isset($nombre)) {
                                                                                                                                echo "value='$nombre'";
                                                                                                                            } ?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">E-mail</label>
                    <div class="col-md-10">
                        <input type="email" class="form-control rounded-pill" name="email_usuario" maxlength="40" required <?php if (isset($email)) {
                                                                                                                                echo "value='$email'";
                                                                                                                            } ?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Contraseña:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="pass_usuario" minsize="6" maxlength="16" required <?php if (isset($pass)) {
                                                                                                                                echo "value='$pass'";
                                                                                                                            } ?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo:</label>
                    <div class="col-6 col-sm-6 col-lg-5">
                        <select class="form-control rounded-pill" name="tipo_usuario" id="tipo_usuario">
                            <?php
                            foreach ($tipos as $valor) {
                                echo "<option value=\"$valor\" ";
                                if ($tipo == $valor) echo 'selected="selected"';
                                echo ">$valor</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                        <input type="submit" class="form-control rounded-pill bg-success text-white" value="Modificar Usuario" name="modifUser">
                    </div>
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                            <!-- <input type="submit" class="form-control rounded-pill bg-success text-white" value="Cancelar" name="cancelar"> -->
                            <button class="form-control rounded-pill btn btn-success"><a href="index.php?p=gu" class="text-decoration-none text-white">Cancelar</a></button>
                    </div>
                </div>
            </form>
        </div> <!-- fin contenedor del formulario -->
    </div> <!-- fin row -->
</div> <!-- fin container -->