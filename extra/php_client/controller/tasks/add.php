<?php 
date_default_timezone_set ('America/Sao_Paulo'); # Configuro o fuso horário padrão
session_start();
include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição

$serverRequest 		= new Request('http://appserver.local/tasks/', $_SESSION['user']['tx_token']);
# Capturo as informações enviadas pelo formulário
$dadosDoFormulario 	= $_POST; 
# Converto a data para o formato que o banco de dados espera, conforme documentação
$prazo 				= new DateTime($dadosDoFormulario['dt_deadline']);
$prazo 				= $prazo->format('d-m-Y H:i:s');
$dadosDoFormulario['dt_deadline'] = strtotime($prazo);

$resposta 			= $serverRequest->doPost($dadosDoFormulario);

switch ($resposta['code']) {
	case 200:
		header('Location: http://appcurso.local/dashboard.php?msg=Tarefa criado com sucesso!');
		break;
	
	default:
		header('Location: http://appcurso.local/dashboard.php?msg='.$resposta['result']->tx_message.'');		
		break;
}