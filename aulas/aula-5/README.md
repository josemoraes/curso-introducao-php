# Desenvolvimento do Projeto

Para essa etapa, está previsto o desenvolvimento dos seguintes requisitos:
1. Desenvolver o cadastro de tarefas;
2. Listar as tarefas;
3. Desenvolver o mecanismo de exclusão de tarefas.

Nesse sentido, cabe aqui revisar alguns tópicos importantes antes de iniciarmos a programação do primeiro requisito:

## Introdução

Nosso cenário de desenvolvimento é muito parecido com o que ocorre no mercado: O programador não tem a autonomia (por questões de complexidade e custo) de desenvolver o sistema como um todo, e portanto, precisa realizar seu trabalho em conjunto com outros programadores.
Neste curso, supomos a existência de uma API responsável por gerenciar as regras de negócio da aplicação; e para nós ficou o trabalho de desenvolver um sistema que consuma os recursos dessa API, que aqui se refere à um gerenciador de tarefas pessoais no formato Kanban.
Nosso servidor estará hospedado em `http://localhots/php_server/`.
Para ter o servidor na sua máquina local, acesse a pasta `extra` e faça o download de todo o diretório `php_server` na pasta `htdocs`.

Para ter a base da nossa aplicação no client-side, acesse a pasta `extra` e baixe o diretório `php_client` na `htdocs`. Renomeie esse diretório para `app-curso`.

> Para executar ambas as aplicações é necessário inicializar o Apache e o Mysql pelo Xampp.

## Desenvolvimento

A partir daqui, assumimos que o ambiente está devidamente configurado e podemos começar a cumprir os requisitos dessa aula.


### Cadastro de Tarefas

Como já temos a base de layout, vamos focar na implementação em PHP. Para o cadastro, utilizamos a classe `Request.php` que é responsável por resolver as questões de requisição. Sendo assim, abra o arquivo `controller/tasks/add.php`.

``` php
<?php 

include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição


$dadosDoFormulario 	= $_POST; 
$serverRequest 		= new Request('http://localhost/php_server/tasks/'); # Essa URL é definida pelo documento descritor da API

$resposta 			= $serverRequest->doPost($dadosDoFormulario);

header('Location: http://app-curso/dashboard.php?msg='.$resposta['result']->tx_message.'');

``` 

Veja que a implementação da classe `Request.php`, simplificou este tipo de operação à poucas linhas de código. Isso acontece, porque a reutilização de código é um dos benefícios da Orientação à Objeto (OO). Não podemos assumir que nossa aplicação faz uso pleno desse paradigma, pois ele prevê uso de inúmeros recursos para que OO seja devidamente implementado. Por outro lado, utilizamos alguns de seus conceitos - coerência e encapsulamento - para manter operações de requisição sendo responsabilidade de uma única classe. Vamos explorar o código do método `doPost`.

``` php

public function doPost($data)
{
	$fields = http_build_query($data);

	//Abre a conexão
	$ch = curl_init();

	//Configura o cabeçalho da requisição
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_URL,$this->url);
	curl_setopt($ch,CURLOPT_POST,count($data));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);

	
	$result['result'] 	= curl_exec($ch); //Executa a requisição
	$result['code']		= curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch); //Fecha a conexão
	
	return $result;
}

``` 
Observe que ela abre o contexto de comunicação, e executa toda a operação de request; em seguida retorna como resultado um array com os campos `result` (que possui o retorno da API) e `code` (que é o código de status da resposta).

### Listar as tarefas

Para entender como requisitar as tarefas de um usuário no servidor, precisamos consultar o [documento descritor da API](/extra/documento-descritor-api.pdf).

Segundo o documento, devemos enviar um `token` configurado no header para o endereço `/tasks/`.
Como desejamos 'imprimir' os cartões de tarefas na página de dashboard, temos duas alternativas:
1. Realizamos a requisição direto nessa página; ou
2. Criamos um objeto que nos retorna esses valores.

Para efeitos de código mais organizado, vamos seguir pelo caminho da segunda opção.