<?php

class Usuario extends DBAbstractModel
{

	public $id_usuario;
	public $nombre_usuario;
	public $email_usuario;   //es clave alternativa
	public $pass_usuario;
	public $tipo_usuario;

	function __construct()
	{
		//$this->db_name = 'herbariodb';  //en la primera versión se pasa solo el nombre de la base de datos
		//se modifica este método para poder cambiar los datos de conexión a la base de datos sin necesidad de tocar las clases, solo editando un archivo de texto
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
	public function getFromEmail($email_usuario = '')
	{  //se añade función para obtener usuario a partir del email, que necesito para ver si está ya registrado
		if ($email_usuario != '') {
			$this->query = "
			SELECT id_usuario,nombre_usuario,email_usuario,pass_usuario,tipo_usuario
			FROM usuarios
			WHERE email_usuario = '$email_usuario'
			";
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
		//compruebo si el mail está registrado.
		if (array_key_exists('email_usuario', $data)) {
			$this->getFromEmail($data['email_usuario']); //leemos el mail por si existe, no añadir el usuario de nuevo
			
			if ($data['email_usuario'] != $this->email_usuario) {
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
					$this->msg = 'Usuario ' . $nombre_usuario . ' registrado con éxito';		
			} else {
				$this->msg = 'El correo ' . $this->email_usuario . ' ya está registrado';
			}
		} else {
			$this->msg = 'No se ha agregado el usuario';
		}
	}
	public function edit($data = array())
	{
		//compruebo si el mail está registrado.
		if (array_key_exists('email_usuario', $data)) {
			$this->getFromEmail($data['email_usuario']); //leemos el mail por si existe, no poder ponerlo a otro usuario

			if ($data['id_usuario'] == $this->id_usuario || $this->id_usuario =="") {  //si el correo pertenece al usuario que quiero modificar, o no pertenece a nadie peudo continuar con el cambio. 
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
			} else {
				$this->msg = 'El correo ' . $this->email_usuario . ' ya está registrado';
			}
		} else {
			$this->msg = 'No se ha modificado el usuario';
		}
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
