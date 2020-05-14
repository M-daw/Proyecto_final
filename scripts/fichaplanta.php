<?php
//var_dump($_POST);
/**
 * Lógica de la página
 */
//var_dump($_FILES);

$id = "";
if (isset($_GET['f'])) {
    $id = $_GET['f'];
}
$planta = new Planta();
#capturo el mensaje que devuelve si no hay archivo de configuración. Si no hay error, continuo
$error = $planta->error;
//si hay archivo de configuración continuo. No hay un else, porque el mensaje de error se muestra en index.php, después de las páginas
if ($error === "") :
    $planta->get($id);

    //si se intenta acceder a una ficha de planta por URL sin poner una id real redirecciona a la página de error
    if (!isset($id) || $id == "" || $planta->id_planta == "") {
        echo "<script>window.location.replace(\"index.php?p=404\");</script>";
    }

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

    if (isset($_POST['addImagen'])) {
        $imagen = new Imagen();
        $id_planta = $id;
        $id_usuario = $id_usuarioS;
        $enlace_imagen = subirImagen('planta_galeria', 'galeria');

        if ($enlace_imagen != "") { //si no ha fallado la subida de imagen la guardo en la base de datos
            $datos = array('id_planta' => $id_planta, 'id_usuario' => $id_usuario, 'enlace_imagen' => $enlace_imagen);
            $imagen->set($datos);
            $error = $imagen->error;
            $msg = $imagen->msg;
        } else {
            $error = "No se ha podido subir la imagen. Compueba el tamaño";
        }
    }

    $imagenes = crearArrayImagenes($id);

    /**
     * Vista de la página
     */
