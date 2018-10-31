<?php 
include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição


$dadosDoFormulario 	= $_POST; 

$serverRequest 		= new Request('http://localhost/php_server/login/');

$resposta 			= $serverRequest->doPost($dadosDoFormulario);

switch ($resposta['code']) {
	case 200:
		$dados = $resposta['result'];
		session_start(); # Inicializo a sessão
		$_SESSION['user']['tx_token'] 	= $dados->tx_token;
		$_SESSION['user']['tx_name'] 	= $dados->tx_name;
		$_SESSION['user']['tx_email'] 	= $dados->tx_email;

		header('Location: http://localhost/app-curso/dashboard.php');
		break;
	
	case 401:
		$dados = $resposta['result'];
		header('Location: http://localhost/app-curso/index.php?msg='.$dados->tx_message.'');
		break;
	default:
		header('Location: http://localhost/app-curso/');
		break;
}
