<?php
//var_dump($_POST);
/**
 * Lógica de la página
 */
//se debe acceder desde un submit en gestionplantas.php. Si no es así devuelve a la página de error
if (isset($_POST['altausuarios'])) {
    $aux = new Usuario();  //creo usuario para poder hacer la conexión a la BD y obtener los valores del enum para tipos de usuarios
    $tipos = $aux->getSQLEnumArray('usuarios', 'tipo_usuario'); //los tipos de usuarios permitidos se van a coger de los permitidos en el enum definido en la base de datos. No voy a usar los valores que ya hay, porque cuando solo tengo definido mi admin no tengo usuarios de tipo colaborador o usuario para coger ese valor y construir mi select.
    /* el alta se hace en la página de gestión de usuarios */

    /**
     * Vista de la página
     */ ?>
    <div class="container my-5">
    <h1 class="text-success text-center dekko">Alta de usuarios</h1>
        <div class="row ">
            <div class="card d-none d-lg-block col-lg-3 bg-light">
                <div class="card-body">
                    <h5 class="card-title text-center text-success">Datos del usuario</h5>
                </div>
                <img class="card-img-bottom" src="img/web/lateral-formulario.png" alt="imagen con flores para decorar el formulario" loading="lazy">
            </div>
            <div class="card card-body col-lg-9 col-xl-8">
                <form class="pt-5" action="index.php?p=gu" method="POST" enctype="multipart/form-data" name="formAltaUsuario" id="formAltaUsuario">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Nombre:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill" name="nombre_usuario" maxlength="30" required>
                            <div class=""></div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>E-mail:</label>
                        <div class="col-md-10">
                            <input type="email" class="form-control rounded-pill" name="email_usuario" maxlength="40" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Contraseña:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill" name="pass_usuario" minsize="6" maxlength="16" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tipo:</label>
                        <div class="col-6 col-sm-6 col-lg-5">
                            <select class="form-control rounded-pill" name="tipo_usuario">
                                <?php foreach ($tipos as $valor) : ?>
                                    <option value="<?= $valor ?>"><?= $valor; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                            <input type="submit" class="form-control btn btn-success rounded-pill" name="altaUser" value="Alta Usuario">
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