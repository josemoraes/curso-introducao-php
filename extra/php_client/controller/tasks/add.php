<?php 
session_start();
include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição


$dadosDoFormulario 	= $_POST; 
$serverRequest 		= new Request('http://appserver.local/tasks/');

$resposta 			= $serverRequest->doPost($dadosDoFormulario);

switch ($resposta['code']) {
	case 200:
		$_SESSION['user']['tx_token'] = $resposta['result']->tx_token; # Atualizo o token de acesso à plataforma
		header('Location: http://appcurso.local/dashboard.php?msg=Tarefa criado com sucesso!');
		break;
	
	default:
		header('Location: http://appcurso.local/dashboard.php?msg='.$resposta['result']->tx_message.'');		
		break;
}