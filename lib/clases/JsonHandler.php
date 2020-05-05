<?php
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
}

?>