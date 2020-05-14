<?php

/**
 * Lógica de la página
 */
//se debe acceder desde un submit en gestionplantas.php. Si no es así devuelve a la página de error
if (isset($_POST['altaplantas'])) {
    $aux = new Planta();
    $biotipos = $aux->getSQLEnumArray('plantas', 'biotipo');
    $categorias = $aux->getSQLEnumArray('plantas', 'cat_UICN');
    $aux->getFamilias();
    $familias = $aux->get_rows();
    /* El alta de las plantas se hace en la página de gestión de plantas*/

    /**
     * Vista de la página
     */
?>
    <div class="container my-5">
        <h1 class="text-success text-center dekko">Alta de plantas</h1>
        <div class="row ">
            <div class="card d-none d-lg-block col-lg-3 bg-light">
                <div class="card-body">
                    <h5 class="card-title text-center text-success">Datos de la planta</h5>
                </div>
                <img class="card-img-bottom" src="img/web/lateral-formulario.png" alt="imagen con flores para decorar el formulario" loading="lazy">
            </div>
            <div class="card card-body col-lg-9 col-xl-8">

                <form class="pt-5" action="index.php?p=gp" method="POST" enctype="multipart/form-data" name="formAltaPlanta">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Nombre científico:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill" name="nombre_cientifico" maxlength="100" required></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nombre en castellano:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoNombre" name="nombre_castellano" maxlength="255"></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nombre en valenciano:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoNombre" name="nombre_valenciano" maxlength="255"></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nombre en inglés:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoNombre" name="nombre_ingles" maxlength="100"></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Familia:</label>
                        <div class="col-md-10">
                            <!--<input type="text" class="form-control rounded-pill" name="familia" maxlength="30" required>-->
                            <input type="text" list="familia" class="form-control rounded-pill" name="familia" maxlength="30" required>
                            <datalist id="familia">
                                <?php
                                foreach ($familias as $familia) :
                                    foreach ($familia as $key => $valor) : ?>
                                        <option value="<?= $valor; ?>"><?= $valor; ?></option>
                                <?php endforeach;
                                endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Caracteres diagnósticos:</label>
                        <div class="col-md-10">
                            <textarea class="form-control esCampoTexto" name="caracteres_diagnosticos" rows="8" maxlength="800"required></textarea>
                            <span class="small caracteresRestantes"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Uso:</label>
                        <div class="col-md-10">
                            <textarea class="form-control esCampoTexto" name="uso" rows="4" maxlength="300"></textarea>
                            <span class="small caracteresRestantes"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Biotipo:</label>
                        <div class="col-6 col-sm-6 col-lg-5">
                            <select name="biotipo" class="form-control rounded-pill">
                                <?php foreach ($biotipos as $valor) : ?>
                                    <option value="<?= $valor; ?>"><?= $valor; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Hábitat:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoTexto" name="habitat" maxlength="255"></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Distribución:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoTexto" name="distribucion" maxlength="255"></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Categoría UICN:</label>
                        <div class="col-6 col-sm-6 col-lg-5">
                            <select class="form-control rounded-pill" name="cat_UICN">
                                <?php foreach ($categorias as $valor) : ?>
                                    <option value="<?= $valor; ?>"><?= $valor; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Floración:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoTexto" name="floracion" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto general:</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="foto_general" maxlength="50" accept="image/gif, image/jpeg, image/png">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto de la flor:</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="foto_flor" maxlength="50" accept="image/gif, image/jpeg, image/png">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto de la hoja:</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="foto_hoja" maxlength="50" accept="image/gif, image/jpeg, image/png">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto del fruto:</label>
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
                            <button class="form-control rounded-pill btn btn-success"><a href="index.php?p=gp" class="text-decoration-none text-white">Cancelar</a></button>
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