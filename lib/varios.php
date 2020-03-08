<?PHP

function dibuja_select($nomSel, $datos, $campo1, $activo = "", $campo2 = "", $campo3 = "", $todos = false)
{
   $html = "";
   $html .= "<select name='$nomSel'>\n";
   if ($todos)
      $html .= "<option value='Todas'>Todas</option>\n";
   $cuantas = count($datos);
   if ($cuantas > 0) {
      for ($cont = 0; $cont < $cuantas; $cont++) {
         $fila = $datos[$cont];
         $visto = $fila[$campo1];
         $valor = $fila[$campo1];
         if ($campo2 != "")
            $visto = $fila[$campo2];
         if ($campo2 != "" and $campo3 != "")
            $visto = $fila[$campo2] . " " . $fila[$campo3];
         if ($activo == $valor)
            $selected = "Selected='selected'";
         else
            $selected = "";

         $html .= "<option value='$valor' $selected>$visto</option>\n";
      }
   }
   $html .= "</select>\n";
   return $html;
}

function correoCorrecto($str)
{
   if (preg_match('/^[(a-z0-9\_\-\.)]+@[(a-z0-9\_\-\.)]+\.[(a-z)]{2,15}$/i', $str))
      return true;
   else
      return false;
}

// -----------------------------------------------------------------
// Biblioteca de variables y funciones para el manejo de fechas
// -----------------------------------------------------------------

// -----------------------------------------------------------------
// Tabla de meses
// -----------------------------------------------------------------
$meses = array(
   "enero", "febrero", "marzo", "abril",
   "mayo", "junio", "julio", "agosto",
   "septiembre", "octubre", "noviembre", "diciembre"
);

// -----------------------------------------------------------------
// Convertir fecha a cadena
// -----------------------------------------------------------------
function date2string($date)
{
   // Formato: día del mes (número, sin ceros) /
   //          mes del año (número, sin ceros) /
   //          año (cuatro dígitos)
   // Ejemplo: 7/11/2002
   $string = date("j/n/Y", strtotime($date));
   return ($string);
}

// -----------------------------------------------------------------
// Convertir (día, mes, año) en fecha
// -----------------------------------------------------------------
function dmy2date($dia, $mes, $anyo)
{
   $meses = array(
      "enero", "febrero", "marzo", "abril", "mayo",
      "junio", "julio", "agosto", "septiembre",
      "octubre", "noviembre", "diciembre"
   );
   $i = 0;
   $enc = 0;
   while ($i < 12 && !$enc) {
      if ($meses[$i] == $mes)
         $enc = 1;
      else
         $i++;
   }
   $fecha = date("Y-m-d", mktime(0, 0, 0, $i + 1, $dia, $anyo));
   return ($fecha);
}

// -----------------------------------------------------------------
// Obtener el día del mes de una fecha
// -----------------------------------------------------------------
function dayofdate($date)
{
   $dia = date("j", strtotime($date));
   return ($dia);
}

// -----------------------------------------------------------------
// Obtener el mes del año de una fecha
// -----------------------------------------------------------------
function monthofdate($date)
{
   $mes = date("n", strtotime($date));
   return ($mes);
}

// -----------------------------------------------------------------
// Obtener el año de una fecha
// -----------------------------------------------------------------
function yearofdate($date)
{
   $anyo = date("Y", strtotime($date));
   return ($anyo);
}

// -----------------------------------------------------------------
// Obtener la fecha de hoy
// -----------------------------------------------------------------
function today()
{
   $todayDate = date("Y-m-d");
   return ($todayDate);
}

// -----------------------------------------------------------------
// Obtener el número de días de un mes dado de un año dado
// -----------------------------------------------------------------
function daysofMonth($month, $year)
{
   $ndays = date("t", mktime(0, 0, 0, 1, $month, $year));
   return ($ndays);
}
