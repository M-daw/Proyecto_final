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
	public function get($id = '')
	{
		if ($id != '') {
			$this->query = "
			SELECT *
			FROM plantas
			WHERE id_planta = '$id'
			";
			$this->get_results_from_query();
		} else {
			$this->query = "
			SELECT *
			FROM plantas";
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
		//como el id_planta es autoincrementable, nunca se repetirá... no hace falta comprobar si existe
		foreach ($data as $campo => $valor) :
			$$campo = $valor;
		endforeach;
		$this->query = "
				INSERT INTO plantas
				(nombre_cientifico,nombre_castellano,nombre_valenciano,nombre_ingles,familia,caracteres_diagnosticos,uso,biotipo,habitat,distribucion,cat_UICN,floracion,foto_general,foto_flor,foto_hoja,foto_fruto,id_usuario)
				VALUES
				('$nombre_cientifico', '$nombre_castellano', '$nombre_valenciano', '$nombre_ingles', '$familia', '$caracteres_diagnosticos', '$uso', '$biotipo', '$habitat', '$distribucion', '$cat_UICN', '$floracion', '$foto_general', '$foto_flor', '$foto_hoja', '$foto_fruto', '$id_usuario')
				";
		//echo $this->query;
		$this->execute_single_query();
		if ($this->error == "") //si no hay error
			$this->msg = 'Planta ' . $nombre_cientifico . ' agregada con éxito';
	}
	public function edit($data = array())
	{
		foreach ($data as $campo => $valor) :
			$$campo = $valor;
		endforeach;
		$this->query = "
			UPDATE plantas
			SET nombre_cientifico='$nombre_cientifico',
			nombre_castellano='$nombre_castellano', 
			nombre_valenciano='$nombre_valenciano', 
			nombre_ingles='$nombre_ingles', 
			familia='$familia', 
			caracteres_diagnosticos='$caracteres_diagnosticos', 
			uso='$uso', 
			biotipo='$biotipo', 
			habitat='$habitat', 
			distribucion='$distribucion', 
			cat_UICN='$cat_UICN', 
			floracion='$floracion', 
			foto_general='$foto_general', 
			foto_flor='$foto_flor', 
			foto_hoja='$foto_hoja', 
			foto_fruto='$foto_fruto', 
			id_usuario='$id_usuario'
			WHERE id_planta = '$id_planta'
			";
			//echo $this->query;
		$this->execute_single_query();
		if ($this->error == "") //si no hay error
			$this->msg = 'Planta ' . $nombre_cientifico . ' modificada con éxito';
	}
	public function delete($id = '')
	{
		$this->query = "
		DELETE FROM plantas
		WHERE id_planta = '$id'
		";
		$this->execute_single_query();
		if ($this->error == "") //si no hay error
			$this->msg = 'Planta ' . $id . ' eliminada con éxito';
	}
	function __destruct()
	{
		//unset($this);
	}
}
