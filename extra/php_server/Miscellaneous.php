<?php
	// HEADHERS
	$R_400 = "HTTP/1.0 400 Bad Request";
	$R_401 = "HTTP/1.0 401 Unauthorized";
	$R_405 = "HTTP/1.0 405 Method Not Allowed";
	$R_200 = "HTTP/1.0 200 OK";

	// Request Messages
	$ERR_405 = "Solicitação de recurso não permitido pelo servidor.";
	$ERR_400 = "Parâmetros inválidos.";

	// DB Messages
	$DB_ERR_CONN = "Erro ao tentar se conectar com o banco de dados.";
	$DB_ERR_INIT = "Houve um erro ao tentar criar o banco e suas tabelas. Por favor, verifique se o ambiente de desenvolvimento está preparado.";
	$DB_ERR_INS = "Erro ao tentar incluir um novo registro. Por favor, tente novamente.";
	$DB_ERR_INS_VAL = "Os seguintes campos são obrigatórios: ";
	$DB_ERR_UP_VAL = "Pelo menos um destes campos deve ser preenchido: ";
	$DB_SUC_INS = "Registro inserido com sucesso!";
	$DB_ERR_LOGIN_EMAIL = "E-mail não encontrado em nossa base de dados.";
	$DB_ERR_LOGIN_PWD = "Senha informada não está correta. Por favor, tente novamente.";
	
	$DB_ERR_UP = "Erro ao tentar atualizar o registro. Por favor, tente novamente.";
	$DB_SUC_UP = "Registro atualizado com sucesso!";
	
	$DB_ERR_DEL = "Erro ao tentar excluir o registro. Por favor, tente novamente.";
	$DB_SUC_DEL = "Registro excluído com sucesso!";
	
	$SESS_ERR_TOKEN = "Seu login expirou. Efetue o login novamente para continuar.";

	$DB_SUC_GET_EMP = "Nenhum registro encontrado.";
?>

