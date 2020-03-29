<?php
$id = "";
if (isset($_GET['f'])) {
    $id = $_GET['f'];
} else {
    echo "NOOOO";
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

?>

<div class="container my-5" id="ficha">
    <h1><?= $nombre_cientifico  ?></h1>
    <div class="row ">

        <div id="mostrar_datos" class="col-lg-6">
            <p> Nombre en castellano: <?= $nombre_castellano ?> </p>
            <p>Nombre en valenciano: <?= $nombre_valenciano ?> </p>
            <p>Nombre en inglés: <?= $nombre_ingles ?> </p>
            <p>Familia: <?= $familia ?> </p>
            <p>Caracteres Diagnósticos: <?= $caracteres_diagnosticos ?> </p>
            <p>Uso: <?= $uso ?> </p>
            <p>Biotipo: <?= $biotipo ?> </p>
            <p>Hábitat: <?= $habitat ?> </p>
            <p>Distribución: <?= $distribucion ?> </p>
            <p>Categoría UICN: <?= $cat_UICN ?> </p>
            <p>Floración: <?= $floracion ?> </p>

        </div>

        <div id="mostrar_imagenes" class="col-lg-6">

            <div id="galeria-planta" class="swiper-container gallery-top">
                <div class="swiper-wrapper">
                    <div class="swiper-slide border border-success rounded-lg d-flex justify-content-center align-items-end" style="background-image:url('<?php if ($foto_general != '') echo $foto_general;
                                                                                                                                                            else echo 'img/plantas/planta_default.jpg'; ?>')">
                        <span class="bg-light">Vista general</span>
                    </div>
                    <div class="swiper-slide border border-success rounded-lg d-flex justify-content-center align-items-end" style="background-image:url('<?php if ($foto_flor != '') echo $foto_flor;
                                                                                                                                                            else echo 'img/plantas/flor_default.jpg'; ?>')">
                        <span class="bg-light">Vista de la flor</span>
                    </div>
                    <div class="swiper-slide border border-success rounded-lg d-flex justify-content-center align-items-end" style="background-image:url('<?php if ($foto_hoja != '') echo $foto_hoja;
                                                                                                                                                            else echo 'img/plantas/hoja_default.png'; ?>')">
                        <span class="bg-light">Vista de la hoja</span>
                    </div>
                    <div class="swiper-slide border border-success rounded-lg d-flex justify-content-center align-items-end" style="background-image:url('<?php if ($foto_fruto != '') echo $foto_fruto;
                                                                                                                                                            else echo 'img/plantas/fruto_default.jpg'; ?>')">
                        <span class="bg-light">Vista del fruto</span>
                    </div>
                </div>

                <!-- Flechas -->
                <div class="swiper-button-next text-success"></div>
                <div class="swiper-button-prev text-success"></div>
            </div>
            <div class="swiper-container gallery-thumbs mt-3">
                <div class="swiper-wrapper">
                    <img class="swiper-slide" src="<?php if ($foto_general != '') echo $foto_general;
                                                    else echo 'img/plantas/planta_default.jpg'; ?>">
                    <img class="swiper-slide" src="<?php if ($foto_flor != '') echo $foto_flor;
                                                    else echo 'img/plantas/flor_default.jpg'; ?>">
                    <img class="swiper-slide" src="<?php if ($foto_hoja != '') echo $foto_hoja;
                                                    else echo 'img/plantas/hoja_default.png'; ?>">
                    <img class="swiper-slide" src="<?php if ($foto_fruto != '') echo $foto_fruto;
                                                    else echo 'img/plantas/fruto_default.jpg'; ?>">
                </div>
            </div>
        </div>


    </div> <!-- fin row -->
</div> <!-- fin container -->