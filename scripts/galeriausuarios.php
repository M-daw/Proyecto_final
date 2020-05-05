<?php
//var_dump($_POST);
if (isset($_SESSION['id_usuario'])) {
    $imagen = new Imagen();
    $imagen->getFromUser($id_usuarioS);  //envío la id del usuario, que he recogido de $SESSION

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
            <form action="index.php?p=glu" method="post" enctype="multipart/form-data" class="pt-5">
                <div class="form-row align-items-end">
                    <?php foreach ($imagenes as $foto) : ?>
                        <div class="form-group col-4">
                            <div class="card">
                                <img class="card-img-top" src="<?= $foto['enlace_imagen']; ?>" alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">Foto de la planta <?= obtenerNombreCi($foto['id_imagen']); ?>. <br>
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
        echo "Aún no has subido ninguna foto";
    }
} else {
    echo "NO DEBERÍAS ESTAR AQUÍ";
}

?>