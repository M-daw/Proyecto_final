<?php
$planta = new Planta();
$planta->get($_GET['m']); //recojo los datos de la planta a modificar para pasarlos a los inputs
$nombre_cientifico = $planta->nombre_cientifico;
$nombre_castellano = $planta->nombre_castellano;
$nombre_valenciano = $planta->nombre_valenciano;
$nombre_ingles = $planta->nombre_ingles;
$familia = $planta->familia;
$caracteres_diagnosticos = $planta->caracteres_diagnosticos;
$uso = $planta->uso;
$biotipo = $planta->biotipo;
$habitat = $planta->habitat;
$distribucion = $planta->distribucion;
$cat_UICN = $planta->cat_UICN;
$floracion = $planta->floracion;
$foto_general = $planta->foto_general;
$foto_flor = $planta->foto_flor;
$foto_hoja = $planta->foto_hoja;
$foto_fruto = $planta->foto_fruto;
$id_usuario = $planta->id_usuario;
$id_planta = $_GET['m'];
$biotipos = $planta->getSQLEnumArray('plantas', 'biotipo');  //los biotipos y categorías para los select se recogen de sus enum en la BD
$categorias = $planta->getSQLEnumArray('plantas', 'cat_UICN');


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

            <form action="index.php?p=gp" method="POST" enctype="multipart/form-data" name="formModifPlanta" class="pt-5">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre científico:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_cientifico" maxlength="100" <?php if (isset($nombre_cientifico)) {
                                                                                                                            echo "value='$nombre_cientifico'";
                                                                                                                        } ?>></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre en castellano:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_castellano" maxlength="255" <?php if (isset($nombre_castellano)) {
                                                                                                                            echo "value='$nombre_castellano'";
                                                                                                                        } ?>></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre en valenciano:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_valenciano" maxlength="255" <?php if (isset($nombre_valenciano)) {
                                                                                                                            echo "value='$nombre_valenciano'";
                                                                                                                        } ?>></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre en inglés:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_ingles" maxlength="100" <?php if (isset($nombre_ingles)) {
                                                                                                                        echo "value='$nombre_ingles'";
                                                                                                                    } ?>></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Familia:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="familia" maxlength="30" <?php if (isset($familia)) {
                                                                                                                echo "value='$familia'";
                                                                                                            } ?>></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Caracteres diagnósticos:</label>
                    <div class="col-md-10">
                        <textarea name="caracteres_diagnosticos" class="form-control" rows="8">
                        <?php if (isset($caracteres_diagnosticos)) {
                            echo $caracteres_diagnosticos;
                        } ?>
                        </textarea></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Uso:</label>
                    <div class="col-md-10">
                        <textarea name="uso" class="form-control" rows="4" cols="40">
                        <?php if (isset($uso)) {
                            echo $uso;
                        } ?>
                        </textarea></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Biotipo:</label>
                    <div class="col-6 col-sm-6 col-lg-5">
                        <select class="form-control rounded-pill" name="biotipo" id="biotipo">
                            <?php
                            foreach ($biotipos as $valor) {
                                echo "<option value=\"$valor\" ";
                                if ($biotipo == $valor) echo 'selected="selected"';
                                echo ">$valor</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Hábitat:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="habitat" maxlength="255" <?php if (isset($habitat)) {
                                                                                                                echo "value='$habitat'";
                                                                                                            } ?>></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Distribución:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="distribucion" maxlength="255" <?php if (isset($distribucion)) {
                                                                                                                        echo "value='$distribucion'";
                                                                                                                    } ?>></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Categoría UICN:</label>
                    <div class="col-6 col-sm-6 col-lg-5">
                        <select class="form-control rounded-pill" name="cat_UICN" id="cat_UICN">
                            <?php
                            foreach ($categorias as $valor) {
                                echo "<option value=\"$valor\" ";
                                if ($cat_UICN == $valor) echo 'selected="selected"';
                                echo ">$valor</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Floración:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="floracion" maxlength="255" <?php if (isset($floracion)) {
                                                                                                                    echo "value='$floracion'";
                                                                                                                } ?>>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto general:</label>
                    <div class="col-md-10">
                        <input type="file" class="" name="foto_general" maxlength="50" accept="image/gif, image/jpeg, image/png">
                        <!-- como los input tipo file no puedo pasarle datos a su value se muestra una miniatura si ya tiene una imagen subida -->
                        <img width="75px" src="<?php if (isset($foto_general)) {
                                                    echo $foto_general;
                                                } else {
                                                    echo '#';
                                                } ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto de la flor:</label>
                    <div class="col-md-10">
                        <input type="file" class="" name="foto_flor" maxlength="50" accept="image/gif, image/jpeg, image/png">
                        <img width="75px" src="<?php if (isset($foto_flor)) {
                                                    echo $foto_flor;
                                                } else {
                                                    echo '#';
                                                } ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto de la hoja:</label>
                    <div class="col-md-10">
                        <input type="file" class="" name="foto_hoja" maxlength="50" accept="image/gif, image/jpeg, image/png">
                        <img width="75px" src="<?php if (isset($foto_hoja)) {
                                                    echo $foto_hoja;
                                                } else {
                                                    echo '#';
                                                } ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto del fruto:</label>
                    <div class="col-md-10">
                        <input type="file" class="" name="foto_fruto" maxlength="50" accept="image/gif, image/jpeg, image/png">
                        <img width="75px" src="<?php if (isset($foto_fruto)) {
                                                    echo $foto_fruto;
                                                } else {
                                                    echo '#';
                                                } ?>">
                    </div>
                </div>

                <input type="hidden" name="id_usuario" value="1" maxlength="11" <?php if (isset($id_usuario)) {
                                                                                    echo "value='$id_usuario'";
                                                                                } ?>>
                <input type="hidden" name="id_planta" maxlength="11" <?php if (isset($id_planta)) {
                                                                                    echo "value='$id_planta'";
                                                                                } ?>>

                <div class="form-group row">
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                        <input type="submit" class="form-control rounded-pill bg-success text-white" value="Modificar Planta" name="modifPlanta">
                    </div>
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                        <input type="submit" class="form-control rounded-pill bg-success text-white" value="Cancelar" name="cancelar">
                    </div>
                </div>
            </form>
        </div> <!-- fin contenedor del formulario -->
    </div> <!-- fin row -->
</div> <!-- fin container -->