# Aula 6 - Desenvolvimento do Projeto (client-side)

Para essa etapa, está previsto o desenvolvimento dos seguintes requisitos:
1. Desenvolver o cadastro de tarefas;
2. Listar as tarefas;
3. Desenvolver o mecanismo de exclusão de tarefas.

## Introdução

Na aula anterior, vimos alguns conceitos fundamentais: Gerenciamento de sessão; e Envio de requisições para recursos remotos (API). Isso nos dá uma base sólida para desenvolver os requisitos dessa aula, pois o método de execução da requisição é o mesmo visto anteriormente, sendo assim, "mãos ao código"!

## Desenvolvimento

Inicializem o Apache e o MySQL de vocês, pelo XAMPP, para iniciarmos o desenvolvimento.

### Cadastro de Tarefas

Para o cadastro de tarefas temos 2 alternativas: Fazer uma página apenas para cadastrar a tarefa, ou podemos desenvolver um modal, e manter tudo na dashboard. Como nosso desejo é viabilizar um meio prático e intuitivo ao usuário final, vamos optar pela segunda opção: O Modal!
Abra o arquivo `dashboard.php` e depois do `footer` cole o código abaixo:

``` html

<div class="modal" data-ref="new-task">
	<span class="close">X</span>
	<div class="modal-wrapper">
		<div class="modal-content">
			<h2 class="page-title">Cadastrar Nova Tarefa</h2>
			<form action="controller/tasks/add.php" method="POST">
				<label for="tx_title">Título</label>
				<input type="text" id="tx_title" name="tx_title" class="form-field" required>
				<br>
				<label for="tx_description">Descrição</label>
				<textarea name="tx_description" id="tx_description" class="form-field" cols="30" rows="10"></textarea>
				<br>
				<label for="ch_tag">Em qual estado a tarefa está?</label><br>
				<select name="ch_tag" id="ch_tag" class="form-field">
					<option value="todo">Não foi feita</option>
					<option value="doing">Estou fazendo</option>
					<option value="done">Já concluí</option>
				</select>
				<br>
				<label for="dt_deadline">Prazo para conclusão</label>
				<input type="text" name="dt_deadline" id="dt_deadline" class="form-field date_time">
				<br>
				<input type="submit" class="btn right" value="Salvar Tarefa">
			</form>
		</div>
	</div>	
</div>

``` 
Essa estrutura do DOM não fica visível por padrão, porque aplicamos a seguinte regra CSS:

``` css

.modal{
	position: fixed;
	z-index: 999;
	top: 0;
	width: 100%;
	height: 100%;
	background-color: #585858d4;
	display: none; /* É essa regra que mantém o modal escondido */
}

```

A visualização do modal só é possível, quando acontece o clique no botão `Nova Tarefa` (presente no cabeçalho), que por javascript, identifica qual estrutura deve se tornar visível, e a exibe. Veja:

``` javascript

/* Abre o modal de cadastro de tarefas */
jQuery('#new-task').on('click', function(){
	var modal = jQuery('.modal[data-ref="'+jQuery(this).attr('data-ref')+'"]');
	modal.show();
});

/* Fecha o modal de cadastro de tarefas */
jQuery('.modal .close').on('click', function(){
	jQuery(this).parent().hide();
});

```

Não nos aprofundaremos em HTML, CSS e Javascript, sendo assim, vamos pontuar o que for mais relevante nesses aspectos.
Veja que no action do form, indicamos a URL do arquivo que processará o cadastro: 'controller/tasks/add.php'; nomeamos os campos do formulário conforme o previsto na documentação da API: `tx_title`, `tx_description`, `ch_tag`, `dt_deadline`.
A próxima etapa é criar o arquivo que processará a requisição. Para isso:
- Crie o diretório `controller/tasks`;
- Dentro da pasta `tasks`, crie o arquivo `add.php`;
- Copie o código abaixo; cole no arquivo `add.php`; e salve.

``` php

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

```

Analisando o que foi codificado, o código é muito semelhante com o que fizemos no cadastro e login de usuários, contudo, há algumas exceções. Veja:

- Utilizamos a função `date_default_timezone_set` no topo do arquivo que permite configurar o fuso horário que desejamos (no nosso caso o brasileiro);
- Quando criamos o objeto de requisição, utilizamos o Token configurado na sessão;
- Fazemos um tratamento na data, pois primeiro, precisamos converter a data enviada pelo formulário no formato esperado pela API (que é do tipo LONG INTEGER);
	- Criamos um objeto de data com o valor vindo do formulário;
	- Formatamos para o formato que brasileiro de data; e
	- Utilizamos a função `strtotime` para converter o valor da data em um LONG INTEGER.
- Caso o retorno não seja positivo (status 200), exibimos a mensagem de erro. 

O próximo passo a se fazer é listar as tarefas que cadastramos, que será apresentado na próxima seção.


### Listar as tarefas

Para entender como requisitar as tarefas de um usuário no servidor, precisamos consultar o [documento descritor da API](/extra/documento-descritor-api.pdf).

Segundo o documento, devemos enviar um `token` configurado no header para o endereço `/tasks/`.
Como desejamos 'imprimir' os cartões de tarefas na página de dashboard vamos realizar a requisição no carregamento da própria dashboard. Portanto, faremos o seguinte:

1. No topo do arquivo `dashboard.php`, logo após verificarmos se o usuário está logado, devemos criar um objeto de requisição para fazer a consulta. Para isso coloque o seguinte código:

``` php

include_once "model/Request.php"; # Importo a classe, para criar objeto de requisição
$request  = new Request('http://appserver.local/tasks', $_SESSION['user']['tx_token']);
$response = $request->doGet(); # Realiza a consulta

```

#### Observação Importante

