<?php
	// Define o "Content-Type" nos headers do response
	header('Content-Type: application/json');
	// Variáveis Gerais
	require '../Miscellaneous.php';
	// Acessa o método de requisição informado
	$method = $_SERVER['REQUEST_METHOD'];
	
	// para cada método, um conjunto de ações 
	switch($method)
	{
		case 'POST':
			$result = request_post();
			break;
		/*case 'GET':
			$result = '{ "tx_message": "GET"}';
			break;*/
		default:
			header($R_405);
			$result = '{ "tx_message": "'.$ERR_405.'"}';
	}
	
	echo($result);

	function request_post(){
		require '../Miscellaneous.php';
		require './user.php';
		
		if(
			(isset($_POST["tx_email"]) && !empty($_POST["tx_email"])) &&
			(isset($_POST["tx_password"]) && !empty($_POST["tx_password"]))
		){
			$n_reg = new User("", $_POST["tx_name"], $_POST["tx_email"], "");
			$n_reg->set_encrypted_password($_POST["tx_password"]);
			
			include_once '../DBManager.php';
			$dbm = new DBManager();
			if($dbm->db_connect()){
				$sql = "INSERT INTO users (tx_name, tx_email, tx_password, tx_token) VALUES ('".$n_reg->get_name()."', '".$n_reg->get_email()."', '".$n_reg->get_password()."', 'null')";
				$result = $dbm->db_exec_sql($sql);
				if($result == "1" || $result == 1){
					header($R_200);
					$result = '{ "tx_message": "'.$DB_SUC_INS.'" }';
				}else{
					header($R_401);
					$result = '{ "tx_message": "'.$DB_ERR_INS.'" }';
				}
			}else{
				header($R_401);
				$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
			}
		}else{
			header($R_400);
			$result = '{ "tx_message": "'.$DB_ERR_INS_VAL.'E-mail e Senha." }';
		}
		
		return $result;
	}
?>