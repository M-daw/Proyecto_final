<?php 
define("TAM_MAX__FILES", 700000);
function subirImagen($nombre){
        $destino = "./img/plantas/";
        if ($_FILES[$nombre]['name'] !== "") {
            $archivo = $destino . $_FILES[$nombre]['name'];
            if (is_file($destino .  $_FILES[$nombre]['name'])) {
                $archivo = $destino . time() .  $_FILES[$nombre]['name'];
            }
            //control del tipo de _FILES[]
            $tiposValidos = array("image/gif", "image/jpeg", "image/png");
            if (in_array($_FILES[$nombre]["type"], $tiposValidos)) {
                //controla el tamaño del _FILES[]
                if ($_FILES[$nombre]["size"] <= TAM_MAX__FILES) {
                    if (is_uploaded_file($_FILES[$nombre]['tmp_name']))
                        move_uploaded_file($_FILES[$nombre]['tmp_name'], $archivo);
                        return $archivo;
                } else {
                    echo "No puedes subir imágenes mayores de " . TAM_MAX__FILES;
                    return $_FILES[$nombre]['name'];
                }
            } else {
                echo "La imagen tiene un tipo no valido";
                return $_FILES[$nombre]['name'];
            }
        } //fin del isset interior
        else{
            return $_FILES[$nombre]['name'];
        }
    }
