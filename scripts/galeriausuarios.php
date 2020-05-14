<?php

/**
 * Lógica de la página
 */
//var_dump($_POST);
$imagen = new Imagen();

if (isset($_SESSION['id_usuario'])) :
    if (isset($tipoS)) {
        //solo puede acceder a la vista los usuarios registrados de cualquier tipo. Bloqueo accesos por url
        $imagen->getFromUser($id_usuarioS);  //envío la id del usuario, que he recogido de $SESSION

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
             */ ?>
            <div class="container my-5">
                <h1 class="text-success text-center dekko">Tu galería de imágenes</h1>
                <form action="index.php?p=glu" method="post" enctype="multipart/form-data" class="pt-5">
                    <div class="form-row align-items-end">
                        <?php foreach ($imagenes as $foto) : ?>
                            <div class="form-group col-md-6 col-lg-4">
                                <div class="card h-100">
                                    <a href="<?= $foto['enlace_imagen']; ?>" class="text-center px-3">
                                        <img class="card-img-top fit-cover recortada-1 mt-3 border border-success rounded-lg" src="<?= $foto['enlace_imagen']; ?>" alt="Imagen de <?= obtenerNombreCi($foto['id_imagen']); ?>" loading="lazy">
                                    </a>
                                    <div class="card-body">
                                        <div class="card-text">
                                            <span>
                                                Foto de la planta <?= obtenerNombreCi($foto['id_imagen']); ?>.<br>
                                            </span>
                                            <span><?php if (isset($tipoS) && $tipoS != "Usuario") : ?>
                                                    <input type="checkbox" name="imagenBorrar[]" value="<?= $foto['id_imagen']; ?>"> Selecciona para borrar.
                                                <?php endif; ?>
                                            </span>
                                        </div>
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

        <?php else : ?>
            <div class="form-group col-md-6 col-lg-4 mt-5 mx-auto">
                <div class="card">
                    <img class="card-img-top fit-cover" src="./img/web/sin-plantas.jpg" alt="Anímate a subir tus propias fotos a las galerías de las plantas" loading="lazy">
                    <div class="card-body">
                        <div class="card-text">
                            <p>Aún no has subido ninguna foto.</p>
                            <p>¿Te animas a escoger una planta de la <a href="index.php?p=col" class="text-decoration-none text-success font-weight-bold">colección</a> y subir tus fotos?</p>
                        </div>
                    </div>
                </div>
            </div>
<?php
            $msg = "Aún no has subido ninguna foto";
        endif; //if nº de fotos
    } else {
        echo "<script>window.location.replace(\"index.php?p=404\");</script>";
    } //fin tipos 
else :
    //si no hay sesión de usuarios redirige a 404
    echo "<script>window.location.replace(\"index.php?p=404\");</script>";
endif;
?>