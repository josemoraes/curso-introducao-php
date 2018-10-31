<?php 
session_start();
include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição

$serverRequest 		= new Request('http://appserver.local/tasks/', $_SESSION['user']['tx_token']);

$resposta 			= $serverRequest->doDelete($_POST);

switch ($resposta['code']) {
	case 200:
		header('Location: http://appcurso.local/dashboard.php?msg=Tarefa excluída com sucesso!');
		break;
	
	default:
		header('Location: http://appcurso.local/dashboard.php?msg='.$resposta['result']->tx_message.'');		
		break;
}