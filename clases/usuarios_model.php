<?php

class Usuario extends DBAbstractModel
{

	public $id_usuario;
	public $nombre_usuario;
	public $email_usuario;
	public $pass_usuario;
	public $tipo_usuario;

	function __construct()
	{
		//se modifica este método para poder modificar los datos de conexión a la base de datos sin necesidad de modificar las clases, solo editando un archivo de texto
		$fichero = "config.txt";
		$contenido = array();

		if (is_file($fichero)) {
			foreach (file($fichero) as $fila) {
				list($key, $value) = explode(':', $fila, 2) + array(NULL, NULL);
				if ($value !== NULL) {
					$contenido[$key] = $value;
				}
			}

			$this->db_host = rtrim($contenido["servidor"]);
			$this->db_user = rtrim($contenido["usuario"]);
			$this->db_pass = rtrim($contenido["pass"]);
			$this->db_name = rtrim($contenido["tabla"]);
		} else
			$this->error = "ERROR: No existe el fichero de configuración de la conexión.";


		//$this->db_name = 'herbariodb';  //en la primera versión se pasa solo el nombre de la base de datos
	}
	public function get($id_usuario = '')
	{
		if ($id_usuario != '') {
			$this->query = "
			SELECT id_usuario,nombre_usuario,email_usuario,pass_usuario,tipo_usuario
			FROM usuarios
			WHERE id_usuario = '$id_usuario'
			";
			$this->get_results_from_query();
		} else {
			$this->query = "
			SELECT id_usuario,nombre_usuario,email_usuario,pass_usuario,tipo_usuario
			FROM usuarios";
			$this->get_results_from_query();
		}
		if (count($this->rows) == 1) :
			foreach ($this->rows[0] as $propiedad => $valor) :
				$this->$propiedad = $valor;
			endforeach;
		endif;
	}
	public function set($data = array())
	{
		//como el id_usuario es autoincrementable, nunca se repetirá... no hace falta comprobar si existe
		foreach ($data as $campo => $valor) :
			$$campo = $valor;
		endforeach;
		$this->query = "
				INSERT INTO usuarios
				(nombre_usuario,email_usuario,pass_usuario,tipo_usuario)
				VALUES
				('$nombre_usuario', '$email_usuario', '$pass_usuario', '$tipo_usuario')
				";
		$this->execute_single_query();
		if ($this->error == "") //si no hay error
			$this->msg = 'Usuario ' . $nombre_usuario . ' agregado con éxito';
	}
	public function edit($data = array())
	{
		foreach ($data as $campo => $valor) :
			$$campo = $valor;
		endforeach;
		$this->query = "
			UPDATE usuarios
			SET nombre_usuario='$nombre_usuario',
			email_usuario='$email_usuario',
			pass_usuario='$pass_usuario',
			tipo_usuario='$tipo_usuario'
			WHERE id_usuario = '$id_usuario'
		";
		//echo $this->query;
		$this->execute_single_query();
		if ($this->error == "") //si no hay error
			$this->msg = 'Usuario ' . $nombre_usuario . ' modificado con éxito';
	}
	public function delete($id_usuario = '')
	{
		$this->query = "
		DELETE FROM usuarios
		WHERE id_usuario = '$id_usuario'
		";
		$this->execute_single_query();
		if ($this->error == "") //si no hay error
			$this->msg = 'Usuario ' . $id_usuario . ' eliminado con éxito';
	}
	function __destruct()
	{
		//unset($this);
	}
}
