<?php

class Imagen extends DBAbstractModel
{

	public $id_imagen;
	public $id_planta;
	public $id_usuario;
	public $enlace_imagen;

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
	public function get($id_imagen = '')
	{
		if ($id_imagen != '') {
			$this->query = "
			SELECT id_imagen,id_planta,id_usuario,enlace_imagen
			FROM imagenes
			WHERE id_imagen = '$id_imagen'
			";
			$this->get_results_from_query();
		} else {
			$this->query = "
			SELECT id_imagen,id_planta,id_usuario,enlace_imagen
			FROM imagenes";
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
		//como el id_imagen es autoincrementable, nunca se repetirá... no hace falta comprobar si existe
		foreach ($data as $campo => $valor) :
			$$campo = $valor;
		endforeach;
		$this->query = "
				INSERT INTO imagenes
				(id_planta,id_usuario,enlace_imagen)
				VALUES
				('$id_planta', '$id_usuario', '$enlace_imagen')
				";
		$this->execute_single_query();
		if ($this->error == "") //si no hay error
			$this->msg = 'Imagen ' . $id_imagen . ' agregada con éxito';
	}
	public function edit($data = array())
	{
		foreach ($data as $campo => $valor) :
			$$campo = $valor;
		endforeach;
		$this->query = "
			UPDATE imagenes
			SET id_planta='$id_planta',
			id_usuario='$id_usuario',
			enlace_imagen='$enlace_imagen'
			WHERE id_imagen = '$id_imagen'
		";
		//echo $this->query;
		$this->execute_single_query();
		if ($this->error == "") //si no hay error
			$this->msg = 'Imagen ' . $id_imagen . ' modificada con éxito';
	}
	public function delete($id_imagen = '')
	{
		$this->query = "
		DELETE FROM imagenes
		WHERE id_imagen = '$id_imagen'
		";
		$this->execute_single_query();
		if ($this->error == "") //si no hay error
			$this->msg = 'Imagen ' . $id_imagen . ' eliminada con éxito';
	}
	function __destruct()
	{
		//unset($this);
	}
}
