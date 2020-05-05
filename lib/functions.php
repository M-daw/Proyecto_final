<?php
define("TAM_MAX__FILES", 700000);

//en local
/*$raiz = realpath($_SERVER["DOCUMENT_ROOT"]);
require $raiz . "/Proyecto/clases/db_abstract_model.php";
require $raiz . "/Proyecto/clases/usuarios_model.php";
require $raiz . "/Proyecto/clases/plantas_model.php";
require $raiz . "/Proyecto/clases/imagenes_model.php";
/*
//en host
require "./clases/db_abstract_model.php";
require "./clases/usuarios_model.php";
require "./clases/plantas_model.php";
require "./clases/imagenes_model.php";
*/

require "clases/db_abstract_model.php";
require "clases/usuarios_model.php";
require "clases/plantas_model.php";
require "clases/imagenes_model.php";
//Función para subir las imágenes al servidor y obtener su ruta
function subirImagen($nombre, $subdir = "")
{
    if ($subdir == "galeria") {
        $destino = "./img/plantas/galerias/";
    } else {
        $destino = "./img/plantas/";
    }

    if ($_FILES[$nombre]['name'] !== "") {
        $archivo = $destino . $_FILES[$nombre]['name'];
        if (is_file($destino .  $_FILES[$nombre]['name'])) {
            $archivo = $destino . time() .  $_FILES[$nombre]['name']; //si hay una imgane con ese nombre, se le añade un timestamp para que sea diferente
        }
        //control del tipo de _FILES[]
        $tiposValidos = array("image/gif", "image/jpeg", "image/png"); //se controla tb desde HTML5
        if (in_array($_FILES[$nombre]["type"], $tiposValidos)) {
            //controla el tamaño del _FILES[]
            if ($_FILES[$nombre]["size"] <= TAM_MAX__FILES) {
                if (is_uploaded_file($_FILES[$nombre]['tmp_name'])) {
                    if (move_uploaded_file($_FILES[$nombre]['tmp_name'], $archivo)) {
                        return $archivo;
                    } else {
                        return "";  //si falla, devuelve campo vacío
                    }
                }
            } else {
                echo "No puedes subir imágenes mayores de " . TAM_MAX__FILES;
                return $_FILES[$nombre]['name'];
            }
        } else {
            echo "La imagen tiene un tipo no valido";
            return $_FILES[$nombre]['name'];
        }
    } else {
        return $_FILES[$nombre]['name'];
    }
}

//capturo un parámetro enviado desde AJAX para que se ejecute la función de ordenar
if (isset($_POST["ordenar"])) {
    //var_dump($_POST);
    $col = $_POST["col"];
    if ($_POST["order"] == "asc") {
        $order = SORT_ASC;
    } else {
        $order = SORT_DESC;
    }
    $array = array();
    $_POST["datos"] = str_replace("\r\n", '\r\n', $_POST["datos"]); //el json daba errores de formato por los retornos de carro
    $array = JsonHandler::decode($_POST["datos"]);
    array_sort_by($array, $col, $order);
    //var_dump($array);   //respeta acentos ok
    echo json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);   //devuelvo el array en formato json a la llamada ajax. Esta vez no respetaba acentos
}

//función para ordenar los resultados de las búsquedas a base de datos en función de una de las columnas
function array_sort_by(&$array, $col, $order = SORT_ASC)
{  //el array se tiene que pasar por referencia
    foreach ($array as $key => $valor) { //se contruye array auxiliar con los valores de la columna por la que quiero ordenar las plantas
        $arrAux[$key] = is_object($valor) ? $arrAux[$key] = $valor->$col : $valor[$col];
        $arrAux[$key] = strtolower($arrAux[$key]);
    }
    array_multisort($arrAux, $order, $array);
    //var_dump($arrAux);
}


//llamadas a métodos para borrar registros o fotos. Reciben los parámetros por AJAX
if (isset($_POST['borrSI'])) {
    if (($_POST['tipo']) == "usuario") {
        $borrable = new Usuario();
    } else if (($_POST['tipo']) == "planta") {
        $borrable = new Planta();
    }
    $borrable->delete($_POST['id']);  //llamo a sus respectivos métodos
    $error = $borrable->error;
    $msg = $borrable->msg;
    echo $borrable->error . $borrable->msg;
}

