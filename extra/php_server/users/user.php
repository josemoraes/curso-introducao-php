<?php
require 'encrypt.php';
class User {
	var $_id;
    var $tx_name;
    var $tx_email;
	var $tx_password;
	var $tx_token;

    function __construct($_id, $tx_name, $tx_email, $tx_password){
        $this->_id = $_id;
		
		if($tx_name == null || $tx_name == "")
			$this->tx_name = "";
		else
			$this->tx_name = $tx_name;
		
		$this->tx_email = $tx_email;
		$this->tx_password = $tx_password;
    }

	public function set_id($id){
		$this->_id = $id;
	}
	
    public function get_id(){
		return $this->_id;
	}
	
	public function set_name($name){
		$this->tx_name = $name;
	}
	
	public function get_name(){
		return $this->tx_name;
	}
	
	public function set_email($email){
		$this->tx_email = $email;
	}
	
	public function get_email(){
		return $this->tx_email;
	}
	
	// password
	public function set_password($pwd){
		$this->tx_password = $pwd;
	}
	
	public function get_password(){
		return $this->tx_password;
	}
	
	public function set_encrypted_password($pwd){
		$this->tx_password = encrypt_decrypt('encrypt', $pwd);
	}
	
	public function get_decrypted_password(){
		return encrypt_decrypt('decrypt', $this->tx_password);
	}
	
	// token
	public function set_token($tx_token){
		$this->tx_token = $tx_token;
	}
	
	public function get_token(){
		return $this->tx_token;
	}
	
	/**
	 * codifica o token utilizando o campo _id e a datetime atual
	 *
	 */
	public function set_encrypted_token(){
		$dt = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
		$token = $this->_id."?".$dt->getTimestamp();
		$this->tx_token = encrypt_decrypt('encrypt', $token);
	}
	
	/**
	 * decodifica o token
	 *
	 * @return array sendo [0] o ID do usuário e [1] o datetime da criação do token
	 */
	public function get_decrypted_token(){
		$t = encrypt_decrypt('decrypt', $this->tx_token);
		return explode("?", $t);
	}
}
?>