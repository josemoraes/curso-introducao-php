# Aula 7 - Desenvolvimento do Projeto (client-side)

Como nossa última aula do curso, faremos o seguinte requisito:
1. Atualizar o estado da tarefa;

## Introdução

Na aula anterior, vimos o cadastro, listagem e exclusão de tarefas. Na prática, isso equivale à quase todos os requisitos previstos para esse sistema. Contudo, precisamos elaborar um dos principais mecanismos, e talvez o mais interessante: O drag n drop de tarefas; Ou seja, quando um usuário clicar e arrastar uma tarefa para outra coluna, o estado da tarefa deve ser atualizado.
Nesse sentido, vamos ao desenvolvimento.

## Desenvolvimento

> Inicializem o Apache e o MySQL de vocês, pelo XAMPP, para iniciarmos o desenvolvimento.

### Drag n Drop de Tarefas (considerações iniciais)

No HTML5, qualquer elemento pode ser 'arrastável' (draggable) e para habilitar esse comportamento, é necessário apenas inserir o atributo/valor `draggable="true"` nele. De posse dessa informação, já temos a primeira adaptação necessária:
1. Abra o arquivo `dashboard.php`;
2. Em todas as `div` com a classe `.card`, você deve inserir o atributo/valor `draggable="true"`. Veja o exemplo abaixo:

```php
<div class="card" draggable="true">
.
.
.
</div>

```

> Para testar, clique em qualquer cartão de tarefa que você tenha cadastrado e tente arrastar. Observe que o elemento obtém uma trasparência e você o manipula pela tela.

O próximo passo é atribuir um ID para as colunas e para os cartões, pois o efeito que queremos é exatamente o de manipular os cartões. Nesse sentido, deve estar claro a origem e o destino do cartão no evento de arrastar.
Para os identificadores da coluna, vá na `div` com a classe `.contents` de cada uma das colunas e coloque, respectivamente:

```php

<div class="contents" id="todo">
.
.
.
</div>

<div class="contents" id="doing">
.
.
.
</div>

<div class="contents" id="done">
.
.
.
</div>

```

> Não pode haver mais de um elemento com mesmo ID. Se houver, remova.

Para criar identificadores únicos para cada cartão, faça o seguinte: 
- Para cada cartão da coluna TODO, o mesmo deve ter um ID da seguinte forma: 'todo-<ID DA TAREFA>';

Repita o mesmo procedimento para os cartões das demais colunas. Ao final, você deve ter cartões com a seguinte estrutura:

```php
<div class="card" id="todo-<?php echo $to_do_task->_id ?>" draggable="true">
.
.
.
</div>

<div class="card" id="doing-<?php echo $doing->_id ?>" draggable="true">
.
.
.
</div>

<div class="card" id="done-<?php echo $done->_id ?>" draggable="true">
.
.
.
</div>

```

Feito isso, precisamos programar os eventos no Javascript.

### Drag n Drop de Tarefas (Javascript)

Existem vários eventos relacionados à mecânica de drag'n drop, mas aqui vamos focar nos três principais:
1. *dragstart*: Que é o evento inicial de arraste;
2. *dragover*: Que é o evento de flutuação do elemento;
3. *drop*: Que é o evento capturado quando um elemento é solto;

Abra o arquivo `dashboard.js`. E insira o código abaixo:

```javascript

$('.card').bind('dragstart', function(event) {
	/* Aplico o ícone de mover no elemento */
	event.originalEvent.dataTransfer.effectAllowed = 'move';
	/* Configura em formato de texto o ID do elemento para afixar ele no destino */
	event.originalEvent.dataTransfer.setData("text/plain", jQuery(this).attr('id'));
});

```

O que o código acima faz é capturar o evento `dragstart` e no primeiro comando da função é aplicado o ícone `move`; Na segunda operação é configurado o ID do cartão no contexto do evento `draggable`. Para não inferir nenhuma operação na coluna durante o evento `dragover`, utilizamos o código a seguir:

```javascript

$('section').bind('dragover', function(event) {
	/* Impeço que algo ocorra durante o arraste */
	event.preventDefault();
});

```

