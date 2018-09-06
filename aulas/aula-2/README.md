# Vamos praticar - HTML

Neste primeiro momento, vamos elaborar uma estrutura HTML básica para atender ao requisito:
- Desenvolver a estrutura de uma página de login, que deve conter:
	- Título: "Login";
	- Formulário com os campos `email` e `senha` e um botão de `submit`;
	- Um rodapé da página com a frase: (SEU NOME). 2018. Introdução à Programação Web com PHP

Para isso, crie uma pasta chamada `curso php` na sua área de trabalho; Abra um editor de texto e crie um novo arquivo a seguinte estrutura:

``` html

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Introdução à Programação Web com PHP</title>
</head>
<body>
	<section class="container">
		<fieldset>
			<h1>Login</h1>
			<form action="#">
				<label for="email">E-mail</label>
				<input type="email" name="email" id="email" required>
				<br>
				<label for="senha">Senha</label>
				<input type="password" name="senha" id="senha" required>
				<br>
				<input type="submit" value="Entrar">
			</form>
		</fieldset>
	</section>
	<footer>
		(SEU NOME). 2018. Introdução à Programação Web com PHP
	</footer>
</body>
</html>

``` 

 Salve o arquivo com o nome de `index.html`. Em seguida, abra o arquivo com o navegador e veja se o resultado ficou semelhante ao da imagem a seguir:

| ![Figura 1 - HTML](/aulas/aula-2/img/figura_1.png) | 
|:--:| 
| **Figura 1 - HTML** |

 
# Vamos praticar - CSS

Na seção anterior, elaboramos a estrutura de uma página apenas com HTML. Agora vamos dar um pouco mais de _estilo_ para ela.
Abra a pasta `curso php` criada anteriormente; crie uma subpasta chamada `css`; acesse a pasta `css` e crie um novo arquivo com o nome `login.css`. Sua estrutura de diretórios deve estar assim:

|- curso php<br\>
| |- `index.html`<br\>
| |- css<br\>
| | |- `login.css`<br\>

Abra o arquivo `index.html` e dentro da tag `head` insira a tag `link`, como apresentado no código abaixo:

``` html

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Introdução à Programação Web com PHP</title>
	<link rel="stylesheet" href="css/login.css"> <!-- INSIRA ESSA TAG -->
</head>
.
.
.

```

Abra o arquivo `login.css` copie o código abaixo, cole e em seguida salve e atualize a página:

``` css

html{ 
	height: 100%; 
}

html *{
	/* 
	* Essa regra permite que o padding (preenchimento) de todos os elementos 
	* filhos do elemento HTML, não interfiram no largura, ou altura, e mantém
	* o preenchimento (padding), contido no próprio elemento.
	*/
	box-sizing: border-box; 
}

body{
	/* 
	* Por padrão, o elemento BODY vem com margin e padding pré-definido. É uma convenção
	* "zerar" esses valores para que não interfiram no layout da página.
	*/
	margin: 0;
	padding: 0;
	width: 100%;
	background-color: #2a7cbb;
	font-family: sans-serif;
	position: relative;
	height: inherit;
}

/* 
* É uma convenção utilizar containers, para manter elementos dentro de um
* alinhamento geral. Geralmente define-se o viewport (com a regra, width)
* e insere uma margem automática nas laterais, para criar um respiro no 
* conteúdo que ficará dentro do container.
*/
.container{
	width: 1200px;
	margin: 0 auto;
	float: none;
	clear: both;
	padding: 5px 15px;
}

fieldset{
	max-width: 500px;
	width: 100%;
	margin: 55px auto 75px;
	float: none;
	clear: both;
	border: none;
	background-color: #FFF;
	padding: 2.5em 2.5em 1em;
	box-shadow: 0 5px 20px 0 rgba(0,0,0,.3);
}

fieldset h1{
	text-align: center;
	text-transform: uppercase;
	margin-top: 0;
}

fieldset form label{
	display: block;
	color: #666;
	font-size: .8em;
	font-weight: 600;
	margin-top: 15px;
	margin-bottom: .25em;
	text-transform: uppercase;
}

/* 
* Como apresentado no seletor abaixo, é possível definir as regras de estilo
* de forma específica utilizando inclusive valores de atributos. Nesse caso,
* programos um seletor que possui a seguinte declaração:
* "Todo elemento input que contenha o atributo type e possua os valores email, ou password, que estejam
* dentro de um elemento form, que por sua vez esteja dentro de um elemento fieldset, devem possuir as
* regras definidas a seguir..."
*/
fieldset form input[type="email"],
fieldset form input[type="password"]{
	color: #333;
	border: 2px solid #cdcdcd;
	border-radius: .25em;
	font-size: .9em;
	width: 100%;
	padding: .6em .8em;
}

fieldset form input[type="submit"]{
	width: 100%;
	background-color: #4db955;
	border: none;
	border-radius: 3px;
	color: #fff;
	cursor: pointer;
	display: inline-block;
	font-size: .8em;
	font-weight: 700;
	padding: 1.3em 2.125em;
	text-align: center;
	text-decoration: none;
	text-transform: uppercase;
	vertical-align: middle;
	white-space: nowrap;
	margin: 25px 0;
}

/* 
* Aqui foram utilizados pseudo-classes para indicar em quais momentos a cor do botão
* de submit, deveria ser alterada. Para saber mais sobre pseudo-classes, confira:
* https://www.w3schools.com/css/css_pseudo_classes.asp
*/
fieldset form input[type="submit"]:focus,
fieldset form input[type="submit"]:hover {
	background-color: #46b14e;
}


footer{
	position: absolute;
	bottom: 0;
	width: 100%;
	height: 60px;
	background-color: #3e4147;
	color: #FFF;
	padding-top: 25px;
	text-align: center;
}

```

