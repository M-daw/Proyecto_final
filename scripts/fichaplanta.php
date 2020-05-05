<?php
//var_dump($_FILES);
//var_dump($_POST);
$id = "";
if (isset($_GET['f'])) {
    $id = $_GET['f'];
} else {
    echo "NOOOO"; //REPASAR ESTO f siempre va a estar. Mejor comprobar que la id de planta existe
}

$planta = new Planta();
$planta->get($id);
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
        $error = "No se ha podido subir la imagen";
    }
}

$imagen = new Imagen();
$imagen->getFromPlant($id);  //envío la id de la planta, que he recogido de la URL
$relleno = [
    "./img/slider1.jpg", "./img/slider2.jpg", "./img/slider3.jpg", "./img/slider4.jpg", "./img/slider5.jpg"
];


if (count($imagen->get_rows()) > 0) {
    $datos = $imagen->get_rows();
    foreach ($datos as $fila) {
        foreach ($fila as $indice => $valor) {
            if ($indice == "enlace_imagen") {
                $imagenes[] = $valor;
            }
        }
    }
    while (count($imagenes) < 5) {  //relleno con las imágenes modelo si no hay al menos 5 imágenes en la galería de usuarios de esa planta
        $imagenes[] = $relleno[count($imagenes)];
    }
} else {
    $imagenes = $relleno;
}

?>

<div class="container-fluid pt-3">
    <div class="container my-5" id="ficha">
        <h1><?= $nombre_cientifico; ?></h1>
        <div class="row">
            <div id="mostrar_datos" class="col-lg-6">
                <p>Nombre en castellano: <?= $nombre_castellano; ?> </p>
                <p>Nombre en valenciano: <?= $nombre_valenciano; ?> </p>
                <p>Nombre en inglés: <?= $nombre_ingles; ?> </p>
                <p>Familia: <?= $familia; ?> </p>
                <p>Caracteres Diagnósticos: <?= $caracteres_diagnosticos; ?> </p>
                <p>Uso: <?= $uso; ?> </p>
                <p>Biotipo: <?= $biotipo; ?> </p>
                <p>Hábitat: <?= $habitat; ?> </p>
                <p>Distribución: <?= $distribucion; ?> </p>
                <p>Categoría UICN: <?= $cat_UICN; ?> </p>
                <p>Floración: <?= $floracion; ?> </p>
            </div>

            <div class="col-lg-6" id="mostrar_imagenes">
                <div class="swiper-container gallery-top" id="galeria-planta">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide border border-success rounded-lg d-flex justify-content-center align-items-end" style="background-image:url(
                            <?php if ($foto_general != '') :
                                echo $foto_general;
                            else :
                                echo 'img/plantas/planta_default.jpg';
                            endif; ?>);">
                            <span class="bg-light">Vista general</span>
                        </div>
                        <div class="swiper-slide border border-success rounded-lg d-flex justify-content-center align-items-end" style="background-image:url(
                            <?php if ($foto_flor != '') :
                                echo $foto_flor;
                            else :
                                echo 'img/plantas/flor_default.jpg';
                            endif; ?>);">
                            <span class="bg-light">Vista de la flor</span>
                        </div>
                        <div class="swiper-slide border border-success rounded-lg d-flex justify-content-center align-items-end" style="background-image:url(
                            <?php if ($foto_hoja != '') :
                                echo $foto_hoja;
                            else :
                                echo 'img/plantas/hoja_default.png';
                            endif; ?>);">
                            <span class="bg-light">Vista de la hoja</span>
                        </div>
                        <div class="swiper-slide border border-success rounded-lg d-flex justify-content-center align-items-end" style="background-image:url(
                            <?php if ($foto_fruto != '') :
                                echo $foto_fruto;
                            else :
                                echo 'img/plantas/fruto_default.jpg';
                            endif; ?>);">
                            <span class="bg-light">Vista del fruto</span>
                        </div>
                    </div>

                    <!-- Flechas -->
                    <div class="swiper-button-next text-success"></div>
                    <div class="swiper-button-prev text-success"></div>
                </div>
                <!-- Miniaturas -->
                <div class="swiper-container gallery-thumbs mt-3">
                    <div class="swiper-wrapper">
                        <img class="swiper-slide" src="<?php if ($foto_general != '') :
                                                            echo $foto_general;
                                                        else :
                                                            echo 'img/plantas/planta_default.jpg';
                                                        endif; ?>" alt="imagen de <?= $nombre_cientifico; ?>">
                        <img class="swiper-slide" src="<?php if ($foto_flor != '') :
                                                            echo $foto_flor;
                                                        else :
                                                            echo 'img/plantas/flor_default.jpg';
                                                        endif; ?>" alt="imagen de la flor de <?= $nombre_cientifico; ?>">
                        <img class="swiper-slide" src="<?php if ($foto_hoja != '') :
                                                            echo $foto_hoja;
                                                        else :
                                                            echo 'img/plantas/hoja_default.png';
                                                        endif; ?>" alt="imagen de la hoja de <?= $nombre_cientifico; ?>">
                        <img class="swiper-slide" src="<?php if ($foto_fruto != '') :
                                                            echo $foto_fruto;
                                                        else :
                                                            echo 'img/plantas/fruto_default.jpg';
                                                        endif; ?>" alt="imagen del fruto de <?= $nombre_cientifico; ?>">
                    </div>
                </div>
            </div>
        </div> <!-- fin row -->
    </div> <!-- fin container ficha-->

    <div class="row">
        <div id="galeria-usuario" class="swiper-container col-12 py-5">
            <h1 class="text-center text-success pb-3">Galería de Usuarios</h1>
            <div class="swiper-wrapper">
                <?php foreach ($imagenes as $foto) : ?>
                    <div class="swiper-slide" style="background-image:url('<?= $foto; ?>')"></div>
                    <div class="swiper-slide">
                        <img src="<?= $foto; ?>" alt="">
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Flechas -->
            <div class="swiper-button-next text-success"></div>
            <div class="swiper-button-prev text-success"></div>
            <!-- Paginación -->
            <div class="swiper-pagination"></div>
        </div>
    </div> <!-- fin row -->

    <div class="container">
        <p>Esta galería contiene las fotos subidas por los usuarios.
            <?php if ($tipoS != "") :
                //si el usuario está registrado cambia el texto, y se muestra el formulario de subida de fotos. 
            ?>
                Anímate y sube tus fotos.
                <form action="index.php?p=fp&f=<?= $id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-10 mt-3">
                            <input type="file" class="form-control-file" name="planta_galeria" accept="image/gif, image/jpeg, image/png">
                        </div>
                    </div>
                    <!--<input type="submit" class="form-control rounded-pill bg-success text-white" name="modifPlanta" value="Modificar Planta">-->
                    <div class="form-group row">
                        <div class="col-6 col-sm-4 col-lg-3">
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
                <a class="text-success text-decoration-none" id="abrir" href="#">Regístrate</a> para colaborar.
            <?php endif; ?>
        </p>
    </div>
</div> <!-- fin container-fluid -->