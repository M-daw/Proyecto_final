<?php

/**
 * Lógica de la página
 */
//var_dump($_POST);
if (isset($_POST['deleteImagenes'])) :
    //se debe acceder desde un submit en fichaplanta.php. Si no es así devuelve a la página de error
    $id_planta = $_POST['id_planta'];
    $imagen = new Imagen();
    $imagen->getFromPlant($id_planta);  //envío la id de la planta, que he recogido de $POST
    $planta = new Planta();
    $planta->get($id_planta); //obtengo la planta para poder imprimir su nombre

    if (count($imagen->get_rows()) > 0) :
        $datos = $imagen->get_rows();
        foreach ($datos as $fila) {
            foreach ($fila as $indice => $valor) {
                if ($indice == "enlace_imagen") {
                    $imagenes[] = $fila;
                }
            }
        }
        //var_dump($imagenes);

        /**
         * Vista de la página
         */
?>
        <div class="container my-5">
            <h1 class="text-success text-center dekko">Imágenes de usuarios de <?= $planta->nombre_cientifico; ?></h1>
            <form action="index.php?p=bi" method="post" enctype="multipart/form-data" class="pt-5" id="formBorradoGalerias">
                <div class="form-row align-items-end">
                    <?php foreach ($imagenes as $foto) : ?>
                        <div class="form-group col-md-6 col-lg-4">
                            <div class="card">
                                <a href="<?= $foto['enlace_imagen']; ?>" class="text-center px-3">
                                    <img class="card-img-top fit-cover recortada-1 mt-3 border border-success rounded-lg" src="<?= $foto['enlace_imagen']; ?>" alt="Imagen de <?= obtenerNombreCi($foto['id_imagen']); ?>" loading="lazy">
                                </a>
                                <div class="card-body">
                                    <p class="card-text">
                                        <span>
                                            Foto del usuario <?= obtenerAutor($foto['id_imagen']); ?>.
                                        </span> <br>
                                        <span> <?php if (isset($tipoS) && $tipoS != "Usuario") : ?>
                                                <input type="checkbox" name="imagenBorrar[]" value="<?= $foto['id_imagen']; ?>"> Selecciona para borrar.
                                            <?php endif; ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div> <!-- fin form-row -->
                <?php if (isset($tipoS) && $tipoS != "Usuario") : ?>
                    <p>Selecciona las imagenes para borrar</p>
                    <div class="form-group row">
                        <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                            <input type="submit" class="form-control rounded-pill bg-success text-white botonBorrarFoto" name="borrarImagenes" value="Borrar Imágenes" data-tipo="galeria" data-id="<?= $id_planta ?>">
                        </div>
                    </div>
                <?php endif; ?>
            </form>
        </div>

    <?php
    else : ?>
        <div class="form-group col-md-6 col-lg-4 mt-5 mx-auto">
            <div class="card">
                <img class="card-img-top fit-cover" src="./img/web/sin-plantas.jpg" alt="Anímate a subir tus propias fotos a las galerías de las plantas" loading="lazy">
                <div class="card-body">
                    <div class="card-text">
                        <p>Los usuarios aún no han subido fotos a la galería de esta planta.</p>
                    </div>
                </div>
            </div>
        </div>
<?php
        $msg = "Los usuarios aún no han subido fotos a la galería de esta planta";
    endif;
else :
    //si no se accede de forma adecuada redirige a 404 
    echo "<script>window.location.replace(\"index.php?p=404\");</script>";
endif;
?>