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
		require '../users/user.php';
		
		if(
			(isset($_POST["tx_email"]) && !empty($_POST["tx_email"])) &&
			(isset($_POST["tx_password"]) && !empty($_POST["tx_password"]))
		){
			$post_pwd = $_POST["tx_password"];
			$n_reg = new User("", "", $_POST["tx_email"], "");
			//$n_reg->set_encrypted_password($_POST["tx_password"]);
			
			include_once '../DBManager.php';
			$dbm = new DBManager();
			if($dbm->db_connect()){
				$sql = " SELECT * FROM users WHERE tx_email='".$n_reg->get_email()."' LIMIT 1";
				$result_q = $dbm->db_exec_sql($sql);
				if ($result_q->num_rows > 0) {
					$row = mysqli_fetch_assoc($result_q);
					
					$n_reg->set_password($row["tx_password"]);
					
					if($n_reg->get_decrypted_password() === $post_pwd){
						$n_reg->set_id($row["_id"]);
						$n_reg->set_name($row["tx_name"]);
						$n_reg->set_email($row["tx_email"]);
						$n_reg->set_encrypted_token();
						
						header($R_200);
						$result = '{
							"tx_token": "'.$n_reg->get_token().'",
							"tx_email": "'.$n_reg->get_email().'",
							"tx_name": "'.$n_reg->get_name().'"
						}';
					}else{
						header($R_401);
						$result = '{ "tx_message": "'.$DB_ERR_LOGIN_PWD.'" }';
					}
				}else{
					header($R_401);
					$result = '{ "tx_message": "'.$DB_ERR_LOGIN_EMAIL.'" }';
				}
			}else{
				header($R_401);
				$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
			}
		}else{
			header($R_401);
			$result = '{ "tx_message": "'.$DB_ERR_INS_VAL.'E-mail e Senha." }';
		}
		
		return $result;
	}
?>