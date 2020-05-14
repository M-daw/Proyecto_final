<?php
$imagenes = crearArrayImagenes();
if (is_array($imagenes)) {
    #si es array es que está el archivo de configuración, y carga recoge las imágenes que se usarán en la galería. 
    #Si no es array es que es un string con el mensaje de error porque falta el archivo de configuración. Lo capturo y muestro en el else
?>

    <div class="d-flex justify-content-center align-items-center cont-pajaros">
        <h1 class="mb-5 mx-5 lobster display-4 font-italic text-hoja sombra-texto">Herbario Online de la Sierra de Crevillent</h1>
        <div class="pajaro-cont pajaro-cont--uno">
            <div class="pajaro pajaro--uno"></div>
        </div>
        <div class="pajaro-cont pajaro-cont--dos">
            <div class="pajaro pajaro--dos"></div>
        </div>
        <div class="pajaro-cont pajaro-cont--tres">
            <div class="pajaro pajaro--tres"></div>
        </div>
        <div class="pajaro-cont pajaro-cont--cuatro">
            <div class="pajaro pajaro--cuatro"></div>
        </div>
    </div>
    <div class="container pt-3 my-3 my-lg-5">
        <div class="row portada">
            <div class="col-md-6 order-2 d-flex justify-content-center justify-content-md-end mb-4 mb-md-0">
                <picture>
                    <img src="img/web/lino-portada.jpg" class="img-fluid border border-success rounded-lg sombra-doble" alt="Herbario Online de la Sierra de Crevillent" loading="lazy">
                </picture>
            </div>
            <div class="col-md-6 order-1">
                <h2 class="dekko">¿Qué es un Herbario Online?</h2>
                <p class="text-justify">
                    Antes de definir qué es un <a href="https://es.wikipedia.org/wiki/Herbario_virtual" class="text-decoration-none text-success font-weight-bold">herbario online</a> deberíamos concretar que es un herbario. <br>
                    Un herbario es una colección de plantas o partes de plantas debidamente identificadas, y que contiene información sobre las mismas, como la identidad del recolector, fecha y lugar de recolección, hábitat, nombre común, o usos de la planta.<br>
                    Estas colecciones pueden representar la flora mundial, de un país, de una región, o incluso de una localidad. Además, pueden representar un grupo específico, como por ejemplo, plantas medicinales, plantas cultivadas, plantas acuáticas, plantas que crecen en condiciones estremas de temperatura, o una familia específica. <br>
                    Tradicionalmente, las plantas se prensaban, secaban y conservaban en pliegos de papel. <br>
                    En un herbario online, también conocido como herbario virtual o herbario digital, se utilizan imágenes de las plantas, presentadas en una página web.
                </p>
            </div>

            <div class="col-lg-6 order-3">
                <h2 class="dekko">¿Qué voy a encontrar en este Herbario Online?</h2>
                <p class="text-justify">En este herbario podrás encontrar plantas vasculares encontradas en Crevillent, Alicante. <br>
                    El Herbario Online se ha estructurado en fichas, o páginas propias para cada especie vegetal presente en el herbario. Cada ficha consta de imágenes de las plantas (porte general, flor, hoja y fruto), e información sobre las características diagnósticas de la planta, además de su nombre científico, en castellano, catalán e inglés, y otros datos como distribución, hábitat o su estado de conservacion.
                </p>
            </div>

        </div> <!-- fin row -->
    </div> <!-- fin container -->
    <div class="row mt-3 mt-md-5">
        <div id="galeria-principal" class="swiper-container col-12 py-3 py-lg-5">
            <div class="swiper-wrapper">
                <?php foreach ($imagenes as $foto) : ?>
                    <picture class="swiper-slide recortada-2">
                        <img src="<?= $foto; ?>" alt="Imagen de la galería de usuarios" class="fit-cover recortada-2" loading="lazy">
                    </picture>
                <?php endforeach; ?>
            </div>
            <!-- Paginación -->
            <div class="swiper-pagination"></div>
        </div>
    </div> <!-- fin row -->
<?php
} else {
    $error = $imagenes;
}
?>