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

ou 

$array = [
    "foo" => "bar",
    "bar" => "foo",
];
```

Podemos acessar os valores de um array através de suas chaves ou indexadores.

```php
echo($array["foo"]);
echo($array["bar"]);
```

Utilizando indexadores:

```
$array = ["bar", "foo"];
		
echo($array[0]);
echo '<br>', $array[1];
```

A linguagem PHP nos permite operações básicas de hashtable em um vetor comum. Abaixo são apresentadas algumas de suas funções:

```
$arr = array(5 => 1, 12 => 2);
var_dump($arr);

$arr[] = 56;    // Isto é o mesmo que $arr[13] = 56;
		// nesse ponto do script
var_dump($arr);

$arr["x"] = 42; // Isto acrescenta um novo elemento
		// para o array com a chave "x"
var_dump($arr);

unset($arr[5]); // Isto remove um elemento do array
var_dump($arr);

unset($arr);    // E isto apaga todo o array
@var_dump($arr);
```
Arrays multidimensionais:

```
$array = array(
  "foo" => "bar",
  42    => 24,
  "multi" => array(
      "dimensional" => array(
          "array" => "foo"
       )
  )
);
		
var_dump($array["foo"]);
var_dump($array[42]);
var_dump($array["multi"]["dimensional"]["array"]);
```

Percorrendo, apagando e reindexando arrays:

```
// Criando um array normal
$array = array(1, 2, 3, 4, 5);
print_r($array);
		
// Acrescentando um item (note que a chave é 5, em vez de zero).
$array[] = 6;
print_r($array);

// Agora apagando todos os itens, mas deixando o array intacto:
foreach ($array as $i => $value) {
    unset($array[$i]);
}
print_r($array);
		
// Acrescentando um item (note que a chave é 5, em vez de zero).
$array[] = 6;
print_r($array);

// Reindexando:
$array = array_values($array);
$array[] = 7;
print_r($array);

// outras formas comuns
$array = array(1, 2, 3, 4, 5);
print_r($array);
		
for($i = 0; $i < count($array); $i++)
    echo " - ", $array[$i];
		
echo("<br>");
$i = 0;
while($i < count($array)){
    echo " - ", $array[$i++];
}
```

Acessando parâmetros como arrays (POST):

```
$array = $_POST;
print_r($array);
		
foreach ($array as $i => $value) {
	echo "<br>", $value;
}
```

Acessando parâmetros como arrays (GET):

```
$array = $_GET;
print_r($array);
		
foreach ($array as $i => $value) {
    echo "<br>", $value;
}
```
Demais tipos:

```
parse_str(file_get_contents("php://input"), $array);
print_r($array);
		
foreach ($array as $i => $value) {
    echo "<br>", $value;
}
```

Salve o script. Continuaremos a programação das requisições na próxima aula.
