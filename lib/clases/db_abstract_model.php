<?php
abstract class DBAbstractModel
{
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
	//private $conn;
	protected $conn; //era private
	public $error = "";
	public $msg = "";
	# métodos abstractos para ABM de clases que hereden
	abstract protected function get();
	abstract protected function set();
	abstract protected function edit();
	abstract protected function delete();
	# los siguientes métodos pueden definirse con exactitud
	# y no son abstractos
	# Conectar a la base de datos
	private function open_connection()
	{
		//$this->conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, $this->db_name);
		$this->conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$this->conn ->set_charset("utf8"); //solo es necesario en el host, en local coge bien los acentos
	}
	# Desconectar la base de datos
	private function close_connection()
	{
		$this->conn->close();
	}
	# Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
	//protected function execute_single_query() {  //función original, sin sentencias preparadas. No lleva parámetros
	protected function execute_single_query($params = null, $valor1 = null, $valor2 = null, $valor3 = null, $valor4 = null, $valor5 = null, $valor6 = null, $valor7 = null, $valor8 = null, $valor9 = null, $valor10 = null, $valor11 = null, $valor12 = null, $valor13 = null, $valor14 = null, $valor15 = null, $valor16 = null, $valor17 = null, $valor18 = null)
	{
		//modificación para poder usar esta función con sentencias preparadas. Como máximo paso 18 argumentos + la cadena indicando el tipo de parámetro a unir en el bind_param() en estas funciones. Si no se pasa ningún parametro se mantiene función original
		$this->open_connection();
		$numargs = func_num_args();
	
		if ($numargs == 0) {
			$result = $this->conn->query($this->query);  //sin sentencias preparadas
		} else {
			$stmt = $this->conn->prepare($this->query); //con sentencias preparadas. El bind_params() `posterior va a depender de cuántos parámetros le paso. No se va a usar sin parámetros pero se deja preparado.
			if ($numargs >= 3) {
				if ($numargs >= 4) {
					if ($numargs >= 5) {
						if ($numargs >= 6) {
							if ($numargs >= 18) {
								if ($numargs >= 19) {
									$stmt->bind_param($params, $valor1, $valor2, $valor3, $valor4, $valor5, $valor6, $valor7, $valor8, $valor9, $valor10, $valor11, $valor12, $valor13, $valor14, $valor15, $valor16, $valor17, $valor18);
								} else {
									$stmt->bind_param($params, $valor1, $valor2, $valor3, $valor4, $valor5, $valor6, $valor7, $valor8, $valor9, $valor10, $valor11, $valor12, $valor13, $valor14, $valor15, $valor16, $valor17);
								}
							} else {
								$stmt->bind_param($params, $valor1, $valor2, $valor3, $valor4, $valor5);
							}
						} else {
							$stmt->bind_param($params, $valor1, $valor2, $valor3, $valor4);
						}
					} else {
						$stmt->bind_param($params, $valor1, $valor2, $valor3);
					}
				} else {
					$stmt->bind_param($params, $valor1, $valor2);
				}
			} else {
				$stmt->bind_param($params, $valor1);
			}

			$stmt->execute();
			$stmt->store_result();
			while ($this->rows[] = fetchAssocStatement($stmt));
			$stmt->close();
		} //fin else

		if ($this->conn->errno > 0) {
			$this->error .= "Error: La ejecución de la consulta falló debido a: \n";
			$this->error .= "Query: " . $this->query . "\n";
			$this->error .= $this->conn->errno . "\n";
			$this->error .= $this->conn->error . "\n";
		}
		$this->close_connection();
	}
	# Traer resultados de una consulta en un Array
	//protected function get_results_from_query() { //función original, sin sentencias preparadas. No lleva parámetros
	protected function get_results_from_query($params = null, $valor1 = null, $valor2 = null, $valor3 = null, $valor4 = null, $valor5 = null, $valor6 = null, $valor7 = null, $valor8 = null, $valor9 = null, $valor10 = null, $valor11 = null, $valor12 = null, $valor13 = null, $valor14 = null, $valor15 = null, $valor16 = null, $valor17 = null, $valor18 = null)
	{
		//modificación para poder usar esta función con sentencias preparadas. Como máximo paso 18 argumentos + la cadena indicando el tipo de parámetro a unir en el bind_param() en estas funciones.
		$this->open_connection();

		if ($params == null) {
			$result = $this->conn->query($this->query);
		} else {
			$stmt = $this->conn->prepare($this->query);

			if ($valor2 != null) {
				if ($valor3 != null) {
					if ($valor4 != null) {
						if ($valor5 != null) {
							if ($valor17 != null) {
								if ($valor18 != null) {
									$stmt->bind_param($params, $valor1, $valor2, $valor3, $valor4, $valor5, $valor6, $valor7, $valor8, $valor9, $valor10, $valor11, $valor12, $valor13, $valor14, $valor15, $valor16, $valor17, $valor18);
								} else {
									$stmt->bind_param($params, $valor1, $valor2, $valor3, $valor4, $valor5, $valor6, $valor7, $valor8, $valor9, $valor10, $valor11, $valor12, $valor13, $valor14, $valor15, $valor16, $valor17);
								}
							} else {
								$stmt->bind_param($params, $valor1, $valor2, $valor3, $valor4, $valor5);
							}
						} else {
							$stmt->bind_param($params, $valor1, $valor2, $valor3, $valor4);
						}
					} else {
						$stmt->bind_param($params, $valor1, $valor2, $valor3);
					}
				} else {
					$stmt->bind_param($params, $valor1, $valor2);
				}
			} else {
				$stmt->bind_param($params, $valor1);
			}

			$stmt->execute();
			//$result = $stmt->get_result(); //necesita que esté instalado la extensión mysqlnd.dll. En local funciona, en mi host no.
			$stmt->store_result();  //en lugar de get_result() hago un store_result() sobre $stmt
		} //fin else

		if ($this->conn->errno > 0) {
			$this->error .= "Error: La ejecución de la consulta falló debido a: \n";
			$this->error .= "Query: " . $this->query . "\n";
			$this->error .= $this->conn->errno . "\n";
			$this->error .= $this->conn->error . "\n";
		}
		if (isset($result)) {
			while ($this->rows[] = $result->fetch_assoc());
			$result->close();
		} else{
			while ($this->rows[] = fetchAssocStatement($stmt));
			$stmt->close();
		}

		$this->close_connection();
		array_pop($this->rows); /*elimina el false del último fetch_assoc, cuando ya no encuentra más resultados*/
	}
	public function get_rows()
	{
		return $this->rows;
	}

