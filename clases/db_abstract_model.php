<?php
abstract class DBAbstractModel {
	/* private static $db_host = 'localhost';
	private static $db_user = 'root';
	private static $db_pass = '';
	protected $db_name = 'herbariodb'; */
	# se cambian los atributos relacionados con los datos del servidor para que sean protected 
	# y se puedan modificar desde la clases que heredan el modelo con un archivo de configuración
	protected $db_host;
	protected $db_user;
	protected $db_pass;
	protected $db_name;
	protected $query;
	protected $rows = array();
	private $conn;
	public $error="";
	public $msg="";
	# métodos abstractos para ABM de clases que hereden
	abstract protected function get();
	abstract protected function set();
	abstract protected function edit();
	abstract protected function delete();
	# los siguientes métodos pueden definirse con exactitud
	# y no son abstractos
	# Conectar a la base de datos
	private function open_connection() {
		//$this->conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, $this->db_name);
		$this->conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
	}
	# Desconectar la base de datos
	private function close_connection() {
		$this->conn->close();
	}
	# Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
	protected function execute_single_query() {
		$this->open_connection();
		$this->conn->query($this->query);
		if ($this->conn->errno>0) { 
			$this->error.="Error: La ejecución de la consulta falló debido a: \n"; 
			$this->error.= "Query: " . $this->query ."\n"; 
			$this->error.= $this->conn->errno . "\n"; 
			$this->error.= $this->conn->error . "\n"; 
		}
		$this->close_connection();
	}
	# Traer resultados de una consulta en un Array
	protected function get_results_from_query() {
		$this->open_connection();
		$result = $this->conn->query($this->query);
		if ($this->conn->errno>0) { 
			$this->error.="Error: La ejecución de la consulta falló debido a: \n"; 
			$this->error.= "Query: " . $this->query ."\n"; 
			$this->error.= $this->conn->errno . "\n"; 
			$this->error.= $this->conn->error . "\n"; 
		}
		while ($this->rows[] = $result->fetch_assoc());
		$result->close();
		$this->close_connection();
		array_pop($this->rows); /*elimina el false del último fetch_assoc, cuando ya no encuentra más resultados*/
	}
	public function get_rows(){
		return $this->rows;
	}

	###### Método para recoger los valores de los enum de la BD #####
	public function getSQLEnumArray($table, $field){
		$this->query = "SHOW COLUMNS FROM ".$table." LIKE '".$field ."'";
		//echo $this->query;
		$this->open_connection();
		$row = $this->conn->query($this->query)->fetch_assoc();
		preg_match_all("/'(.*?)'/", $row['Type'], $categories);
		$fields = $categories[1];
		$this->close_connection();
		return $fields;
	}

}
