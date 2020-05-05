<?php
//var_dump($_POST);
if (isset($_POST['deleteImagenes'])) {
    $id_planta = $_POST['id_planta'];
    $imagen = new Imagen();
    $imagen->getFromPlant($id_planta);  //envío la id de la planta, que he recogido de $POST

    if (count($imagen->get_rows()) > 0) {
        $datos = $imagen->get_rows();
        foreach ($datos as $fila) {
            foreach ($fila as $indice => $valor) {
                if ($indice == "enlace_imagen") {
                    $imagenes[] = $fila;
                }
            }
        }
        //var_dump($imagenes);
?>
        <div class="container my-5">
            <form action="index.php?p=bi" method="post" enctype="multipart/form-data" class="pt-5" id="formBorradoGalerias">
                <div class="form-row align-items-end">
                    <?php foreach ($imagenes as $foto) : ?>
                        <div class="form-group col-4">
                            <div class="card">
                                <img class="card-img-top" src="<?= $foto['enlace_imagen']; ?>" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">Foto del usuario <?= obtenerAutor($foto['id_imagen']); ?>. <br>
                                        <?php if (isset($tipoS) && $tipoS != "Usuario") : ?>
                                            <input type="checkbox" name="imagenBorrar[]" value="<?= $foto['id_imagen']; ?>"> Selecciona para borrar.
                                        <?php endif; ?>
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
    } else {
        echo "Los usuarios aún no han subido fotos a la galería de esta planta";
    }
}

?>