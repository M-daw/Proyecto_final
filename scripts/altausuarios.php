<?php
$aux = new Usuario();  //creo usuario para poder hacer la conexión a la BD y obtener los valores del enum para tipos de usuarios
$tipos = $aux->getSQLEnumArray('usuarios', 'tipo_usuario'); //los tipos de usuarios permitidos se van a coger de los permitidos en el enum definido en la base de datos. No voy a usar los valores que ya hay, porque cuando solo tengo definido mi admin no tengo usuarios de tipo colaborador o usuario para coger ese valor y construir mi select.

/* if (isset($_POST['altaUser'])) {
    $usuario = new Usuario();
    $usuario->set($_POST);  //no hace falta recoger los inputs en variables, le puedo pasar $_POST como array de datos al método set
    //echo ("<script>location.href='index.php?p=gu'</script>");
    $error = $usuario->error;
    $msg = $usuario->msg;   
} */
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
            <!-- <form action="index.php?p=au" method="POST" enctype="multipart/form-data" name="formAltaUsuario" class="pt-5"> -->
            <!-- EL formulario redirige a esta misma página. Es necesario regirigir el botón de cancelar a gestión de usuarios con JS o quitando su submit y metiendo un enlace -->
            <form action="index.php?p=gu" method="POST" enctype="multipart/form-data" name="formAltaUsuario" id="formAltaUsuario" class="pt-5">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_usuario" maxlength="30" required>
                        <div class=""></div>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-md-2 col-form-label">E-mail:</label>
                    <div class="col-md-10">
                        <input type="email" class="form-control rounded-pill" name="email_usuario" maxlength="40" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Contraseña:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="pass_usuario" minsize="6" maxlength="16" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo:</label>
                    <div class="col-6 col-sm-6 col-lg-5">
                        <select class="form-control rounded-pill" name="tipo_usuario">
                            <?php foreach ($tipos as $valor) : ?>
                                <option value=" <?= $valor ?>"><?= $valor;  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                        <input type="submit" class="form-control btn btn-success rounded-pill" name="altaUser" value="Alta Usuario">
                        <!-- <button class="form-control rounded-pill btn btn-success" id="altaUsuario" name="altaUser" value="Alta Usuario">Alta Usuario </button> -->
                    </div>
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                        <!-- <input type="submit" class="form-control rounded-pill bg-success text-white" id="cancelarUsuario" name="cancelar" value="Cancelar"> -->
                        <!-- para usar esta opción tengo que refirigir con JS -->
                        <button class="form-control rounded-pill btn btn-success"><a href="index.php?p=gu" class="text-decoration-none text-white">Cancelar</a></button>
                    </div>
                </div>
            </form>
        </div> <!-- fin contenedor del formulario -->
    </div> <!-- fin row -->
</div> <!-- fin container -->