<?php

class Asignatura extends DBAbstractModel {
	
	public $id_asignatura;
	public $nom_asig;
	
	function __construct() {
		$this->db_name = 'matriculas';
		
	}
	public function get($id='') {
		if($id != ''){
			$this->query = "
			SELECT id_asignatura,nom_asig
			FROM asignaturas
			WHERE id_asignatura = '$id'
			";
			$this->get_results_from_query();
		}
		else{
			$this->query = "
			SELECT id_asignatura,nom_asig
			FROM asignaturas";
			$this->get_results_from_query();
		}
		if(count($this->rows) == 1):
			foreach ($this->rows[0] as $propiedad=>$valor):
				$this->$propiedad = $valor;
			endforeach;
		endif;
	}
	public function get_asig_faltan($id_alu){
		if($id_alu != ''){
			$this->query = "
			SELECT *
			FROM asignaturas
			WHERE id_asignatura not in( 
				select id_asignatura from matricula where id_alumno = $id_alu)
			";
			$this->get_results_from_query();
		}
		else{
			$this->query = "
			SELECT *
			FROM asignaturas";
			$this->get_results_from_query();
		}
	}
	
	public function set($data=array()) {
		if(array_key_exists('id_asignatura', $data)){
			$this->get($data['id_asignatura']); //por si existe, no crearlo de nuevo
			
			if($data['id_asignatura'] != $this->id_asignatura){
				foreach ($data as $campo=>$valor):
					$$campo = $valor;
				endforeach;
				$this->query = "
				INSERT INTO asignaturas
				(id_asignatura,nom_asig)
				VALUES
				('$id_asignatura', '$nom_asig')
				";
				$this->execute_single_query();
			}
		}
	}
	public function edit($data=array()) {
		foreach ($data as $campo=>$valor):
			$$campo = $valor;
		endforeach;
		$this->query = "
			UPDATE asignaturas
			SET nom_asig='$nom_asig'
			WHERE id_asignatura = '$id_asignatura'
			";
		$this->execute_single_query();
		}
	public function delete($id='') {
		$this->query = "
		DELETE FROM asignaturas
		WHERE id_asignatura = '$id'
		";
		$this->execute_single_query();
	}
	function __destruct() {
		//unset($this);
	}
}
?>