A última parte é a operação principal. O que queremos é que quando o usuário soltar o cartão, ele se fixe na coluna de destino e atualize o estado. Veja o código a seguir:

```javascript

$('section .contents').bind('drop', function(event) {
	/* Impeço que o evento padrão seja aplicado e aqui, executa minha rotina */
	event.preventDefault();
	/* Capturo o ID do card que foi configurado no evento dragstart */
	var idDoCard = event.originalEvent.dataTransfer.getData("text/plain");
	var card 	 = document.getElementById(idDoCard);
	var coluna   = jQuery(event.target);
	var id 		 = idDoCard.split('-')[1]; /* Esse é o ID não do elemento, mas da entidade Task no banco */
	
	/* Fixa o cartão na coluna de destino */
	event.target.appendChild(card);
	
	jQuery.ajax({
        method:'POST',
        url: 'http://localhost/app-curso/controller/tasks/update-state.php',
        data:{'id_task':id,'ch_tag':coluna.attr('id')},
        success: function(retorno){
        	location.reload();
        },
        error: function(retorno){
        	location.reload();
        }
    });
});

```

A operação `jQuery.ajax` realiza uma operação assíncrona por método `POST`, e envia os parâmetros `id_task` e `ch_tag` para a URL 'localhost/app-curso/controller/tasks/update-state.php'.
É no arquivo 'update-state.php' que acontece todo o processamento da operação e faz o consumo da API.


### Drag n Drop de Tarefas (Consumo da API)

O primeiro passo é criar o método `doPut` em `Request.php`, pois ele ainda não existe. Sendo assim, abra o arquivo `./model/Request.php` e cole o código abaixo depois do método `doDelete`:

```php
public function doPut($data = [], $header = [])
{
	$fields = http_build_query($data);

	/* Se o token estiver configurado no objeto de requisição, adicione-o ao HEADER */
	if(!empty($this->token)){ array_push($header, 'token:'.$this->token); }

	//Abre a conexão
	$ch = curl_init();

	//Configura o cabeçalho da requisição
	if(!empty($header)){ curl_setopt($ch, CURLOPT_HTTPHEADER,$header); } # Configuro opções no HEADER apenas se for necessário
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
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
Esse código se assemelha ao `doPost`, com exceção da configuração `CURLOPT_CUSTOMREQUEST`.

A próxima etapa é desenvolver a operação de atualização de estado do cartão, para isso crie um arquivo chamado `update-state.php` dentro da pasta `controller/tasks`; Em seguida, cole o código abaixo e salve:

```php
<?php 
date_default_timezone_set ('America/Sao_Paulo'); # Configuro o fuso horário padrão
session_start();
include_once "../../model/Request.php"; # Importo a classe, para criar objeto de requisição

$serverRequest 			= new Request('http://localhost/php_server/tasks/', $_SESSION['user']['tx_token']);
$_POST['dt_deadline']   = strtotime($_POST['dt_deadline']);

$resposta 				= $serverRequest->doPut($_POST);

echo json_encode(['msg'=>($resposta['result']->tx_message)]); return;
```

Feito isso, você já deve ter o mecanismo de atualização de estado da tarefa funcionando perfeitamente.

> *PARA MAIS INFORMAÇÕES*
> [HTML5 Drag and Drop](https://www.w3schools.com/html/html5_draganddrop.asp)


## Desafio extra

Para completar o curso, nada melhor do que testar os seus conhecimentos. Para isso, sugerimos que: Desenvolva a atualização de data da tarefa;

### Dica para o desenvolvimento
- Consulte o [documento descritor da API](https://github.com/josemoraes/curso-introducao-php/blob/master/extra/documento-descritor-api.pdf) para entender como realizar a atualização;
- Faça testes com o Postman para ver como funciona a requisição;
- Crie um modal que tenha um `input` do tipo `hidden` para guardar o ID da tarefa e um campo para informar a nova data;
- Ao salvar ele deve enviar para um arquivo dentro de `controller/tasks` que fará a atualização da informação.