Segundo a documentação da API, esse método pode retornar um status 401, o que significa que o login expirou. Então logo após a execução do método GET, devemos verificar o status retornado. Se for 401, precisamos `destruir` a sessão e redirecionar o usuário para a página de login, conforme é apresentado a seguir:

``` php

if($response['code'] == 401)
{
	$msg = $response['result']->tx_message;
	session_unset(); //Remove todas as variáveis da sessão
	session_destroy(); // Destrói a sessão
	header('Location: http://appcurso.local/index.php?msg='.$msg);	
}
# Passo o resultado para uma variável mais intuitiva
$tasks   = $response['result'];

```

#### ... Continuando

Precisamos agora, percorrer o array `$tasks` que possui todas as atividades cadastradas no banco e imprimi-lás devidamente em cada coluna.
Temos aqui 3 colunas: *PARA FAZER*. Para atividades que ainda não foram feitas; *FAZENDO*. Para atividades que estão sendo feitas; e *FEITO*. Para atividades que já foram concluídas. Toda atividade possui um atributo chamado `ch_tag` que tem a responsabilidade de marcar o estado da atividade e posicioná-la devidamente em sua coluna.
Os cartões de atividades devem ser impressas dentro da tag `div` com classe `contents` de cada coluna. Nesse sentido, vamos ao código:

``` php

<?php foreach ($tasks as $to_do_task): ?>
	<?php if (isset($to_do_task->_id) && $to_do_task->ch_tag == 'todo'): ?>
		<div class="card">
			<div class="card-header"><h3><?php echo $to_do_task->tx_title; ?></h3><span class="prazo"><?php echo empty($to_do_task->dt_deadline) ? '' : date('d/m/Y \à\s H:i', $to_do_task->dt_deadline); ?></span></div>
			<div class="card-content">
				<p><?php echo $to_do_task->tx_description; ?></p>
			</div>
			<div class="card-footer">
				<form action="controller/tasks/delete.php" method="POST" class="delete-task">
					<input type="hidden" name="id_task" value="<?php echo $to_do_task->_id ?>" method="DELETE">
					<button type="submit" class="btn delete">Excluir</button>
				</form>
			</div>
		</div>
	<?php endif ?>
<?php endforeach ?>

```

Para entender esse código, vamos dividir em dois passos:
1. A primeira declaração é a abertura de um laço de repetição `FOREACH` que tem o papel de iterativamente acessar cada posição do array de tarefas;
2. Em seguida, há uma verificação em uma estrutura de seleção IF, que checa se existe um objeto ali, e se a tag é 'todo', ou seja, se a tag se refere ao estado de tarefas a serem feitas (To Do);

> Para treinar o que acabamos de fazer, replique esse mesmo raciocínio para as próximas colunas. Se possível, crie tarefas para cada estado possível, pois isso facilita o teste.



### Excluir Tarefa

Se você realizou corretamente os passos da seção anterior, então já temos um botão para excluir que submete um formulário com o ID da tarefa para o arquivo `controller/tasks/delete.php`. Vale lembrar que, conforme já mencionado na aula anterior, o PHP não possui variáveis globais pré-definidas para todos os métodos, apenas para GET e POST ($_GET e $_POST, respectivamente), portanto, como o DELETE é uma operação que exige melhor encapsulamento por questões de segurança, a alternativa é enviar o ID por POST.
Sendo assim: 
- Crie o arquivo `delete.php` dentro do diretório `controller/tasks`;
- Copie o código a seguir, cole no arquivo `delete.php` e salve;

``` php

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

```
Assim como nas outras requisições, criamos um objeto de requisição (com token de autenticação) e executamos a respectiva função (nesse caso o `doDelete`) informando os atributos da requisição (`id_task`). Por último verificamos a resposta e realizamos o redirecionamento.
Se você clicar no botão `Excluir`, você verá que a mecânica está funcionando perfeitamente. Contudo, seria interessante que antes de realizar a exclusão da tarefa, o usuário fosse consultado se realmente deseja fazer isso, pois pode acontecer um clique acidental no botão excluir uma tarefa que não deveria ser excluída.
Para resolver esse problema é muito simples. Abra o arquivo `assets/js/dashboard.js` e insira o seguinte código:

``` javascript

/* #### Exclusão de tarefa ####
* Aqui é interrompido o comportamento padrão do clique no botão
* e apenas é realizada a submissão do formulário, se o usuário
* clicar em 'OK' no popup de confirmação.
*/
jQuery('form.delete-task .btn.delete').click(function(evento){
	evento.preventDefault();
	var form = jQuery(this).parent();
	if(confirm('Você confirma a exclusão dessa tarefa?')){
		form.submit();
	}
});

``` 

O que fazemos no código acima é bloquear o comportamento padrão do clique no botão de submissão, utilizamos a função `confirm()` que exibe um popup com a mensagem passada como parâmetro, e possui um botão OK e um CANCELAR. Se você clicar no OK, é retornado um TRUE e no CANCELAR, um FALSE. Por isso que colocamos o `confirm()` dentro de um IF, porque se retornar verdadeiro, permitimos o envio das informações do formulário.


#### Dica de ouro
Caso você queira configurar uma variável global referente à algum método de requisição que não seja pré-definida no PHP, sugerimos o seguinte código:

``` php
global $_DELETE = []; # Defino a variável com escopo global

/* Verifico se o método é o que desejo configurar. E passo os valores enviados pelo formulário para a variável $_DELETE */
if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
    parse_str(file_get_contents('php://input'), $_DELETE);
}


```

> Veja também: [strcasecmp](http://php.net/manual/pt_BR/function.strcasecmp.php) e [parse_str](http://php.net/manual/pt_BR/function.parse-str.php)