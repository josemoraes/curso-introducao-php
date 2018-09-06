<?php
	require '../users/user.php';
	
	function check_auth($token){
		$user_auth = new User("", "", "", "");
		$user_auth->set_token($token);
		
		$decrypted = $user_auth->get_decrypted_token();
		$user_auth->set_id($decrypted[0]);
		
		$dt_current = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
		$dt_from_token  = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
		@$dt_from_token->setTimestamp($decrypted[1]);
		
		$diff = $dt_from_token->diff( $dt_current );
		//$hours = $diff->format('%y ano(s), %m mês(s), %d dia(s), %H hora(s), %i minuto(s) e %s segundo(s)')
		
		if($diff->i <= 20){
			return $user_auth;
		}else{
			return false;
		}
	}
?>