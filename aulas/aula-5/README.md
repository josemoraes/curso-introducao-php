# Aula 5 - Desenvolvimento do Projeto (client-side)

Para essa etapa, está previsto o desenvolvimento dos seguintes requisitos:
1. Desenvolver o cadastro de usuários; e
2. Desenvolver o mecanismo de login.

Nesse sentido, cabe aqui revisar alguns tópicos importantes antes de iniciarmos a programação do primeiro requisito:

## Introdução

Nosso cenário de desenvolvimento é muito parecido com o que ocorre no mercado: O programador não tem a autonomia (por questões de complexidade e custo) de desenvolver o sistema como um todo, e portanto, precisa realizar seu trabalho em conjunto com outros programadores.
Neste curso, supomos a existência de uma API responsável por gerenciar as regras de negócio da aplicação; e para nós ficou o trabalho de desenvolver um sistema que consuma os recursos dessa API, que aqui se refere à um gerenciador de tarefas pessoais no formato Kanban.
Nosso servidor estará hospedado em `http://localhost/php_server/`.
Para ter o servidor na sua máquina local, acesse a pasta `extra` e faça o download de todo o diretório `php_server` na pasta `htdocs`.

Para ter a base da nossa aplicação no client-side, acesse a pasta `extra` dessa aula (`./aula-5/extra/`) e baixe o diretório `app-curso` na `htdocs`.

Você verá que temos 3 diretórios na raíz, sendo:
- assets (contém os arquivos utilizados no front-end, como scripts js, css e imagens);
- controller (onde serão gerenciadas as requisições); e
- model (onde serão tratadas as regras de negócio da aplicação).

Além disso, podemos observar 2 arquivos:
- index.php (que contém o template de cadastro e login desenvolvidos na aula 2); e
- dashboard.php (que como o nome esclarece, será o dashboard de tarefas).

> * Como o foco do curso não é front-end, não nos aprofundaremos em questões de layout.
> * Para executar ambas as aplicações é necessário inicializar o Apache e o Mysql pelo Xampp.

## Desenvolvimento

A partir daqui, assumimos que o ambiente está devidamente configurado e podemos começar a cumprir os requisitos dessa aula. Vamos seguir por uma abordagem mais simples para a construção do nosso código, para evitar confusões com conceitos de Orientação a Objetos (OO).

### Cadastro de Usuários

Como já temos a base de layout, vamos focar na implementação em PHP. Para o cadastro, utilizamos a classe `Request.php` que é responsável por resolver as questões de requisição. Sendo assim: 
- Crie um arquivo dentro do diretório `controller/users/add.php`;
- Na sequência, copie o código abaixo e cole no arquivo criado; e
- Em seguida, salve.

``` php
<?php 

include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição


$dadosDoFormulario 	= $_POST; 
$serverRequest 		= new Request('http://localhost/php_server/users/'); # Essa URL é definida pelo documento descritor da API

$resposta 			= $serverRequest->doPost($dadosDoFormulario);

header('Location: http://app-curso/dashboard.php?msg='.$resposta['result']->tx_message.'');

``` 
Vale ressaltar que quando recebemos a variável `$dadosDoFormulario` possui os valores enviados por POST pelo formulário de cadastro. Como seguimos um padrão de nomenclatura para convir com o que foi descrito na documentação da API, facilitamos o entendimento do código e sua utilização.

Veja que a implementação da classe `Request.php`, simplificou este tipo de operação à poucas linhas de código. Isso acontece, porque a reutilização de código é um dos benefícios da Orientação à Objeto (OO). Não podemos assumir que nossa aplicação faz uso pleno desse paradigma, pois ele prevê uso de inúmeros recursos para que OO seja devidamente implementado. Por outro lado, utilizamos alguns de seus conceitos - coerência e encapsulamento - para manter operações de requisição sendo responsabilidade de uma única classe. Vamos explorar o código do método `doPost`.

``` php

public function doPost($data = [], $header = [])
{
	/*
	* Cria uma string contendo as chaves/valores que serão enviados no corpo da requisição.
	* Algo no formato: 'tx_name=Jose&tx_email=jose@gmail.com'
	*/
	$fields = http_build_query($data);

	/* Se o token estiver configurado no objeto de requisição, adicione-o ao HEADER */
	if(!empty($this->token)){ array_push($header, 'token:'.$this->token); }

	//Abre a conexão
	$ch = curl_init();

	//Configura o cabeçalho da requisição
	if(!empty($header)){ curl_setopt($ch, CURLOPT_HTTPHEADER,$header); } # Configuro opções no HEADER apenas se for necessário
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_URL,$this->url);
	curl_setopt($ch,CURLOPT_POST,count($data));
	curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
	
	$result['result'] 	= json_decode(trim(curl_exec($ch))); //Executa a requisição e decodifica o JSON
	$result['code']		= curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch); //Fecha a conexão

	return $result;
}

``` 
Observe que ela abre o contexto de comunicação, e executa toda a operação de request; em seguida retorna como resultado um array com os campos `result` (que possui o retorno da API) e `code` (que é o código de status da resposta). Vale ressaltar que esse método ainda permite adicionar headers adicionais por um array. Isso é útil em casos onde a inclusão de `headers` específicos é necessária.