> *PARA SABER MAIS SOBRE OS CONTEÚDOS AQUI EMPREGADOS, CONFIRA:*
>	- https://www.w3schools.com/cssref/css_selectors.asp
>	- https://www.w3schools.com/css/css_pseudo_classes.asp


Após atualizar a página o resultado deve ser semelhante ao da Figura abaixo:

| ![Figura 2 - CSS](/aulas/aula-2/img/figura_2.png) | 
|:--:| 
| **Figura 2 - CSS** |

# Vamos praticar - Javascript

Agora que já temos a página de login, seria interessante que o usuário fosse capaz de se cadastrar no nosso site, e portanto, devemos desenvolver uma página de cadastro. Os passos para essa atividade são:

1. Inserir o formulário de cadastro em `index.html` e deixá-lo oculto
2. Inserir link para exibir o formulário de cadastro e ocultar o de login
3. Desenvolver o comportamento de exibir e ocultar os formulários

## Passo 1

Abra o arquivo `index.html` e na tag fieldset do formulário de login, insira o atributo id="form-login". Que deve ficar da seguinte maneira:

``` html

<fieldset id="form-login">
	<h1>Login</h1>
	<form action="#">
		<label for="email">E-mail</label>
		<input type="email" name="email" id="email" required>
		<br>
		<label for="senha">Senha</label>
		<input type="password" name="senha" id="senha" required>
		<br>
		<input type="submit" value="Entrar">
	</form>
</fieldset>

```

Agora copie a mesma estrutura, e cole abaixo desse fieldset. Complemente com um input do tipo *text* para receber o nome do usuário, da seguinte forma:

``` html

<fieldset id="form-cadastro">
	<h1>Cadastre-se</h1>
	<form action="#">
		<label for="nome">Nome</label>
		<input type="text" name="nome" id="nome" required>
		<br>
		<label for="email">E-mail</label>
		<input type="email" name="email" id="email" required>
		<br>
		<label for="senha">Senha</label>
		<input type="password" name="senha" id="senha" required>
		<br>
		<input type="submit" value="Finalizar Cadastro">
	</form>
</fieldset>

```

Salve o arquivo; atualize a página; e veja se você possui algo semelhante à Figura abaixo:



| ![Figura 3 - Javascript](/aulas/aula-2/img/figura_3.png) | 
|:--:| 
| **Figura 3 - Javascript** |

## Passo 2

Veja que no formulário de cadastro, o campo `nome` não está no padrão dos demais campos. Como todos os campos deveriam ter uma mesma aparência, independente do tipo de input, isso nos leva a crer que uma classe CSS seria o necessário para padronizá-los.
Sendo assim, nos elementos `input` do tipo text, email e password, insira o atributo `class="form-field"` e salve. Devem ficar semelhante ao código abaixo:

``` html

	<label for="nome">Nome</label>
	<input type="text" name="nome" id="nome" class="form-field" required>

```

Em seguida, abra o arquivo `login.css` e procure pelo seletor que dá a aparência para os campos do tipo `email` e `password`. Após encontrar, altere os seletores encontrados para `form .form-field`. Veja se ficou semelhante ao código abaixo:

``` css

form .form-field{
	color: #333;
	border: 2px solid #cdcdcd;
	border-radius: .25em;
	font-size: .9em;
	width: 100%;
	padding: .6em .8em;
}

```

