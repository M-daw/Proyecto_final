<?php
/* $nombre_cientifico = "";
$nombre_castellano = "";
$nombre_valenciano = "";
$nombre_ingles = "";
$familia = "";
$caracteres_diagnosticos = "";
$uso = "";
$biotipo = "";
$habitat = "";
$distribucion = "";
$cat_UICN = "";
$floracion = "";
$foto_general = "";
$foto_flor = "";
$foto_hoja = "";
$foto_fruto = "";
$id_usuario = "";*/
$aux = new Planta();
$biotipos = $aux->getSQLEnumArray('plantas', 'biotipo');
$categorias = $aux->getSQLEnumArray('plantas', 'cat_UICN');
/*if (isset($_POST['altaPlanta'])) {
    $nombre_cientifico = $_POST['nombre_cientifico'];
    $nombre_castellano = $_POST['nombre_castellano'];
    $nombre_valenciano = $_POST['nombre_valenciano'];
    $nombre_ingles = $_POST['nombre_ingles'];
    $familia = $_POST['familia'];
    $caracteres_diagnosticos = $_POST['caracteres_diagnosticos'];
    $uso = $_POST['uso'];
    $biotipo = $_POST['biotipo'];
    $habitat = $_POST['habitat'];
    $distribucion = $_POST['distribucion'];
    $cat_UICN = $_POST['cat_UICN'];
    $floracion = $_POST['floracion'];
    $foto_general = subirImagen('foto_general');
    $foto_flor = subirImagen('foto_flor');
    $foto_hoja = subirImagen('foto_hoja');
    $foto_fruto = subirImagen('foto_fruto');
    $id_usuario = $_POST['id_usuario'];
    $planta = new Planta();
    //$planta->set($_POST); //no puedo usar $_POST porque las imágenes están en $_FILES
    $datos = array('nombre_cientifico' => $nombre_cientifico, 'nombre_castellano' => $nombre_castellano, 'nombre_valenciano' => $nombre_valenciano, 'nombre_ingles' => $nombre_ingles, 'familia' => $familia, 'caracteres_diagnosticos' => $caracteres_diagnosticos, 'uso' => $uso, 'biotipo' => $biotipo, 'habitat' => $habitat, 'distribucion' => $distribucion, 'cat_UICN' => $cat_UICN, 'floracion' => $floracion, 'foto_general' => $foto_general, 'foto_flor' => $foto_flor, 'foto_hoja' => $foto_hoja, 'foto_fruto' => $foto_fruto, 'id_usuario' => $id_usuario);
    $planta->set($datos);
    $error = $planta->error;
    $msg = $planta->msg;
} */

?>
<div class="container my-5">
    <div class="row ">
        <div class="card d-none d-lg-block col-lg-3 bg-light">
            <div class="card-body">
                <h5 class="card-title text-center text-success">Datos de la planta</h5>
            </div>
            <img class="card-img-bottom" src="img/lateral_formulario.png" alt="formulario">
        </div>
        <div class="card card-body col-lg-9 col-xl-8">

            <form action="index.php?p=gp" method="POST" enctype="multipart/form-data" name="formAltaPlanta" class="pt-5">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre científico:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_cientifico" maxlength="100" required></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre en castellano:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_castellano" maxlength="255"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre en valenciano:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_valenciano" maxlength="255"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre en inglés:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_ingles" maxlength="100"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Familia:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="familia" maxlength="30" required></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Caracteres diagnósticos:</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="caracteres_diagnosticos" rows="4" required></textarea></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Uso:</label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="uso" rows="4"></textarea></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Biotipo:</label>
                    <div class="col-6 col-sm-6 col-lg-5">
                        <select name="biotipo" class="form-control rounded-pill">
                            <?php foreach ($biotipos as $valor) : ?>
                                <option value="<?= $valor; ?>"><?= $valor; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Hábitat:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="habitat" maxlength="255"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Distribución:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="distribucion" maxlength="255"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Categoría UICN:</label>
                    <div class="col-6 col-sm-6 col-lg-5">
                        <select class="form-control rounded-pill" name="cat_UICN">
                            <?php foreach ($categorias as $valor) : ?>
                                <option value="<?= $valor; ?>"><?= $valor; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Floración:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="floracion" maxlength="255">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto general:</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control-file" name="foto_general" maxlength="50" accept="image/gif, image/jpeg, image/png">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto de la flor:</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control-file" name="foto_flor" maxlength="50" accept="image/gif, image/jpeg, image/png">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto de la hoja:</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control-file" name="foto_hoja" maxlength="50" accept="image/gif, image/jpeg, image/png">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto del fruto:</label>
                    <div class="col-md-10">
                        <input type="file" class="form-control-file" name="foto_fruto" maxlength="50" accept="image/gif, image/jpeg, image/png">
                    </div>
                </div>

                <input type="hidden" name="id_usuario" value="<?= $id_usuarioS; ?>" maxlength="11">

                <div class="form-group row">
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                        <input type="submit" class="form-control rounded-pill bg-success text-white" value="Alta Planta" name="altaPlanta">
                    </div>
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                        <!-- <input type="submit" class="form-control rounded-pill bg-success text-white" name="cancelar" value="Cancelar" id="cancelarPlanta"> --> <!-- para usar esta opción tengo que refirigir con JS -->
                        <button class="form-control rounded-pill btn btn-success"><a href="index.php?p=gp" class="text-decoration-none text-white">Cancelar</a></button>
                    </div>
                </div>
            </form>
        </div> <!-- fin contenedor del formulario -->
    </div> <!-- fin row -->
</div> <!-- fin container -->