	###### Método para recoger los valores de los enum de la BD #####
	public function getSQLEnumArray($table, $field)
	{
		$this->query = "SHOW COLUMNS FROM " . $table . " LIKE '" . $field . "'";
		//echo $this->query;
		$this->open_connection();
		$row = $this->conn->query($this->query)->fetch_assoc();
		preg_match_all("/'(.*?)'/", $row['Type'], $categories);
		$fields = $categories[1];
		$this->close_connection();
		return $fields;
	}


	# copia de los métodos antes de usar sentencias preparadas

	protected function execute_single_query1()
	{
		$this->open_connection();
		$this->conn->query($this->query);


		if ($this->conn->errno > 0) {
			$this->error .= "Error: La ejecución de la consulta falló debido a: \n";
			$this->error .= "Query: " . $this->query . "\n";
			$this->error .= $this->conn->errno . "\n";
			$this->error .= $this->conn->error . "\n";
		}
		$this->close_connection();
	}
	protected function get_results_from_query1()
	{
		$this->open_connection();

		$result = $this->conn->query($this->query);

		if ($this->conn->errno > 0) {
			$this->error .= "Error: La ejecución de la consulta falló debido a: \n";
			$this->error .= "Query: " . $this->query . "\n";
			$this->error .= $this->conn->errno . "\n";
			$this->error .= $this->conn->error . "\n";
		}
		while ($this->rows[] = $result->fetch_assoc());
		$result->close();
		$this->close_connection();
		array_pop($this->rows); /*elimina el false del último fetch_assoc, cuando ya no encuentra más resultados*/
	}
}