?>
    <div class="container my-5">
        <div class="container" id="ficha">
            <h1 class="mb-3 mb-lg-5 mt-3 pt-4 pt-md-0 font-italic"><?= $nombre_cientifico; ?></h1>
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <span class="font-weight-bold d-block d-md-inline">Nombre en castellano: </span><?= $nombre_castellano; ?>
                    </div>
                    <div class="mb-3"><span class="font-weight-bold d-block d-md-inline">Nombre en valenciano: </span><?= $nombre_valenciano; ?> </div>
                    <div class="mb-3"><span class="font-weight-bold d-block d-md-inline">Nombre en inglés: </span><?= $nombre_ingles; ?> </div>
                    <div class="mb-3"><span class="font-weight-bold d-block d-md-inline">Familia: </span><?= $familia; ?> </div>
                    <div class="mb-3"><span class="font-weight-bold d-block d-md-inline">Caracteres Diagnósticos: </span><?= $caracteres_diagnosticos; ?> </div>
                </div><!-- fin columna 1 -->

                <div class="col-lg-6 order-3 order-lg-2">
                    <div id="titulosGaleria" class="text-center text-success"></div>
                    <div class="swiper-container gallery-top" id="galeria-planta">
                        <div class="swiper-wrapper">
                            <img id="imagenGeneral" src="<?php if ($foto_general != '') :
                                                                echo $foto_general;
                                                            else :
                                                                echo 'img/plantas/default/planta-default.jpg';
                                                            endif; ?>" class="swiper-slide border border-success rounded-lg fit-cover" alt="imagen de <?= $nombre_cientifico; ?>" loading="lazy">
                            <img id="imagenFlor" src="<?php if ($foto_flor != '') :
                                                            echo $foto_flor;
                                                        else :
                                                            echo 'img/plantas/default/flor-default.jpg';
                                                        endif; ?>" class="swiper-slide border border-success rounded-lg fit-cover" alt="imagen de la flor de <?= $nombre_cientifico; ?>" loading="lazy">
                            <img id="imagenHoja" src="<?php if ($foto_hoja != '') :
                                                            echo $foto_hoja;
                                                        else :
                                                            echo 'img/plantas/default/hoja-default.png';
                                                        endif; ?>" class="swiper-slide border border-success rounded-lg fit-cover" alt="imagen de la hoja de <?= $nombre_cientifico; ?>" loading="lazy">
                            <img id="imagenFruto" src="<?php if ($foto_fruto != '') :
                                                            echo $foto_fruto;
                                                        else :
                                                            echo 'img/plantas/default/fruto-default.jpg';
                                                        endif; ?>" class="swiper-slide border border-success rounded-lg fit-cover" alt="imagen del fruto de <?= $nombre_cientifico; ?>" loading="lazy">
                        </div>
                        <!-- Flechas -->
                        <div class="swiper-button-next text-success"></div>
                        <div class="swiper-button-prev text-success"></div>
                    </div>
                    <!-- Miniaturas -->
                    <div class="swiper-container gallery-thumbs mt-3 mb-5">
                        <div class="swiper-wrapper">
                            <img class="swiper-slide fit-cover" src="<?php if ($foto_general != '') :
                                                                            echo $foto_general;
                                                                        else :
                                                                            echo 'img/plantas/default/planta-default.jpg';
                                                                        endif; ?>" alt="miniatura de <?= $nombre_cientifico; ?>" loading="lazy">
                            <img class="swiper-slide fit-cover" src="<?php if ($foto_flor != '') :
                                                                            echo $foto_flor;
                                                                        else :
                                                                            echo 'img/plantas/default/flor-default.jpg';
                                                                        endif; ?>" alt="miniatura de la flor de <?= $nombre_cientifico; ?>" loading="lazy">
                            <img class="swiper-slide fit-cover" src="<?php if ($foto_hoja != '') :
                                                                            echo $foto_hoja;
                                                                        else :
                                                                            echo 'img/plantas/default/hoja-default.png';
                                                                        endif; ?>" alt="miniatura de la hoja de <?= $nombre_cientifico; ?>" loading="lazy">
                            <img class="swiper-slide fit-cover" src="<?php if ($foto_fruto != '') :
                                                                            echo $foto_fruto;
                                                                        else :
                                                                            echo 'img/plantas/default/fruto-default.jpg';
                                                                        endif; ?>" alt="miniatura del fruto de <?= $nombre_cientifico; ?>" loading="lazy">
                        </div>
                    </div>


                </div> <!-- fin columna dos -->
                <div class="col-12 order-2 order-lg-3">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="mb-3"><span class="font-weight-bold d-block d-md-inline">Uso: </span><?= $uso; ?> </p>
                            <p class="mb-3"><span class="font-weight-bold d-block d-md-inline">Biotipo: </span><?= $biotipo; ?> </p>
                            <p class="mb-3"><span class="font-weight-bold d-block d-md-inline">Hábitat: </span><?= $habitat; ?> </p>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3"><span class="font-weight-bold d-block d-md-inline">Distribución: </span><?= $distribucion; ?> </div>
                            <div class="mb-3"><span class="font-weight-bold d-block d-md-inline">Categoría UICN: </span><?= $cat_UICN; ?> </div>
                            <div class="mb-3"><span class="font-weight-bold d-block d-md-inline">Floración: </span><?= $floracion; ?> </div>
                        </div>
                    </div>
                </div><!-- fin columna tres -->
            </div> <!-- fin row general -->
        </div> <!-- fin container ficha-->
    </div> <!-- fin container-fluid -->
    <div class="row">
        <div id="galeria-usuario" class="swiper-container col-12 pt-3 mt-4 pb-5 mb-5">
            <h2 class="text-success text-center my-3 dekko">Galería de Usuarios</h2>
            <div class="swiper-wrapper">
                <?php foreach ($imagenes as $foto) : ?>
                    <picture class="swiper-slide recortada-2">
                        <a href="<?= $foto; ?>">
                            <img src="<?= $foto; ?>" alt="Imagen de la galería de usuarios de <?= $nombre_cientifico; ?>" class="fit-cover recortada-2" loading="lazy">
                        </a>
                    </picture>
                <?php endforeach; ?>
            </div>
            <!-- Flechas -->
            <div class="swiper-button-next text-success"></div>
            <div class="swiper-button-prev text-success"></div>
            <!-- Paginación -->
            <div class="swiper-pagination"></div>
        </div>
    </div> <!-- fin row -->

    <div class="container d-flex">
        <div class="p-3 border border-success rounded-lg mr-auto">
            <p>Esta galería contiene las fotos subidas por los usuarios.
                <?php if ($tipoS != "") :
                    //si el usuario está registrado cambia el texto, y se muestra el formulario de subida de fotos. 
                ?>
                    Anímate y sube tus fotos.</p>
            <form action="index.php?p=fp&f=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group row">
                    <div class="col-md-10">
                        <input type="file" class="form-control-file" name="planta_galeria" accept="image/gif, image/jpeg, image/png">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6 col-sm-4">
                        <input type="submit" class="form-control rounded-pill bg-success text-white" name="addImagen" value="Añadir imagen">
                    </div>
                </div>
            </form>
            <?php if ($tipoS != "Usuario") : ?>
                <p class="mt-4">Si alguna de las imágenes no debería estar aquí puedes eliminarla.</p>
                <form action="index.php?p=bi" method="POST" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-outline-success bg-light px-2" name="deleteImagenes" value="Eliminar imagenes">
                        <i class="far fa-image "></i> Eliminar Imágenes
                    </button>
                    <input type="hidden" name="id_planta" value="<?= $id; ?>">
                </form>
            <?php endif;

                else : ?>
            <a class="text-success text-decoration-none font-weight-bold" id="abrir" href="#">Regístrate</a> para colaborar.
        <?php endif; ?>
        </div>
    </div>
<?php
endif;
?>