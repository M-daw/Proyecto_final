<?php
define("TAM_MAX__FILES", 700000);
$raiz = realpath($_SERVER["DOCUMENT_ROOT"]);
require $raiz . "/Proyecto/clases/db_abstract_model.php";
require $raiz . "/Proyecto/clases/usuarios_model.php";
require $raiz . "/Proyecto/clases/plantas_model.php";
require $raiz . "/Proyecto/clases/imagenes_model.php";

//Función para subir las imágenes al servidor y obtener su ruta
function subirImagen($nombre, $subdir = "")
{
    if($subdir == "galeria"){
        $destino = "./img/plantas/galerias/";
    }else{
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
                if (is_uploaded_file($_FILES[$nombre]['tmp_name'])){
                    if(move_uploaded_file($_FILES[$nombre]['tmp_name'], $archivo)){
                        return $archivo;
                    }else{
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
    } 
    else {
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


//función para borrar registros. Se le envían los parámetros por AJAX
if (isset($_POST['borrSI'])) {
    if (($_POST['tipo']) == "usuario") {
        $borrable = new Usuario();
    } else if (($_POST['tipo']) == "planta") {
        $borrable = new Planta();
    }
    $borrable->delete($_POST['id']);
    $error = $borrable->error;
    $msg = $borrable->msg;
    echo $borrable->error . $borrable->msg;
}

if (isset($_POST['borrFoto'])) {
    $ruta = $_POST["ruta"]; //hay que volver a definirla. La página recarga y no se guarda la variable 
    $tipo = $_POST["tipo"];
    $id = $_POST["id"];
    $msg = "";
    $error = "";
    $raiz = realpath($_SERVER["DOCUMENT_ROOT"]);
    $borrar =  "$raiz/Proyecto/$ruta";
    if (file_exists($borrar)) {
        if (unlink($borrar)) { //borro la imagen del servidor
            $msg = "Se ha borrado la foto";
        } else {
            $error = "No se ha podido borrar la foto";
        }
    }
    //y elimino la imagen de la base de datos
    if ($tipo != "galeria") {
        $planta = new Planta();
        $planta->borrarFoto($id, $tipo);
    } else {
        //aquí se creará una new Imagen
    }

    echo $error . $msg;
}





class JsonHandler
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
    // Codificar
    public static function encode($value, $options = 0)
    {
        $result = json_encode($value, $options);
        if ($result) {
            return $result;
        }
        throw new RuntimeException(static::$mensajes[json_last_error()]);
    }
    // Decodificar
    public static function decode($json, $assoc = false)
    {
        $result = json_decode($json, $assoc);
        if ($result) {
            return $result;
        }
        throw new RuntimeException(static::$mensajes[json_last_error()]);
    }
}
