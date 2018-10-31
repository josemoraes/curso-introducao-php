<?php 
include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição


$dadosDoFormulario 	= $_POST; 
$serverRequest 		= new Request('http://localhost/php_server/users/');

$resposta 			= $serverRequest->doPost($dadosDoFormulario)['result'];

header('Location: http://localhost/app-curso/index.php?msg='.$resposta->tx_message);