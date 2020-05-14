<?php

class Planta extends DBAbstractModel
{

	public $id_planta;
	public $nombre_cientifico;
	public $nombre_castellano;
	public $nombre_valenciano;
	public $nombre_ingles;
	public $familia;
	public $caracteres_diagnosticos;
	public $uso;
	public $biotipo;
	public $habitat;
	public $distribucion;
	public $cat_UICN;
	public $floracion;
	public $foto_general;
	public $foto_flor;
	public $foto_hoja;
	public $foto_fruto;
	public $id_usuario;

	function __construct()
	{
		//$this->db_name = 'herbariodb';  //en la primera versión se pasa solo el nombre de la base de datos
		//se modifica este método para poder cambiar los datos de conexión a la base de datos sin necesidad de tocar las clases, solo editando un archivo de texto
		$fichero = __DIR__ . "/../../config.txt";
		$contenido = array();

		if (is_file($fichero)) {
			foreach (file($fichero) as $fila) {
				list($key, $value) = explode(':', $fila, 2) + array(NULL, NULL);
				if ($value !== NULL) {
					$contenido[$key] = $value;
				}
			}

			static::setDb_host(trim($contenido["servidor"]));
			static::setDb_user(trim($contenido["usuario"]));
			static::setDb_pass(trim($contenido["pass"]));
			static::setDb_name(trim($contenido["db"]));
		} else
			$this->error = "ERROR: No existe el fichero de configuración de la conexión.";
	}
	public function get($id = '')
	{
		if ($id != '') {
			$this->query = "
			SELECT *
			FROM plantas
			WHERE id_planta = ?
			";
			//echo $this->query;
			$this->get_results_from_query("i", $id);
		} else {
			$this->query = "
			SELECT *
			FROM plantas";
			//echo $this->query;
			$this->get_results_from_query();
		}
		if (count($this->rows) == 1) :
			foreach ($this->rows[0] as $propiedad => $valor) :
				$this->$propiedad = $valor;
			endforeach;
		endif;
	}
	public function getFromName($nombre_cientifico = '')
	{ //se añade función para obtener la planta a partir de su nombre científico, que necesito para ver si está ya registrada
		if ($nombre_cientifico != '') {
			$this->query = "
			SELECT *
			FROM plantas
			WHERE nombre_cientifico = ?
			";
			//echo $this->query;
			$this->get_results_from_query("s", $nombre_cientifico);
		}
		if (count($this->rows) == 1) :
			foreach ($this->rows[0] as $propiedad => $valor) :
				$this->$propiedad = $valor;
			endforeach;
		endif;
	}
	public function getFamilias()
	{ //se añade función para obtener las diferentes familias, para dibujar su select
		$this->query = "
			SELECT distinct familia
			FROM plantas
			ORDER BY familia ASC
			";
		//echo $this->query;
		$this->get_results_from_query();
		if (count($this->rows) == 1) :
			foreach ($this->rows[0] as $propiedad => $valor) :
				$this->$propiedad = $valor;
			endforeach;
		endif;
	}
	public function buscar($texto = '')
	{ //se añade función para obtener nombres de planta a partir de un texto a buscar
		if ($texto != '') {
			$this->query = "
			SELECT *
			FROM plantas
			WHERE nombre_cientifico LIKE CONCAT('%', ?, '%')
			";
			//$this->get_results_from_query();
			$this->get_results_from_query("s", $texto);
		}
		if (count($this->rows) == 1) {
			foreach ($this->rows[0] as $propiedad => $valor) :
				$this->$propiedad = $valor;
			endforeach;
		} else if (count($this->rows) == 0) {
			$this->msg = 'No hay resultados que se ajusten a la búsqueda';
		}
	}
	public function set($data = array())
	{
		//el id_planta es autoincrementable, nunca se repetirá, pero hay que comprobar si el nombre científico está registrado
		if (array_key_exists('nombre_cientifico', $data)) {
			$this->getFromName(trim($data['nombre_cientifico'])); //leemos el nombre por si existe, no añadir la planta de nuevo. JS hace un trim para el nombre científico, pero lo pongo por si se inactiva JS.

			if ($data['nombre_cientifico'] != $this->nombre_cientifico) {
				foreach ($data as $campo => $valor) :
					$$campo = trim($valor); //elimino posibles espacios en blanco "alrededor" del texto tecleado por el usuario. No es tan crítico como en la clase usuario, donde esos espacios pueden afectar al login
				endforeach;
				$this->query = "
				INSERT INTO plantas
				(nombre_cientifico,nombre_castellano,nombre_valenciano,nombre_ingles,familia,caracteres_diagnosticos,uso,biotipo,habitat,distribucion,cat_UICN,floracion,foto_general,foto_flor,foto_hoja,foto_fruto,id_usuario)
				VALUES
				(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				";
				//echo $this->query;
				$this->execute_single_query("ssssssssssssssssi", $nombre_cientifico, $nombre_castellano, $nombre_valenciano, $nombre_ingles, $familia, $caracteres_diagnosticos, $uso, $biotipo, $habitat, $distribucion, $cat_UICN, $floracion, $foto_general, $foto_flor, $foto_hoja, $foto_fruto, $id_usuario);
				if ($this->error == "") //si no hay error
					$this->msg = 'Planta ' . $nombre_cientifico . ' agregada con éxito';
			} else {
				$this->msg = 'La planta ' . $this->nombre_cientifico . ' ya está registrada';
			}
		} else {
			$this->msg = 'No se ha añadido la planta';
		}
	}
	public function edit($data = array())
	{
		//compruebo si el nombre científico está registrado
		if (array_key_exists('nombre_cientifico', $data)) {
			$this->getFromName(trim($data['nombre_cientifico'])); //leemos el nombre por si existe, no añadir la planta de nuevo. JS hace un trim para el nombre científico, pero lo pongo por si se inactiva JS.

			if ($data['id_planta'] == $this->id_planta || $this->id_planta == "") {  //si el nombre pertenece a la planta que quiero modificar, o no pertenece a nadie puedo continuar con el cambio. 
				foreach ($data as $campo => $valor) :
					$$campo = trim($valor); //elimino posibles espacios en blanco "alrededor" del texto tecleado por el usuario. No es tan crítico como en la clase usuario, donde esos espacios pueden afectar al login
				endforeach;
				$this->query = "
				UPDATE plantas
				SET nombre_cientifico= ?,
				nombre_castellano= ?, 
				nombre_valenciano= ?, 
				nombre_ingles= ?, 
				familia= ?, 
				caracteres_diagnosticos= ?, 
				uso= ?, 
				biotipo= ?, 
				habitat= ?, 
				distribucion= ?, 
				cat_UICN= ?, 
				floracion= ?, 
				foto_general= ?, 
				foto_flor= ?, 
				foto_hoja= ?, 
				foto_fruto= ?, 
				id_usuario= ?
				WHERE id_planta = ?
				";
				//echo $this->query;
				$this->execute_single_query("ssssssssssssssssii", $nombre_cientifico, $nombre_castellano, $nombre_valenciano, $nombre_ingles, $familia, $caracteres_diagnosticos, $uso, $biotipo, $habitat, $distribucion, $cat_UICN, $floracion, $foto_general, $foto_flor, $foto_hoja, $foto_fruto, $id_usuario, $id_planta);
				if ($this->error == "") //si no hay error
					$this->msg = 'Planta ' . $nombre_cientifico . ' modificada con éxito';
			} else {
				$this->msg = 'La planta ' . $this->nombre_cientifico . ' ya está registrada';
			}
		} else {
			$this->msg = 'No se ha modificado la planta';
		}
	}
	public function borrarFoto($id, $tipo)
	{
		$this->query = "
		UPDATE plantas
		SET " . $tipo . " = ''
		WHERE id_planta = ?
		";
		//echo $this->query;
		$this->execute_single_query("i", $id);
		if ($this->error == "") { //si no hay error
			$this->msg = 'Foto borrada con éxito';
		} else {
			$this->msg = 'No se ha borrado la foto';
		}
	}
	public function delete($id = '')
	{
		$this->query = "
		DELETE FROM plantas
		WHERE id_planta = ?
		";
		//echo $this->query;
		$this->execute_single_query("i", $id);
		if ($this->error == "") //si no hay error
			$this->msg = 'Planta ' . $id . ' eliminada con éxito';
	}
	function __destruct()
	{
		//unset($this);
	}
}
