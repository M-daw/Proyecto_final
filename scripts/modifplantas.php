<?php

/**
 * Lógica de la página
 */

if (isset($tipoS) && ($tipoS == "Administrador" || $tipoS == "Colaborador")) {
    //solo puede acceder a la vista si es administrador o colaborador. Bloqueo accesos por url
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
    $id_planta =$planta->id_planta;
    $biotipos = $planta->getSQLEnumArray('plantas', 'biotipo');  //los biotipos y categorías para los select se recogen de sus enum en la BD
    $categorias = $planta->getSQLEnumArray('plantas', 'cat_UICN');
    $aux = new Planta(); //nueva planta para que no se unan estos resultados a los rows de la planta que se va a modificar
    $aux->getFamilias();
    $familias = $aux->get_rows();

    /**
     * Vista de la página
     */
?>
    <div class="container my-5">
        <h1 class="text-success text-center dekko">Modificación de plantas</h1>
        <div class="row ">
            <div class="card d-none d-lg-block col-lg-3 bg-light">
                <div class="card-body">
                    <h5 class="card-title text-center text-success">Datos de la planta</h5>
                </div>
                <img class="card-img-bottom" src="img/web/lateral-formulario.png" alt="imagen con flores para decorar el formulario" loading="lazy">
            </div>
            <div class="card card-body col-lg-9 col-xl-8">

                <form class="pt-5" action="index.php?p=gp" method="POST" enctype="multipart/form-data" name="formModifPlanta">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Nombre científico:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill" name="nombre_cientifico" value="<?php if (isset($nombre_cientifico)) :
                                                                                                                        echo $nombre_cientifico;
                                                                                                                    endif; ?>" maxlength="100" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nombre en castellano:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoNombre" name="nombre_castellano" value="<?php if (isset($nombre_castellano)) :
                                                                                                                                    echo $nombre_castellano;
                                                                                                                                endif; ?>" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nombre en valenciano:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoNombre" name="nombre_valenciano" value="<?php if (isset($nombre_valenciano)) :
                                                                                                                                    echo $nombre_valenciano;
                                                                                                                                endif; ?>" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nombre en inglés:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoNombre" name="nombre_ingles" value="<?php if (isset($nombre_ingles)) :
                                                                                                                                echo $nombre_ingles;
                                                                                                                            endif; ?>" maxlength="100">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Familia:</label>
                        <div class="col-md-10">
                            <input type="text" list="familia" class="form-control rounded-pill" name="familia" value="<?php if (isset($familia)) :
                                                                                                                            echo $familia;
                                                                                                                        else :
                                                                                                                            echo "";
                                                                                                                        endif; ?>" maxlength="30" required>
                            <datalist id="familia">
                                <?php
                                foreach ($familias as $fam) :
                                    foreach ($fam as $key => $valor) : ?>
                                        <option value="<?= $valor; ?>"><?= $valor; ?></option>
                                <?php endforeach;
                                endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"><span class="text-danger">*</span>Caracteres diagnósticos:</label>
                        <div class="col-md-10">
                            <textarea name="caracteres_diagnosticos" class="form-control esCampoTexto" rows="8" maxlength="800" required><?php if (isset($caracteres_diagnosticos)) :
                                                                                                                                                echo $caracteres_diagnosticos;
                                                                                                                                            endif; ?></textarea>
                            <span class="small caracteresRestantes"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Uso:</label>
                        <div class="col-md-10">
                            <textarea name="uso" class="form-control esCampoTexto" rows="4" maxlength="300"><?php if (isset($uso)) :
                                                                                                                echo $uso;
                                                                                                            else :
                                                                                                                echo "";
                                                                                                            endif; ?></textarea>
                            <span class="small caracteresRestantes"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Biotipo:</label>
                        <div class="col-6 col-sm-6 col-lg-5">
                            <select class="form-control rounded-pill" name="biotipo" id="biotipo">
                                <?php foreach ($biotipos as $valor) : ?>
                                    <option value="<?= $valor; ?>" <?php if ($biotipo == $valor) echo "selected" ?>>
                                        <?= $valor; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Hábitat:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoTexto" name="habitat" value="<?php if (isset($habitat)) :
                                                                                                                        echo $habitat;
                                                                                                                    endif; ?>" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Distribución:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoTexto" name="distribucion" value="<?php if (isset($distribucion)) :
                                                                                                                                echo $distribucion;
                                                                                                                            endif ?>" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Categoría UICN:</label>
                        <div class="col-6 col-sm-6 col-lg-5">
                            <select class="form-control rounded-pill" name="cat_UICN" id="cat_UICN">
                                <?php foreach ($categorias as $valor) : ?>
                                    <option value="<?= $valor; ?>" <?php if ($cat_UICN == $valor) :
                                                                        echo "selected";
                                                                    endif; ?>>
                                        <?= $valor; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Floración:</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control rounded-pill esCampoTexto" name="floracion" value="<?php if (isset($floracion)) :
                                                                                                                            echo $floracion;
                                                                                                                        endif; ?>" maxlength="255">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto general:</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="foto_general" maxlength="50" accept="image/gif, image/jpeg, image/png">
                            <!-- como los input tipo file no puedo pasarle datos a su value se muestra una miniatura si ya tiene una imagen subida -->
                            <div class="mt-2">
                            <?php if ($foto_general != "") : ?>
                                <img class="miniatura fit-cover" src="<?php if (isset($foto_general)) :
                                                            echo $foto_general;
                                                        endif; ?>" loading="lazy">
                                    <a href="javascript:void(0)" class="text-success botonBorrarFoto" data-ruta="<?= $foto_general ?>" data-tipo="foto_general" data-id="<?= $id_planta ?>">
                                        <i class="fas fa-times mr-1 ml-3"></i> Eliminar foto
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto de la flor:</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="foto_flor" maxlength="50" accept="image/gif, image/jpeg, image/png">
                            <div class="mt-2">
                            <?php if ($foto_flor != "") : ?>
                                <img class="miniatura fit-cover" src="<?php if (isset($foto_flor)) :
                                                            echo $foto_flor;
                                                        endif; ?> " loading="lazy">
                                    <a href="javascript:void(0)" class="text-success botonBorrarFoto" data-ruta="<?= $foto_flor ?>" data-tipo="foto_flor" data-id="<?= $id_planta ?>">
                                        <i class="fas fa-times mr-1 ml-3"></i> Eliminar foto
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto de la hoja:</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="foto_hoja" maxlength="50" accept="image/gif, image/jpeg, image/png">
                            <div class="mt-2">
                            <?php if ($foto_hoja != "") : ?>
                                <img class="miniatura fit-cover" src="<?php if (isset($foto_hoja)) :
                                                            echo $foto_hoja;
                                                        endif; ?>" loading="lazy">
                                    <a href="javascript:void(0)" class="text-success botonBorrarFoto" data-ruta="<?= $foto_hoja ?>" data-tipo="foto_hoja" data-id="<?= $id_planta ?>">
                                        <i class="fas fa-times mr-1 ml-3"></i>Eliminar foto
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Foto del fruto:</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control-file" name="foto_fruto" maxlength="50" accept="image/gif, image/jpeg, image/png">
                            <div class="mt-2">
                            <?php if ($foto_fruto != "") : ?>
                                <img class="miniatura fit-cover" src="<?php if (isset($foto_fruto)) :
                                                            echo $foto_fruto;
                                                        endif; ?>" loading="lazy">
                                    <a href="javascript:void(0)" class="text-success botonBorrarFoto" data-ruta="<?= $foto_fruto ?>" data-tipo="foto_fruto" data-id="<?= $id_planta ?>">
                                        <i class="fas fa-times mr-1 ml-3"></i> Eliminar foto
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id_usuario" value="<?php if (isset($id_usuario)) :
                                                                        echo $id_usuario;
                                                                    endif; ?>" maxlength="11">
                    <input type="hidden" name="id_planta" value="<?php if (isset($id_planta)) :
                                                                        echo $id_planta;
                                                                    endif; ?>" maxlength="11">

                    <div class="form-group row">
                        <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                            <input type="submit" class="form-control rounded-pill bg-success text-white" name="modifPlanta" value="Modificar Planta">
                        </div>
                        <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                            <input type="submit" class="form-control rounded-pill bg-success text-white" name="cancelar" value="Cancelar">
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