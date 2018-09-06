<?php
class DBManager {
	var $server_name;
	var $db_name;
    var $user_name;
    var $password;
	var $conn;
	
    function __construct() {
		$this->server_name = "localhost";
		$this->user_name = "root";
		$this->password = "";
		$this->db_name = "cursophp";
	}
	
	function __destruct() {
		$this->conn->close();
	}
	
	/**
	 * Tentará abrir uma conexão com o banco de dados, em caso de falha, invocará 
	 * o método "db_init" para criar as tabelas do banco.
	 *
	 * @return boolean representando o resultado da operação.
	 */
	public function db_connect(){
		// Cria uma conexão
		@$this->conn = new mysqli($this->server_name, $this->user_name, $this->password, $this->db_name);
		// Valida a conexão
		if ($this->conn->connect_error) {
			return $this->db_init();
		}else{
			return true;
		}
	}
	
	/**
	 * Cria a base de dados e as tabelas "Users" e "Taks".
	 *
	 * @return boolean representando o resultado da operação.
	 */
	public function db_init(){
		
		try{
			$this->conn = new mysqli($this->server_name, $this->user_name, $this->password);
			
			$sql = "CREATE DATABASE IF NOT EXISTS ".$this->db_name." CHARACTER SET utf8 COLLATE utf8_general_ci;";
			$this->conn->query($sql);
			@$this->conn->close();
			
			$this->conn = new mysqli($this->server_name, $this->user_name, $this->password, $this->db_name);
			$sql = "CREATE TABLE IF NOT EXISTS users (_id INTEGER(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, tx_name VARCHAR(35) CHARACTER SET utf8, tx_email VARCHAR(255) CHARACTER SET utf8 NOT NULL, tx_password TEXT CHARACTER SET utf8, tx_token TEXT CHARACTER SET utf8) CHARACTER SET utf8 COLLATE utf8_general_ci;"; 
			$this->conn->query($sql);
			$sql = "CREATE TABLE IF NOT EXISTS tasks(
				_id INTEGER(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
				tx_title VARCHAR(50) CHARACTER SET utf8, 
				tx_description TEXT CHARACTER SET utf8, 
				ch_tag CHAR(5) CHARACTER SET utf8, 
				dt_created DATETIME NOT NULL DEFAULT now(), 
				dt_deadline DATETIME NOT NULL, 
				id_user INTEGER(6) UNSIGNED NOT NULL, 
				FOREIGN KEY (id_user) REFERENCES users(_id) ON DELETE CASCADE ) CHARACTER SET utf8 COLLATE utf8_general_ci;";
			$this->conn->query($sql);
			
		}catch(Exception $e){
			var_dump($e->getMessage());
			return false;
		}

		return true;
	}
	
	public function db_exec_sql($sql){

		return $this->conn->query($sql);
	}
	
	public function get_servername(){
		return $this->servername;
	}
	
	public function get_username(){
		return $this->username;
	}
	
	public function get_password(){
		return $this->tx_password;
	}
}
?>