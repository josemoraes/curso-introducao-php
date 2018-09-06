# Classes

Após criar os diretórios `./xampp/htdocs/php_server/users`, `./xampp/htdocs/php_server/tasks` e  `./xampp/htdocs/php_server/login`, vamos prosseguir com os passos descritos abaixo.

Primeiramente vamos criar as classes principais do nosso software. Crie o arquivo `user.php` no diretório `./xampp/htdocs/php_server/users` e depois crie o arquivo `task.php` no diretório `./xampp/htdocs/php_server/tasks`.

Ambas as classes serão construídas com uma estrutura simples de atributos e setters & getters, ou seja, não vamos abordar contexto de encapsulamento.

Vamos iniciar definindo a classe User:

``` php
<?php
    class User {
    	var $_id;
        var $tx_name;
        var $tx_email;
    	var $tx_password;
    	var $tx_token;
    
        function __construct($_id, $tx_name, $tx_email, $tx_password){
            $this->_id = $_id;
    		
    		if($tx_name == null || $tx_name == "")
    			$this->tx_name = "";
    		else
    			$this->tx_name = $tx_name;
    		
    		$this->tx_email = $tx_email;
    		$this->tx_password = $tx_password;
        }
    }
?>
``` 

Primeiro utilizamos o nome de ambiente `class` para informar ao compilador que vamos declarar uma classe, em seguida, atribuímos um nome a esta classe. (`User`). 

Para todo bloco de código dentro de uma classe, função ou condição sempre utilizamos `{}` (chaves) para abrir e fechar o bloco.

Por fim declaramos os atributos com o nome de ambiente `var` e o construtor da nossa classe com `function`.

Note que utilizamos o comando `$this` para referenciar atributos da classe. Como podemos ver no construtor, os nomes de "variáveis" se repetem, porém, o comando `$this` informa que são os atirbutos da classe que estão recebendo valores dos parâmetros.

Crie os setters & getters de cada atributo logo abaixo do método construtor, seguindo o padrão de codificação separado por `_` como mostrado abaixo:

``` php
    public function set_id($id){
		$this->_id = $id;
	}
	
    public function get_id(){
		return $this->_id;
	}
	
	public function set_name($name){
		$this->tx_name = $name;
	}
	
	public function get_name(){
		return $this->tx_name;
	}
	
	public function set_email($email){
		$this->tx_email = $email;
	}
	
	public function get_email(){
		return $this->tx_email;
	}
	
	...
``` 

Agora vamos construir a classe Task no arquivo `task.php` que criamos anteriormente. Abra o arquivo e digite o seguinte código:


``` php
<?php
    class Task {
    	var $_id;
        var $tx_title;
        var $tx_description;
    	var $ch_tag;
    	var $dt_created;
    	var $dt_deadline;
    
        function Task($_id, $tx_title, $tx_description, $ch_tag,  $dt_created, $dt_deadline){
            $this->_id = $_id;
            $this->tx_title = $tx_title;
    		$this->tx_description = $tx_description;
    		$this->ch_tag = $ch_tag;
    		$this->dt_created = $dt_created;
    		$this->dt_deadline = $dt_deadline;
        }
    }
?>
``` 

Da mesma forma, criaremos os setters & getters de Task:

``` php
    public function set_id($id){
		$this->_id = $id;
	}
	
    public function get_id(){
		return $this->_id;
	}
	
	public function set_title($title){
		$this->tx_title = $title;
	}
	
	public function get_title(){
		return $this->tx_title;
	}
	
	public function set_description($description){
		$this->tx_description = $description;
	}
	
	public function get_description(){
		return $this->tx_description;
	}
	
	...
``` 

Salve ambos os arquivos.

# Requisições

Agora vamos criar os scripts que receberão as requisições para cada módulo. Crie um arquivo chamado `index.php` no diretório `./xampp/htdocs/php_server/users` e outro no diretório `./xampp/htdocs/php_server/tasks`.

Abra o arquivo index da pasta users e digite o seguinte código:

``` php
<?php
	// Define o "Content-Type" nos headers do response
	header('Content-Type: application/json');

	// Acessa o método de requisição informado
	$method = $_SERVER['REQUEST_METHOD'];
	
	// para cada método, um conjunto de ações 
	switch($method)
	{
		case 'GET':
			$result = '{ "tx_message": "Método GET invocado."}';
			break;
		case 'POST':
			$result = '{ "tx_message": "Método POST invocado."}';
			break;
		case 'PUT':
			$result = '{ "tx_message": "Método PUT invocado."}';
			break;
		case 'DELETE':
			$result = '{ "tx_message": "Método DELETE invocado."}';
			break;
		default:
			header("HTTP/1.0 405 Method Not Allowed");
			$result = '{ "tx_message": "Método não permitido"}';
	}
	
	echo($result);
?>
``` 

No primeiro comando `header` informamos o tipo de retorno, neste caso, um formato JSON.

Logo em seguida, resgatamos o tipo de requisição pelo atributo "REQUEST_METHOD", das informações trazida nos headers da requisição.

Uma vez que temos a informação do tipo de requisição como string, basta configurarmos condições para os serviços de cada método.


Teste e faça o mesmo para o outro arquivo `index.php`. (tasks)

Salve ambos os arquivos e crie mais um `index.php`, mas agora na pasta `login`. Crie também um outro arquivo chamado `auth.php`, esse arquivo será utilizado mais tarde.

Abra o novo index.php, digite o código abaixo e salve o arquivo.

``` php
<?php
	// Define o "Content-Type" nos headers do response
	header('Content-Type: application/json');

	// Acessa o método de requisição informado
	$method = $_SERVER['REQUEST_METHOD'];
	
	// para cada método, um conjunto de ações 
	switch($method)
	{
		case 'POST':
			$result = '{ "tx_message": "Método POST invocado."}';
			break;
		default:
			header("HTTP/1.0 405 Method Not Allowed");
			$result = '{ "tx_message": "Método não permitido"}';
	}
	
	echo($result);
?>
``` 


# Operações com Arrays

Os arrays em PHP são compostos por valores e chaves, como um hashtable ou dicionário. Sua sintaxe é demonstrada logo abaixo:

```
array(
  key1  => value,
  key2  => value,
  key3  => value
)
```

...



