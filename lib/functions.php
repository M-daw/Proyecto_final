<?php
define("TAM_MAX__FILES", 1500000);

require "clases/db_abstract_model.php";
require "clases/usuarios_model.php";
require "clases/plantas_model.php";
require "clases/imagenes_model.php";
require "clases/JsonHandler.php";
require "clases/mailer/PHPMailer.php";
require "clases/mailer/SMTP.php";
require "clases/mailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
/* Se define constante con el email del admin principal, para poder usarla en la configuración de envío de emails de registro*/

$usuario = new Usuario();
$error = $usuario->error;
if ($error === "") { //capturo el error si no hay fichero de configuración
    $usuario->get(1);
    define("EMAIL_ADMIN", $usuario->email_usuario);
}

/**
 * Función para subir las imágenes al servidor y obtener su ruta
 */
function subirImagen($nombre, $subdir = "")
{
    if ($subdir == "galeria") {
        $destino = "./img/plantas/galerias/";
    } else {
        $destino = "./img/plantas/fichas/";
    }

    if ($_FILES[$nombre]['name'] !== "") {
        $archivo = $destino . $_FILES[$nombre]['name'];
        if (is_file($destino .  $_FILES[$nombre]['name'])) {
            $archivo = $destino . time() .  $_FILES[$nombre]['name']; //si hay una imagen con ese nombre, se le añade un timestamp para que sea diferente
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
                    }
                }
            } else {
                //echo "No puedes subir imágenes mayores de " . TAM_MAX__FILES;   
            }
        } else {
            //echo "La imagen tiene un tipo no valido";  
        }
    } else {
        return $_FILES[$nombre]['name'];
    }
}

/**
 * Función para ordenar los resultados de las búsquedas a base de datos en función de una de las columnas,
 * que se envía como parámetro.
 * 
 * Esa columna se captura de un parámetro enviado desde AJAX-
 * 
 */
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

function array_sort_by(&$array, $col, $order = SORT_ASC)
{  //el array se tiene que pasar por referencia
    foreach ($array as $key => $valor) { //se contruye array auxiliar con los valores de la columna por la que quiero ordenar las plantas
        $arrAux[$key] = is_object($valor) ? $arrAux[$key] = $valor->$col : $valor[$col];
        $arrAux[$key] = strtolower($arrAux[$key]);
    }
    array_multisort($arrAux, $order, $array);
    //var_dump($arrAux);
}

