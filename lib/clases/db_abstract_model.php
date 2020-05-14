<?php
abstract class DBAbstractModel
{
	# se cambian los atributos relacionados con los datos del servidor para que se cojan desde un archivo. 
	# Se añaden setters para modificarlos desde las clases que heredab de DBAstractModel
	private static $db_host;
	private static $db_user;
	private static $db_pass;
	private static $db_name;
	#resto de atributos se dejan como en el modelo
	protected $query;
	protected $rows = array();
	private $conn;
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
		//se cambia el constructor porque $db_name es privado, y se añade el set_charset() por problemas en al codificación en el servidor
		$this->conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, self::$db_name);
		$this->conn->set_charset("utf8"); //solo es necesario en el host, en local coge bien los acentos
	}
	# Desconectar la base de datos
	private function close_connection()
	{
		$this->conn->close();
	}
	# Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
	protected function execute_single_query($params = null, $valor1 = null, $valor2 = null, $valor3 = null, $valor4 = null, $valor5 = null, $valor6 = null, $valor7 = null, $valor8 = null, $valor9 = null, $valor10 = null, $valor11 = null, $valor12 = null, $valor13 = null, $valor14 = null, $valor15 = null, $valor16 = null, $valor17 = null, $valor18 = null)
	{
		//modificación para poder usar esta función con sentencias preparadas. Como máximo paso 18 argumentos + la cadena indicando el tipo de parámetro a unir en el bind_param() en estas funciones. Si no se pasa ningún parametro se mantiene función original
		$this->open_connection();

		//voy a usar la función func_num_args() para saber cuántos argumentos me están pasando
		$numargs = func_num_args();

		if ($numargs == 0) {
			$this->conn->query($this->query);  //sin sentencias preparadas
		} else {
			$stmt = $this->conn->prepare($this->query); //con sentencias preparadas. El bind_params() posterior va a depender de cuántos parámetros le paso. No se va a usar sin parámetros pero se deja preparado.
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
	protected function get_results_from_query($params = null, $valor1 = null)
	{
		//modificación para poder usar esta función con sentencias preparadas. Como máximo paso 18 argumentos + la cadena indicando el tipo de parámetro a unir en el bind_param() en estas funciones.
		$this->open_connection();
		$numargs = func_num_args();
		//echo $numargs;
		if ($numargs == 0) {
			$result = $this->conn->query($this->query);  //sin sentencias preparadas
		} else {
			$stmt = $this->conn->prepare($this->query); //con sentencias preparadas. Esta función se va a usar sin parámetros, y con un argumento + a cadena indicando el tipo de parámetro.
			$stmt->bind_param($params, $valor1);

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
		} else {
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

	/**
	 * Setter para db_host
	 */
	public function setDb_host($db_host)
	{
		self::$db_host = $db_host;
	}

	/**
	 * Setter para db_user
	 */
	public function setDb_user($db_user)
	{
		self::$db_user = $db_user;
	}

	/**
	 * Setter para db_pass
	 */
	public function setDb_pass($db_pass)
	{
		self::$db_pass = $db_pass;
	}

	/**
	 * Setter para db_name
	 */
	public function setDb_name($db_name)
	{
		self::$db_name = $db_name;
	}
}