Essa estratégia permite que toda as vezes que quisermos replicar essa mesma aparência para um campo de formulário, bastará inserir a classe `form-field` no elemento. Salve o arquivo de estilo, e atualize a página. O formulário de cadastro deve estar semelhante ao da Figura 4:


| ![Figura 4 - Javascript](/aulas/aula-2/img/figura_4.png) | 
|:--:| 
| **Figura 4 - Javascript** |

Depois do processo de criação do formulário, precisamos escondê-lo e programar seu comportamento de exibição.
Para isso, insira a seguinte regra CSS no final do arquivo `login.css`

``` css

#form-cadastro{ 
	display: none; 
}

```

No arquivo `index.html`, você precisará inserir no formulário de login, algum elemento que permita exibir o formulário de cadastro; no formulário de cadastro, devemos inserir um elemento que permita reexibir o formulário de login. Codifique o código a seguir; salve o arquivo; atualize a página; e veja se o resultado é semelhante ao da Figura 5:

**No arquivo `index.html`**
``` html

<fieldset id="form-login">
	<h1>Login</h1>
	<form action="#">
		<label for="email">E-mail</label>
		<input type="email" name="email" id="email" class="form-field" required>
		<br>
		<label for="senha">Senha</label>
		<input type="password" name="senha" id="senha" class="form-field" required>
		<br>
		<a href="#" id="show-cadastro" class="action-link">Não é cadastrado? Clique aqui e cadastre-se</a>
		<input type="submit" value="Entrar">
	</form>
</fieldset>
<fieldset id="form-cadastro">
	<h1>Cadastre-se</h1>
	<form action="#">
		<label for="nome">Nome</label>
		<input type="text" name="nome" id="nome" class="form-field" required>
		<br>
		<label for="email">E-mail</label>
		<input type="email" name="email" id="email" class="form-field" required>
		<br>
		<label for="senha">Senha</label>
		<input type="password" name="senha" id="senha" class="form-field" required>
		<br>
		<a href="#" id="show-login" class="action-link">Voltar para login</a>
		<input type="submit" value="Finalizar Cadastro">
	</form>
</fieldset>

```

**No arquivo `login.css`**
``` css

/* Aqui, o seletor "ataca" os elementos que sejam da tag 'a' (link) e contenham a classe 'action-link' */
a.action-link{
    margin: 20px 0 0;
    text-align: right;
    display: block;
}

```
| ![Figura 5 - Javascript](/aulas/aula-2/img/figura_5.png) | 
|:--:| 
| **Figura 5 - Javascript** |


## Passo 3

Agora que os formulários foram implementados, cabe programar o comportamento de exibição. Crie uma subpasta no diretório `curso php` com o nome `js`; em seguida, crie o arquivo `login.js` dentro da pasta `js`, e insira o seguinte código:

``` javascript

/*
* Aqui, é utilizado o evento `onload` do BOM (Browser Object Model) `window`.
* Isto significa que todas as operações encapsuladas por esse evento, acontecerão
* quando a janela do navegador terminar de ser carregada.
*/
window.onload = function(){

	/*
	* Este é o bloco de declarações de variáveis.
	* Utilizamos o querySelector para selecionar os elementos desejados
	* de forma similar ao CSS.
	*/	
	var btnExibeCadastro 	= document.querySelector('a#show-cadastro');
	var btnExibeLogin 	  	= document.querySelector('a#show-login');
	var formCadastro  		= document.querySelector('#form-cadastro');
	var formLogin  	  		= document.querySelector('#form-login');

	/*
	* Nesse trecho, é adicionado um listener no evento de click
	* do botão que exibe o cadastro. Ele tem a função de realizar
	* a operação encapsulada na função atribuída à ele toda vez
	* que o evento de clique do botão acontecer.
	*/
	btnExibeCadastro.onclick = function(evento){
		/* Previne que o evento padrão do elemento <a> ocorra. Nesse caso, o link não mudaria a página. */
		evento.preventDefault();
		/* Aqui, são alteradas as propriedades CSS, display, de cada um dos elementos. */
		formLogin.style.display 	= 'none';
		formCadastro.style.display 	= 'block';
	}

	btnExibeLogin.onclick = function(evento){
		evento.preventDefault();
		formCadastro.style.display 	= 'none';
		formLogin.style.display 	= 'block';
	}
}

```

> *PARA SABER MAIS SOBRE OS CONTEÚDOS AQUI EMPREGADOS, CONFIRA:*<br />
> - https://www.w3schools.com/js/default.asp
> - https://www.w3schools.com/js/js_ex_browser.asp
> - https://www.w3schools.com/js/js_htmldom_css.asp

Após concluir todas as etapas dessa aula, você já deve ter uma página web estática com 2 formulários.