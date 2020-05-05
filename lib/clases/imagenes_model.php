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

		//local
		$raiz = realpath($_SERVER["DOCUMENT_ROOT"]);
		$fichero = $raiz."/Proyecto/config.txt";
		/*
		//host
		$fichero = $_SERVER['DOCUMENT_ROOT']."/config.txt";
		*/
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
			/*$this->query = "
			SELECT id_imagen,id_planta,id_usuario,enlace_imagen
			FROM imagenes
			WHERE id_imagen = '$id_imagen'
			";*/ //query original, sin sentencias preparadas
			$this->query = "
			SELECT id_imagen,id_planta,id_usuario,enlace_imagen
			FROM imagenes
			WHERE id_imagen = ?
			";
			//echo $this->query;
			//$this->get_results_from_query();  //llamada a la función original, sin sentencias preparadas
			$this->get_results_from_query("i", $id_imagen);
		} else {
			$this->query = "
			SELECT id_imagen,id_planta,id_usuario,enlace_imagen
			FROM imagenes";
			//echo $this->query;
			$this->get_results_from_query();
		}
		if (count($this->rows) == 1) :
			foreach ($this->rows[0] as $propiedad => $valor) :
				$this->$propiedad = $valor;
			endforeach;
		endif;
	}

	public function getFromUser($id_usuario = '')
	{ //se añade función para obtener la planta a partir de su nombre científico, que necesito para ver si está ya registrada
		if ($id_usuario != '') {
			/*$this->query = "
			SELECT *
			FROM imagenes
			WHERE id_usuario = '$id_usuario'
			";*/
			$this->query = "
			SELECT *
			FROM imagenes
			WHERE id_usuario = ?
			";
			//echo $this->query;
			//$this->get_results_from_query();
			$this->get_results_from_query("i", $id_usuario);
		}
		if (count($this->rows) == 1) :
			foreach ($this->rows[0] as $propiedad => $valor) :
				$this->$propiedad = $valor;
			endforeach;
		endif;
	}

	public function getFromPlant($id_planta = '')
	{ //se añade función para obtener la planta a partir de su nombre científico, que necesito para ver si está ya registrada
		if ($id_planta != '') {
			/*$this->query = "
			SELECT *
			FROM imagenes
			WHERE id_planta = '$id_planta'
			";*/
			$this->query = "
			SELECT *
			FROM imagenes
			WHERE id_planta = ?
			";
			//echo $this->query;
			//$this->get_results_from_query();
			$this->get_results_from_query("i", $id_planta);
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
		/*$this->query = "
				INSERT INTO imagenes
				(id_planta,id_usuario,enlace_imagen)
				VALUES
				('$id_planta', '$id_usuario', '$enlace_imagen')
				";*/
		$this->query = "
				INSERT INTO imagenes
				(id_planta,id_usuario,enlace_imagen)
				VALUES
				(?, ?, ?)
				";
		//echo $this->query;
		//$this->execute_single_query();
		$this->execute_single_query("iis", $id_planta, $id_usuario, $enlace_imagen);
		if ($this->error == "") //si no hay error
			$this->msg = 'Imagen agregada con éxito';
	}
	public function edit($data = array())
	{
		foreach ($data as $campo => $valor) :
			$$campo = $valor;
		endforeach;
		/*$this->query = "
			UPDATE imagenes
			SET id_planta='$id_planta',
			id_usuario='$id_usuario',
			enlace_imagen='$enlace_imagen'
			WHERE id_imagen = '$id_imagen'
		";*/
		$this->query = "
			UPDATE imagenes
			SET id_planta= ?,
			id_usuario= ?,
			enlace_imagen= ?
			WHERE id_imagen = ?
		";
		//echo $this->query;
		//$this->execute_single_query();
		$this->execute_single_query("iisi", $id_planta, $id_usuario, $enlace_imagen, $id_imagen);
		if ($this->error == "") //si no hay error
			$this->msg = 'Imagen ' . $id_imagen . ' modificada con éxito';
	}
	public function delete($id_imagen = '')
	{
		/*$this->query = "
		DELETE FROM imagenes
		WHERE id_imagen = '$id_imagen'
		";*/
		$this->query = "
		DELETE FROM imagenes
		WHERE id_imagen = ?
		";
		//echo $this->query;
		//$this->execute_single_query();
		$this->execute_single_query("i", $id_imagen);
		if ($this->error == "") //si no hay error
			$this->msg = 'Imagen ' . $id_imagen . ' eliminada con éxito';
	}
	public function getAuthor($id_imagen = '')
	{ //se añade función para obtener los datos del autor de una imagen, dada la id de la misma
		if ($id_imagen != '') {
			/*$this->query = "
			SELECT *
			FROM usuarios join imagenes on imagenes.id_usuario = usuarios.id_usuario
			WHERE id_imagen = '$id_imagen'
			";*/
			$this->query = "
			SELECT *
			FROM usuarios join imagenes on imagenes.id_usuario = usuarios.id_usuario
			WHERE id_imagen = ?
			";
			//echo $this->query;
			//$this->get_results_from_query();
			$this->get_results_from_query("i", $id_imagen);
		}
		if (count($this->rows) == 1) :
			foreach ($this->rows[0] as $propiedad => $valor) :
				$this->$propiedad = $valor;
			endforeach;
		endif;
	}
	public function getSciName($id_imagen = '')
	{ //se añade función para obtener los datos de una planta, dada la id de su imagen
		if ($id_imagen != '') {
			/*$this->query = "
			SELECT *
			FROM plantas join imagenes on imagenes.id_planta = plantas.id_planta
			WHERE id_imagen = '$id_imagen'
			";*/
			$this->query = "
			SELECT *
			FROM plantas join imagenes on imagenes.id_planta = plantas.id_planta
			WHERE id_imagen = ?
			";
			//echo $this->query;
			//$this->get_results_from_query();
			$this->get_results_from_query("i", $id_imagen);
		}
		if (count($this->rows) == 1) :
			foreach ($this->rows[0] as $propiedad => $valor) :
				$this->$propiedad = $valor;
			endforeach;
		endif;
	}

	function __destruct()
	{
		//unset($this);
	}
}