### Login / Logout - Autenticação de usuários

Dando continuidade, temos que implementar um mecanismo de autenticação de acesso, pois entendemos que os usuários do nosso sistema, podem apenas visualizar a *dashboard de tarefas* se estiverem `logados`. Para isso, crie um arquivo em `/controller/users/` com o nome de `login.php`. Em seguida:

- Copie o código abaixo e cole no arquivo `login.php`; e
- Salve.

``` php

<?php 
include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição


$dadosDoFormulario 	= $_POST; 

$serverRequest 		= new Request('http://appserver.local/login/');

$resposta 			= $serverRequest->doPost($dadosDoFormulario);

switch ($resposta['code']) {
	case 200:
		$dados = $resposta['result'];
		session_start(); # Inicializo a sessão
		$_SESSION['user']['tx_token'] 	= $dados->tx_token;
		$_SESSION['user']['tx_name'] 	= $dados->tx_name;
		$_SESSION['user']['tx_email'] 	= $dados->tx_email;

		header('Location: http://appcurso.local/dashboard.php');
		break;
	
	case 401:
		$dados = json_decode($resposta['result']);
		header('Location: http://appcurso.local/index.php?msg='.$dados->tx_message.'');
		break;
	default:
		header('Location: http://appcurso.local/');
		break;
}


```

Observe que, mais uma vez utilizamos o método `doPost` da classe `Request`. Isso porque na documentação da API somos orientados que para utilizar esse recurso da API, devemos fazer uma requisição com os campos: `tx_email`; e `tx_password`.
Veja que no caso da resposta ser bem sucedida (código 200), salvo os dados retornados (token, email e senha) na sessão. A partir dessa operação, é possível validar o acesso do usuário.

Para que a validação aconteça de verdade, precisamos inserir uma verificação no topo de cada arquivo de template, pois quando ele for requisitado, precisamos verificar se naquele momento o usuário está autenticado pra isso.
Abra o arquivo `dashboard.php` e antes da tag `<!DOCTYPE html>`, insira o seguinte código:

``` php
<?php 

session_start();
if(!isset($_SESSION['user'])){
	header('Location: http://appcurso.local/index.php');
}

?>

```

O que fazemos aqui é verificar se a chave `user` do array `$_SESSION` foi configurada, ou seja, se ela existe. Caso não exista, é porque não foi realizado o login e portanto é feito um redirecionamento para a página de login.
Contudo, se ela for bem sucedida, temos que tratar o caso da página de login, pois nesse momento, se tentarmos acessá-la, conseguiremos. De certa forma, não faz sentido acessar a página de login, depois que a autenticação já foi feita, por isso devemos corrigir esse comportamento.
Abra o arquivo `index.php` e antes da tag `<!DOCTYPE html>`, insira o seguinte código:

``` php
<?php 

session_start();
if(isset($_SESSION['user'])){
	header('Location: http://appcurso.local/dashboard.php');
}

?>

``` 

Observe que a única diferença desse código, para o código anterior, é a remoção do operador de negação na declaração da estrutura de seleção IF.


Para finalizar os requisitos planejados para essa aula, vamos fazer o logout, ou seja, a operação que retorna o usuário ao estado inicial (antes de se autenticar).

Perceba que estamos utilizando a variável global de sessão para gerenciar as páginas que temos acesso. Sendo assim, para remover os atributos de checagem de autenticação, precisamos apenas limpar as variáveis de sessão. Sendo assim:

- Crie um arquivo chamado `logout.php` em `/controller/users/`;
- Copie o código abaixo e cole em `logout.php`; e
- Salve o arquivo.

``` php

<?php 
session_start();
session_unset(); //Remove todas as variáveis da sessão
session_destroy(); // Destrói a sessão

header('Location: http://appcurso.local/index.php');

``` 

Como você deve ter percebido, chamamos a função `session_unset` que limpa todos os dados da sessão e em seguida chamamos `session_destroy` para "destruir" a variável de sessão; na sequência, redirecionamos para a página de login (index.php).


## Exercício para o Feriadão

Como nossas aulas possuem um ritmo acelerado, e pouco tempo para desenvolver atividades em sala, é muito importante ter desafios para treinar.
Para esse propósito, sugiro que realizem a seguinte atividade:
- Criar uma página, ou modal que apresente as informações do usuário `logado`, ou seja: nome e e-mail;

O objetivo da atividade é verificar se vocês conseguem utilizar arrays, gerenciar sessão, e de quebra, ver como está a intimidade de cada um quanto à HTML e CSS. 