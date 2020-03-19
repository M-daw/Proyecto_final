<?php
$nombre = "";
$email = "";
$pass = "";
$tipo = "";
if (isset($_POST['altaUser'])) {
    $nombre = $_POST['nombre_usuario'];
    $email = $_POST['email_usuario'];
    $pass = $_POST['pass_usuario'];
    $tipo = $_POST['tipo_usuario'];
    $usuario = new Usuario();
    $usuario->set($_POST);
    $error = $usuario->error;
    $msg = $usuario->msg;
}

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
            <form action="index.php?p=au" method="POST" enctype="multipart/form-data" name="formAltaUsuario" class="pt-5">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_usuario" maxlength="30">
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-md-2 col-form-label">E-mail:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="email_usuario" maxlength="30">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Contraseña:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="pass_usuario" maxlength="30">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo:</label>
                    <div class="col-6 col-sm-6 col-lg-5">
                        <select class="form-control rounded-pill" name="tipo_usuario" id="tipo_usuario">
                            <option value="usr">Usuario</option>
                            <option value="col">Colaborador</option>
                            <option value="adm">Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                        <input type="submit" class="form-control rounded-pill bg-success text-white" value="Alta Usuario" name="altaUser">
                    </div>
                </div>


            </form>
        </div>
    </div> <!-- fin row -->
</div> <!-- fin container -->