<?php 
include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição


$dadosDoFormulario 	= $_POST; 
$serverRequest 		= new Request('http://localhost/php_server/users/');

$resposta 			= $serverRequest->doPost($dadosDoFormulario);

header('Location: http://localhost/php_server/index.php?msg='.$resposta['result']->tx_message.'');