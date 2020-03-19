<?php
$nombre_cientifico = "";
$nombre_castellano = "";
$nombre_valenciano = "";
$nombre_ingles = "";
$familia = "";
$caracteres_diagnosticos = "";
$uso = "";
$biotipo = "";
$habitat = "";
$distribucion = "";
$cat_UICN = "";
$floracion = "";
$foto_general = "";
$foto_flor = "";
$foto_hoja = "";
$foto_fruto = "";
$id_usuario = "";
if (isset($_POST['altaPlanta'])) {



    /*     if (isset($_FILES)) {
        // Control de que el _FILES[] exista
        $destino="./img/";
        foreach ($_FILES as $_FILES[]) {

            $archivo = $destino . $_FILES[]['name'];
            if (is_file($destino .  $_FILES[]['name'])) {
                $archivo = $destino . time() .  $_FILES[]['name'];
            }
            //control del tipo de _FILES[]
            $tiposValidos = array("image/gif", "image/jpeg", "image/png");
            if (in_array( $_FILES[]["type"], $tiposValidos)) {
                //controla el tamaño del _FILES[]
                if ( $_FILES[]["size"] <= TAM_MAX__FILES[]) {
                    if (is_uploaded_file( $_FILES[]['tmp_name']))
                        move_uploaded_file( $_FILES[]['tmp_name'], $archivo);
                } else {
                    echo "No puedes subir _FILES[]s mayores de " . TAM_MAX__FILES[];
                }
            } else {
                echo "El _FILES[] tiene un tipo no valido";
            }
        }//fin foreach
    }//fin isset */

    $nombre_cientifico = $_POST['nombre_cientifico'];
    $nombre_castellano = $_POST['nombre_castellano'];
    $nombre_valenciano = $_POST['nombre_valenciano'];
    $nombre_ingles = $_POST['nombre_ingles'];
    $familia = $_POST['familia'];
    $caracteres_diagnosticos = $_POST['caracteres_diagnosticos'];
    $uso = $_POST['uso'];
    $biotipo = $_POST['biotipo'];
    $habitat = $_POST['habitat'];
    $distribucion = $_POST['distribucion'];
    $cat_UICN = $_POST['cat_UICN'];
    $floracion = $_POST['floracion'];
    $foto_general = subirImagen('foto_general');
    $foto_flor = subirImagen('foto_flor');
    $foto_hoja =subirImagen('foto_hoja');
    $foto_fruto =subirImagen('foto_fruto');
    $id_usuario = $_POST['id_usuario'];
    $planta = new Planta();
    //$planta->set($_POST); //no puedo usar $_POST porque las imágenes están en $_FILES
    $datos = array('nombre_cientifico' => $nombre_cientifico, 'nombre_castellano' => $nombre_castellano, 'nombre_valenciano' => $nombre_valenciano, 'nombre_ingles' => $nombre_ingles, 'familia' => $familia, 'caracteres_diagnosticos' => $caracteres_diagnosticos, 'uso' => $uso, 'biotipo' => $biotipo, 'habitat' => $habitat, 'distribucion' => $distribucion, 'cat_UICN' => $cat_UICN, 'floracion' => $floracion, 'foto_general' => $foto_general, 'foto_flor' => $foto_flor, 'foto_hoja' => $foto_hoja, 'foto_fruto' => $foto_fruto, 'id_usuario' => $id_usuario);
    $planta->set($datos);
    $error = $planta->error;
    $msg = $planta->msg;
}


//repasar el id_usuario! ahora es 1, pero tiene que ser el id del usuario logueado
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

            <form action="index.php?p=ap" method="POST" enctype="multipart/form-data" name="formAltaPlanta" class="pt-5">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre científico:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_cientifico" maxlength="100"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre en castellano:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_castellano" maxlength="255"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre en valenciano:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_valenciano" maxlength="255"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Nombre en inglés:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="nombre_ingles" maxlength="100"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Familia:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="familia" maxlength="30"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Caracteres diagnósticos:</label>
                    <div class="col-md-10">
                        <textarea name="caracteres_diagnosticos" class="form-control" rows="4" cols="40"></textarea></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Uso:</label>
                    <div class="col-md-10">
                        <textarea name="uso" class="form-control" rows="4" cols="40"></textarea></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Biotipo:</label>
                    <div class="col-6 col-sm-6 col-lg-5">
                        <select class="form-control rounded-pill" name="biotipo" id="biotipo">
                            <option value="terófito">Terófito</option>
                            <option value="hemicriptófito">Hemicriptófito</option>
                            <option value="geófito">Geófito</option>
                            <option value="caméfito">Caméfito</option>
                            <option value="fanerófito">Fanerófito</option>
                            <option value="hidrófito">Hidrófito</option>
                        </select></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Hábitat:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="habitat" maxlength="255"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Distribución:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="distribucion" maxlength="255"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Categoría UICN:</label>
                    <div class="col-6 col-sm-6 col-lg-5">
                        <select class="form-control rounded-pill" name="cat_UICN" id="cat_UICN">
                            <option value="LC">LC Preocupación menor</option>
                            <option value="NT">NT Casi amenazada</option>
                            <option value="VU">VU Vulnerable</option>
                            <option value="EN">EN En peligro</option>
                            <option value="CR">CR EN peligro crítico</option>
                            <option value="EW">EW Extinta en estado silvestre</option>
                            <option value="EX">EX Extinta</option>
                        </select></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Floración:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control rounded-pill" name="floracion" maxlength="255"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto general:</label>
                    <div class="col-md-10">
                        <input type="file" class="" name="foto_general" maxlength="50" accept="image/gif, image/jpeg, image/png"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto de la flor:</label>
                    <div class="col-md-10">
                        <input type="file" class="" name="foto_flor" maxlength="50" accept="image/gif, image/jpeg, image/png"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto de la hoja:</label>
                    <div class="col-md-10">
                        <input type="file" class="" name="foto_hoja" maxlength="50" accept="image/gif, image/jpeg, image/png"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label"> Foto del fruto:</label>
                    <div class="col-md-10">
                        <input type="file" class="" name="foto_fruto" maxlength="50" accept="image/gif, image/jpeg, image/png"></div>
                </div>

                <input type="hidden" name="id_usuario" value="1" maxlength="11">

                <div class="form-group row">
                    <div class="col-6 col-sm-4 col-lg-3 col-form-label">
                        <input type="submit" class="form-control rounded-pill bg-success text-white" value="Alta Planta" name="altaPlanta">
                    </div>
                </div>

            </form>
        </div>
    </div> <!-- fin row -->
</div> <!-- fin container -->