/**
 * Llamadas a métodos para borrar registros o fotos. Reciben los parámetros por AJAX
 */
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
    $ruta = $_POST["ruta"];
    if ($tipo != "galeria") {
        $id = $_POST["id"];
    } else {
        $ids =  explode(",", $_POST["id"]); //las ids estan en un string
    }

    $msg = "";
    $error = "";

    if ($tipo != "galeria") {
        $borrar =  "." . $ruta;
        if (file_exists($borrar)) {
            if (unlink($borrar)) { //borro la imagen del servidor
                $msg .= "Se ha borrado la foto <br>";
            } else {
                $error .= "No se ha podido borrar la foto <br>";
            }
        }
        //y elimino la imagen de la base de datos, llamando a su método (de planta)
        $planta = new Planta();
        $planta->borrarFoto($id, $tipo);
        $msg .= $planta->msg . " de la base de datos <br>";
        $error .= $planta->error;
    } else {
        //si es de galería se borra de la tabla de Imágenes
        foreach ($ids as $id) {
            $imagen = new Imagen();
            $imagen->get($id);
            $ruta = $imagen->enlace_imagen;
            $borrar =  "." . $ruta;
            if (file_exists($borrar)) {
                if (unlink($borrar)) { //borro la imagen del servidor
                    $msg .= "Se ha borrado la foto del servidor <br>";
                } else {
                    $error .= "No se ha podido borrar la foto <br>";
                }
            }
            //y elimino la imagen de la base de datos, llamando a su método
            $imagen->delete($id);
            $msg .= $imagen->msg . " de la base de datos<br>";
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
    if ($stmt->num_rows > 0) {
        $result = array();
        $md = $stmt->result_metadata();
        $params = array();
        while ($field = $md->fetch_field()) {
            $params[] = &$result[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $params);
        if ($stmt->fetch())
            return $result;
    }
    return null;
}

/**
 * Función para contruir el array de imágenes para mostrar en las galerías
 * 
 * Si no hay suficientes imágenes disponibles se usan imágenes de relleno
 */
function crearArrayImagenes($id = "")
{
    $imagen = new Imagen();  //se recogen todas las imágenes de la galería
    if ($imagen->error === "") {
        if ($id != "") {
            $imagen->getFromPlant($id);  //si se ha enviado la id de una planta se recogen solo sus imágenes
        } else {
            $imagen->get(); //si no se ha enviado la id de una planta se recogen todas las imágenes de usuarios de la galería
        }
        $relleno = [
            "./img/plantas/default/slider1.jpg", "./img/plantas/default/slider2.jpg", "./img/plantas/default/slider3.jpg", "./img/plantas/default/slider4.jpg", "./img/plantas/default/slider5.jpg"
        ];  //se crea array con las imágenes de relleno

        if (count($imagen->get_rows()) > 0) {
            $datos = $imagen->get_rows();
            if (count($imagen->get_rows()) > 5) {  //si hay más de 5 imágenes las ordeno de forma aleatoria
                shuffle($datos);
            }
            foreach (array_slice($datos, 0, 5) as $fila) {
                foreach ($fila as $indice => $valor) {
                    if ($indice == "enlace_imagen") {
                        $imagenes[] = $valor;
                    }
                }
            }
            while (count($imagenes) < 5) {  //relleno con las imágenes modelo si no hay al menos 5 imágenes en la galería de usuarios (total, o de esa planta)
                $imagenes[] = $relleno[count($imagenes)];
            }
        } else {
            $imagenes = $relleno;
        }
        return $imagenes;
    } else {
        return $imagen->error;
    }
}

/**
 * Función para enviar correo tras el registro con el formulario.
 * Los registros los hace un administrador desde la página de gestión de usuarios, pero se ha incluido un
 * formulario para recoger peticiones de membresía. * 
 */

function enviarMail($emailRegistro, $nombreRegistro, $passRegistro)
{
    $fichero = __DIR__ . "/../correocfg.txt";
    $contenido = array();

    if (is_file($fichero)) {
        foreach (file($fichero) as $fila) {
            list($key, $value) = explode(':', $fila, 2) + array(null, null);
            if ($value !== null) {
                $contenido[$key] = $value;
            }
        }
        $emailhost = trim($contenido["host"]);
        $emailport = trim($contenido["port"]);
        $emailfrom = trim($contenido["enviaDesde"]);
        $emailpass = trim($contenido["pass"]);
    } else {
        return $error = "ERROR: No existe el fichero de configuración de la conexión.";
    }

    $mail = new PHPMailer();
    try {
        //$mail->SMTPDebug = 2;  //para controlar el proceso de envío
        $mail->SMTPAuth = true;
        if ($emailport == 465) {
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->isSMTP();
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
        } else {
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
        }
        $mail->Host = $emailhost;
        $mail->Username = EMAIL_ADMIN;
        $mail->Password = $emailpass;
        $mail->setFrom($emailfrom, 'Herbario On-Line');   //dirección desde la que se envía

        //settings para local
        /*$mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->isSMTP();
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->Host = "smtp.gmail.com";
        $mail->Username = EMAIL_ADMIN;
        $mail->Password = 'ContrasenyaparaPract1cas';
        $mail->setFrom(EMAIL_ADMIN, 'Herbario On-Line');   //dirección desde la que se envía

        //settigns para hosting
        /*$mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->Host = 'smtp.mboxhosting.com';
        $mail->Username = 'm@gatoscuanticos.dx.am';
        $mail->Password = 'emaildeprueba1';
        $mail->setFrom('m@gatoscuanticos.dx.am', 'Herbario On-Line');*/

        $mail->addAddress(EMAIL_ADMIN);                    //dirección a la que se envía
        $mail->addReplyTo($emailRegistro, $nombreRegistro);         //dirección a la que se responderá
        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);
        $mail->Subject = "Registro en Herbario On-Line";
        $mail->Body = "Hola Administrador,<br>
    Tienes una nueva solicitud de registro en el Herbario OnLine <br>
    Los datos del nuevo usuario son <br>
    Nombre: $nombreRegistro <br>
    Correo: $emailRegistro<br>
    Pass: $passRegistro <br>
    Un saludo!";
        if ($mail->send() != false) {
            return "Se ha enviado un correo al administrador con tus datos. En breve recibirás la confirmación de la activación de tu cuenta";
        } else {
            return "No se ha podido enviar el correo: $mail->ErrorInfo";
        }
    } catch (Exception $e) {
        return "No se ha podido enviar el correo: $mail->ErrorInfo";
    }
}

//array descripciones y títulos para metas en el header
$descripciones = array(
    "ini" => "En el Herbario online de la Sierra de Crevillent encontrarás información de las plantas de esta zona de Alicante. Colabora con tus fotos en el herbario virtual.",
    "col" => "Colección de las plantas disponibles en el Herbario online de la Sierra de Crevillent. Si no encuentras la especie que buscas, regístrate para colaborar.",
    "fp" => " - Ficha de planta en el Herbario online de la Sierra de Crevillent con información detallada de la especie y fotografías.",
    "glu" => "Disfruta juntas todas tus fotos subidas a las galerías de colaboración de usuarios de cada especie del Herbario online de la Sierra de Crevillent."
);

$titulos = array(
    "ini" => "Herbario online de la Sierra de Crevillent",
    "col" => "Colección del Herbario online de la Sierra de Crevillent",
    "fp" => " - Herbario online de la Sierra de Crevillent",
    "glu" => "Galeria de usuario del Herbario online de la Sierra de Crevillent"
);