if (isset($_POST['borrFoto'])) {
    //var_dump($_POST);
    $tipo = $_POST["tipo"];
    $ruta = $_POST["ruta"]; //hay que volver a definirla. La página recarga y no se guarda la variable 
    if ($tipo != "galeria") {
        $id = $_POST["id"];
    } else {
        $ids =  explode(",", $_POST["id"]); //las ids estan en un string
    }

    $msg = "";
    $error = "";

    if ($tipo != "galeria") {
        //$borrar =  "$raiz/Proyecto/$ruta";
        $borrar =  $ruta;
        if (file_exists($borrar)) {
            if (unlink($borrar)) { //borro la imagen del servidor
                $msg .= "Se ha borrado la foto";
            } else {
                $error .= "No se ha podido borrar la foto";
            }
        }
        //y elimino la imagen de la base de datos, llamando a su método (de planta)
        $planta = new Planta();
        $planta->borrarFoto($id, $tipo);
    } else {
        //si es de galería se borra de la tabla de Imágenes
        foreach ($ids as $id) {
            $imagen = new Imagen();
            $imagen->get($id);
            $ruta = $imagen->enlace_imagen;
            //$borrar =  "$raiz/Proyecto/$ruta";
            $borrar =  $ruta;
            if (file_exists($borrar)) {
                if (unlink($borrar)) { //borro la imagen del servidor
                    $msg .= "Se ha borrado la foto del servidor \n";
                } else {
                    $error .= "No se ha podido borrar la foto \n";
                }
            }
            $imagen->delete($id);
            $msg .= $imagen->msg . " de la base de datos \n";
            $error .= $imagen->error;
        }
    }
    echo $error . $msg;  //devuelvo el mensaje o el error a la función de JS para que la imprima en pantalla.
}


/**
 * funciones que llama a los métodos getAuthor y getSciName de la clase Imagen.
 * 
 * Estas funciones no son estrictamente necesarias, pero, aunque no estoy usando vistas y
 * controladores separados, he intentado mantener la lógica separada de las "vistas" dentro
 * de mis scripts php. 
 * Necesitaba crear una nueva Imagen en las galerías que se crean con los scripts borrarimage.phh 
 * y galeriausuarios.php para evitar que fuese sumando filas de resultados a la Imagen creada
 * previemente en esos archivos, que es la que contiene el resultado de la búsqueda de imágenes dada
 * una id de planta o de usuario, y quería evitar ese código en la parte "vista" de mi script.
 */

function obtenerAutor($id_imagen)
{
    $aux = new Imagen();
    $aux->getAuthor($id_imagen);
    return $aux->nombre_usuario;
}

function obtenerNombreCi($id_imagen)
{
    $aux = new Imagen();
    $aux->getSciName($id_imagen);
    return $aux->nombre_cientifico;
}

/**
 * Función para sustituir al get_result() en el objeto $stmt, ya que no funciona en el host
 */
function fetchAssocStatement($stmt)
{
    if($stmt->num_rows>0)
    {
        $result = array();
        $md = $stmt->result_metadata();
        $params = array();
        while($field = $md->fetch_field()) {
            $params[] = &$result[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        if($stmt->fetch())
            return $result;
    }
    return null;
}


/*class JsonHandler
{
    // Array con los mensajes de error
    protected static $mensajes = array(
        JSON_ERROR_NONE           => 'No ha habido ningún error',
        JSON_ERROR_DEPTH          => 'Se ha alcanzado el máximo nivel de profundidad',
        JSON_ERROR_STATE_MISMATCH => 'JSON inválido o mal formado',
        JSON_ERROR_CTRL_CHAR      => 'Error de control de caracteres, posiblemente incorrectamente codificado',
        JSON_ERROR_SYNTAX         => 'Error de sintaxis',
        JSON_ERROR_UTF8           => 'Caracteres UTF-8 mal formados, posiblemente incorrectamente codificado'
    );
    // Función para Codificar
    public static function encode($value, $options = 0)
    {
        $result = json_encode($value, $options);
        if ($result) {
            return $result;
        }
        throw new RuntimeException(static::$mensajes[json_last_error()]);
    }
    // Función para decodificar
    public static function decode($json, $assoc = false)
    {
        $result = json_decode($json, $assoc);
        if ($result) {
            return $result;
        }
        throw new RuntimeException(static::$mensajes[json_last_error()]);
    }
}*/
