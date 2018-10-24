<?php
	// Define o "Content-Type" nos headers do response
	header('Content-Type: application/json; charset=utf-8');
	// Variáveis Gerais
	require '../Miscellaneous.php';
	// Acessa o método de requisição informado
	$method = $_SERVER['REQUEST_METHOD'];
	
	// para cada método, um conjunto de ações 
	switch($method)
	{
		case 'GET':
			$result = request_get();
			break;
		case 'POST':
			$result = request_post();
			break;
		case 'PUT':
			$result = request_put();
			break;
		case 'DELETE':
			$result = request_delete();
			break;
		default:
			header($R_405);
			$result = '{ "tx_message": "'.$ERR_405.'"}';
	}
	
	echo($result);

	function request_post(){
		require '../Miscellaneous.php';
		require './task.php';
		require '../login/auth.php';
		
		// acessa os Headers da requisição
		$headers = apache_request_headers();
		
		// valida o token
		if(!isset($headers["token"]) || empty($headers["token"])){
			header($R_400);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}

		$user = check_auth($headers["token"]);
		if(!$user){
			header($R_401);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}

		// valida e insere os dados no banco
		if(
			(isset($_POST["tx_title"]) && !empty($_POST["tx_title"])) &&
			(isset($_POST["ch_tag"]) && !empty($_POST["ch_tag"])) &&
			(isset($_POST["dt_deadline"]) && !empty($_POST["dt_deadline"]))
		){
			$n_reg = new Task("", $_POST["tx_title"], $_POST["tx_description"], $_POST["ch_tag"], "", $_POST["dt_deadline"]);
			$n_reg->set_dt_deadline_from_l( $n_reg->get_dt_deadline() );
			
			include_once '../DBManager.php';
			$dbm = new DBManager();
			if($dbm->db_connect()){
				$sql = "INSERT INTO tasks (tx_title, tx_description, ch_tag, dt_deadline, id_user) VALUES ('".$n_reg->get_title()."', '".$n_reg->get_description()."', '".$n_reg->get_ch_tag()."', '".$n_reg->get_dt_deadline()."', '".$user->get_id()."')";
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
			$result = '{ "tx_message": "'.$DB_ERR_INS_VAL.'Título, Status e Prazo." }';
		}
		
		return $result;
	}
	
	function request_get(){
		require '../Miscellaneous.php';
		require './task.php';
		require '../login/auth.php';
		
		// acessa os Headers da requisição
		$headers = apache_request_headers();
		
		// valida o token
		if(!isset($headers["token"]) || empty($headers["token"])){
			header($R_400);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}
		
		$user = check_auth($headers["token"]);
		if(!$user){
			header($R_401);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}

		include_once '../DBManager.php';
		$dbm = new DBManager();
		if($dbm->db_connect()){
			$sql = "SELECT * FROM tasks WHERE id_user='".$user->get_id()."'";
			$db_res = $dbm->db_exec_sql($sql);

			if ($db_res->num_rows > 0) {
				$result = '[';
				while($row = $db_res->fetch_assoc()) {
					$dt_c = strtotime($row["dt_created"]);
					$dt_d = strtotime($row["dt_deadline"]);
					$result .= '{ "_id": "'.$row["_id"].'", "tx_title": "'.$row["tx_title"].'", "tx_description": "'.$row["tx_description"].'", "ch_tag": "'.$row["ch_tag"].'", "dt_created": "'.$dt_c.'", "dt_deadline": "'.$dt_d.'" },';
				}
				$result = substr($result, 0, -1);
				$result .= ']';
				header($R_200);
			} else {
				$result = '{ "tx_message": "'.$DB_SUC_GET_EMP.'" }';
				header($R_200);
			}
		}else{
			header($R_401);
			$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
		}
		
		return $result;
	}
	
	function request_delete(){
		require '../Miscellaneous.php';
		require './task.php';
		require '../login/auth.php';
		
		// acessa os Headers da requisição
		$headers = apache_request_headers();
		
		// valida o token
		if(!isset($headers["token"]) || empty($headers["token"])){
			header($R_400);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}
		
		$user = check_auth($headers["token"]);
		if(!$user){
			header($R_401);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}
		
		$u_reg = new Task("", "", "", "", "", "");
		if((!isset($_GET['id_task']) || empty($_GET['id_task']))){
			header($R_400);
			$result = '{ "tx_message": "'.$ERR_400.'" }';
			return $result;
		}
		
		$u_reg->set_id($_GET['id_task']);
		
		include_once '../DBManager.php';
		$dbm = new DBManager();
		if($dbm->db_connect()){
			$sql = "DELETE FROM tasks WHERE _id='".$u_reg->get_id()."'";
		
			if($dbm->db_exec_sql($sql)){
				header($R_200);
				$result = '{ "tx_message": "'.$DB_SUC_DEL.'" }';
			}else{
				header($R_401);
				$result = '{ "tx_message": "'.$DB_ERR_DEL.'" }';
			}
		}else{
			header($R_401);
			$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
		}
		
		return $result;
	}
	
	function request_put(){
		require '../Miscellaneous.php';
		require './task.php';
		require '../login/auth.php';
		
		// acessa os Headers da requisição
		$headers = apache_request_headers();
		parse_str(file_get_contents("php://input"), $put_params);
		
		// valida o token
		if(!isset($headers["token"]) || empty($headers["token"])){
			header($R_400);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}
		
		$user = check_auth($headers["token"]);
		if(!$user){
			header($R_401);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}
		
		$u_reg = new Task("", "", "", "", "", "");
		if((!isset($put_params['id_task']) || empty($put_params['id_task']))){
			header($R_400);
			$result = '{ "tx_message": "'.$ERR_400.'" }';
			return $result;
		}
		
		$u_reg->set_id($put_params['id_task']);

		if(isset($put_params['ch_tag']) && !empty($put_params['ch_tag'])){
			$u_reg->set_ch_tag($put_params['ch_tag']);
		}

		if(isset($put_params['dt_deadline']) && !empty($put_params['dt_deadline'])){
			$u_reg->set_dt_deadline_from_l($put_params['ch_tag']);
		}
		
		include_once '../DBManager.php';
		$dbm = new DBManager();
		if($dbm->db_connect()){
			$sql = "UPDATE tasks SET";
			
			if($u_reg->get_ch_tag() == "" || $u_reg->get_dt_deadline() == ""){
				header($R_400);
				$result = '{ "tx_message": "'.$DB_ERR_UP_VAL.' Status ou Prazo" }';
				return $result;
			}
			
			if($u_reg->get_ch_tag() != "" && $u_reg->get_ch_tag() == $put_params['ch_tag']){
				$sql .= " ch_tag='".$u_reg->get_ch_tag()."'";
				if($u_reg->get_dt_deadline() != "")
					$sql .= ",";
			}
			
			if($u_reg->get_dt_deadline() != ""){
				$sql .= " dt_deadline='".$u_reg->get_dt_deadline()."'";
			}
			
			$sql .= " WHERE _id='".$u_reg->get_id()."'";
		
			if($dbm->db_exec_sql($sql)){
				header($R_200);
				$result = '{ "tx_message": "'.$DB_SUC_UP.'" }';
			}else{
				header($R_401);
				$result = '{ "tx_message": "'.$DB_ERR_UP.'" }';
			}
		}else{
			header($R_401);
			$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
		}
		
		return $result;
	}
?>
