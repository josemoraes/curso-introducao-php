<?php 
include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição


$dadosDoFormulario 	= $_POST; 
$serverRequest 		= new Request('http://appserver.local/users/');

$resposta 			= $serverRequest->doPost($dadosDoFormulario);

header('Location: http://appcurso.local/index.php?msg='.$resposta['result']->tx_message.'');