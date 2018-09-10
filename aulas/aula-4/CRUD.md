Precisaremos de um script PHP que se conecte ao banco de dados e faça as operações de INSERT, UPDATE, DELETE e SELECT, esse script será chamado de `DBManager`. Crie o script 
no diretório raiz `php_server`.

Crie mais um outro script chamado `Miscellaneous`, esse script conterá dados que serão compartilhados dentre vários scripts.

Abra o DBManager.

Vamos começar com a declaração da classe DBManager e seus atributos `$server_name`, `$db_name`, `$user_name`, `$password` e `$conn`.

O método construtor será criado da seguinte forma:

```
function __construct() {
	$this->server_name = "localhost";
	$this->user_name = "root";
	$this->password = "";
	$this->db_name = "cursophp";
}
```

O destrutor:

```
function __destruct() {
	$this->conn->close();
}
```

Para estabelecer uma conexão com o banco, utilizaremos o seguinte método:

```
/**
 * Tentará abrir uma conexão com o banco de dados, em caso de falha, invocará 
 * o método "db_init" para criar as tabelas do banco.
 *
 * @return boolean representando o resultado da operação.
 */
public function db_connect(){
	// Cria uma conexão
	@$this->conn = new mysqli($this->server_name, $this->user_name, $this->password, $this->db_name);
	// Valida a conexão
	if ($this->conn->connect_error) {
		return $this->db_init();
	}else{
		return true;
	}
}
```

Observe que no método acima temos uma condição para caso a conexão falhe. Isso ocorre quando há uma falha de conexão com o banco. Então essa funçao invocará outra, para que a base seja criada e que a conexão seja estabelecida.

```
/**
 * Cria a base de dados e as tabelas "Users" e "Taks".
 *
 * @return boolean representando o resultado da operação.
 */
public function db_init(){

	try{
		$this->conn = new mysqli($this->server_name, $this->user_name, $this->password);
			
		$sql = "CREATE DATABASE IF NOT EXISTS ".$this->db_name." CHARACTER SET utf8 COLLATE utf8_general_ci;";
		$this->conn->query($sql);
		@$this->conn->close();
			
		$this->conn = new mysqli($this->server_name, $this->user_name, $this->password, $this->db_name);
		$sql = "CREATE TABLE IF NOT EXISTS users (_id INTEGER(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, tx_name VARCHAR(35) CHARACTER SET utf8, tx_email VARCHAR(255) CHARACTER SET utf8 NOT NULL, tx_password TEXT CHARACTER SET utf8, tx_token TEXT CHARACTER SET utf8) CHARACTER SET utf8 COLLATE utf8_general_ci;"; 
		$this->conn->query($sql);
		$sql = "CREATE TABLE IF NOT EXISTS tasks(
				_id INTEGER(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
			tx_title VARCHAR(50) CHARACTER SET utf8, 
			tx_description TEXT CHARACTER SET utf8, 
			ch_tag CHAR(5) CHARACTER SET utf8, 
			dt_created DATETIME NOT NULL DEFAULT now(), 
			dt_deadline DATETIME NOT NULL, 
			id_user INTEGER(6) UNSIGNED NOT NULL, 
			FOREIGN KEY (id_user) REFERENCES users(_id) ON DELETE CASCADE ) CHARACTER SET utf8 COLLATE utf8_general_ci;";
		$this->conn->query($sql);
			
	}catch(Exception $e){
		var_dump($e->getMessage());
		return false;
	}

	return true;
}
```
Observe que também são criadas as tabelas `users` e `tasks`. Ademais, serão apenas métodos get e um método para executar "Queries".

```
public function db_exec_sql($sql){
	return $this->conn->query($sql);
}
	
public function get_servername(){
	return $this->servername;
}
	
public function get_username(){
	return $this->username;
}
	
public function get_password(){
	return $this->tx_password;
}
```

Salve o script e abra o `Miscellaneous.php`.

Copie o seguinte código:

```php
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
```
Como são apenas variáveis que serão compartilhadas, dispensamos comentários. Salve o script.

Antes de continuarmos, vamos adaptar a classe `User` para converter datas. Abra o script `user.php` em `/users/user.php`.

Caso o campo `$tx_name` for vazio, vamos inserir uma string vazia. Altere o construtor para a seguinte forma:

```
function __construct($_id, $tx_name, $tx_email, $tx_password){
    $this->_id = $_id;
		
    if($tx_name == null || $tx_name == "")
	$this->tx_name = "";
    else
	$this->tx_name = $tx_name;
		
    $this->tx_email = $tx_email;
    $this->tx_password = $tx_password;
}
```
Antes de inserir a string da senha no banco, devemos codificá-la de uma forma que fique ilegível. Então utilizaremos um script pronto para codificar. Copie as funções abaixo:

```
public function set_encrypted_password($pwd){
   $this->tx_password = encrypt_decrypt('encrypt', $pwd);
}
	
public function get_decrypted_password(){
   return encrypt_decrypt('decrypt', $this->tx_password);
}
```

Se houver algum outro set ou get de password, delete-os.

Caso não exista o atributo `$tx_token`, adicione-o e escreva seu set e get.

Utilizaremos o mesmo método de criptografia para o token, que conterá a identificação do registro e a data atual. Copie o código abaixo:

```
/**
 * codifica o token utilizando o campo _id e a datetime atual
 *
 */
public function set_encrypted_token(){
	$dt = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	$token = $this->_id."?".$dt->getTimestamp();
	$this->tx_token = encrypt_decrypt('encrypt', $token);
}
	
/**
 * decodifica o token
 *
 * @return array sendo [0] o ID do usuário e [1] o datetime da criação do token
 */
public function get_decrypted_token(){
	$t = encrypt_decrypt('decrypt', $this->tx_token);
	return explode("?", $t);
}
```

Mova o arquivo `php_server/encrypt.php` para o mesmo diretório de `user.php`.

Agora vamos programar as requisições. Abra o `index.php` do diretório `/users/`.

Vamos adicionar logo abaixo do comando `header` o seguinte código:

```
// Variáveis Gerais
require '../Miscellaneous.php';
```

Importanto o arquivo Miscellaneous, vamos conseguir utilizar suas variáveis.

No `switch` que criamos, deixe apenas o case `POST` e o default. No default, altere o código para:

```
header($R_405);
$result = '{ "tx_message": "'.$ERR_405.'"}';
```
Observe as variáveis de Miscellaneous sendo utilizadas.

Vamos manter então o comando `echo($result);` logo em seguinda do nosso switch.


Vamos então para a função `request_post`, que fará o cadastro do usuário. O script será comentado em aula e conterá apenas este método.

```
function request_post(){
	require '../Miscellaneous.php';
	require './user.php';
		
	if(
		(isset($_POST["tx_email"]) && !empty($_POST["tx_email"])) &&
		(isset($_POST["tx_password"]) && !empty($_POST["tx_password"]))
	){
		$n_reg = new User("", $_POST["tx_name"], $_POST["tx_email"], "");
		$n_reg->set_encrypted_password($_POST["tx_password"]);
			
		include_once '../DBManager.php';
		$dbm = new DBManager();
		if($dbm->db_connect()){
			$sql = "INSERT INTO users (tx_name, tx_email, tx_password, tx_token) VALUES ('".$n_reg->get_name()."', '".$n_reg->get_email()."', '".$n_reg->get_password()."', 'null')";
			$result = $dbm->db_exec_sql($sql);
			if($result == "1" || $result == 1){
				header($R_200);
				$result = '{ "tx_message": "'.$DB_SUC_INS.'" }';
			}else{
				header($R_401);
				$result = '{ "tx_message": "'.$DB_ERR_INS.'" }';
			}
		}else{
			header($R_401);
			$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
		}
	}else{
		header($R_400);
		$result = '{ "tx_message": "'.$DB_ERR_INS_VAL.'E-mail e Senha." }';
	}
	
	return $result;
}
```

No case `POST`, haverá apenas o call deste método:

```
case 'POST':
	$result = request_post();
break;
```

Pronto! Agora temos o cadastro de usuário funcionando! Então vamos ao login!

A autorização de um usuário para efetuar as requisições de Taks (tarefas) será feita através do script `auth.php` que validará um token informado. Dentro do diretório `/login/` crie o script.

```php
require '../users/user.php';
	
function check_auth($token){
	$user_auth = new User("", "", "", "");
	$user_auth->set_token($token);
		
	$decrypted = $user_auth->get_decrypted_token();
	$user_auth->set_id($decrypted[0]);
		
	$dt_current = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	$dt_from_token  = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	@$dt_from_token->setTimestamp($decrypted[1]);
		
	$diff = $dt_from_token->diff( $dt_current );
	//$hours = $diff->format('%y ano(s), %m mês(s), %d dia(s), %H hora(s), %i minuto(s) e %s segundo(s)')
		
	if($diff->i <= 20){
		return $user_auth;
	}else{
		return false;
	}
}
```

O script será comentado em aula.

Obs: Certifique que todos os scripts index.php estejam retornando um documento Json.

Faça a mesma importação do arquivo `../Miscellaneous.php` nos outros arquivos `index.php`.

No arquivo `/login/index.php`, defina a seguinte condição para a requisição:

```
$method = $_SERVER['REQUEST_METHOD'];
	
// para cada método, um conjunto de ações 
switch($method)
{
	case 'POST':
		$result = request_post();
		break;
	default:
		header($R_405);
		$result = '{ "tx_message": "'.$ERR_405.'"}';
}

echo($result);
```

Agora vamos ao método `request_post`. Digite o seguinte código:

```
require '../Miscellaneous.php';
require '../users/user.php';
		
if(
	(isset($_POST["tx_email"]) && !empty($_POST["tx_email"])) &&
	(isset($_POST["tx_password"]) && !empty($_POST["tx_password"]))
){
	  $post_pwd = $_POST["tx_password"];
	  $n_reg = new User("", "", $_POST["tx_email"], "");
	
	  include_once '../DBManager.php';
	  $dbm = new DBManager();
    if($dbm->db_connect()){
		  $sql = " SELECT * FROM users WHERE tx_email='".$n_reg->get_email()."' LIMIT 1";
			$result_q = $dbm->db_exec_sql($sql);
		  if ($result_q->num_rows > 0) {
					$row = mysqli_fetch_assoc($result_q);					
					$n_reg->set_password($row["tx_password"]);
					
					if($n_reg->get_decrypted_password() === $post_pwd){
						$n_reg->set_id($row["_id"]);
						$n_reg->set_name($row["tx_name"]);
						$n_reg->set_email($row["tx_email"]);
						$n_reg->set_encrypted_token();
						
						header($R_200);
						$result = '{
							"tx_token": "'.$n_reg->get_token().'",
							"tx_email": "'.$n_reg->get_email().'",
							"tx_name": "'.$n_reg->get_name().'"
					  }';
					}else{
						header($R_401);
						$result = '{ "tx_message": "'.$DB_ERR_LOGIN_PWD.'" }';
					}
	    }else{
			  header($R_401);
			  $result = '{ "tx_message": "'.$DB_ERR_LOGIN_EMAIL.'" }';
		  }
	  }else{
		  header($R_401);
		  $result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
	  }
}else{
	header($R_401);
	$result = '{ "tx_message": "'.$DB_ERR_INS_VAL.'E-mail e Senha." }';
}
		
return $result;
```

O código será comentado em aula. Não esqueça de salvar os scripts!

Abra o arquivo `/tasks/task.php`. Vamos modificar alguns métodos.

Altere o método "set tag" de acordo:

```
function set_ch_tag($tag){
  if($tag != 'todo' && $tag != 'doing' && $tag != 'done')
	  $this->ch_tag = 'todo';
  else
		$this->ch_tag = $tag;
}
```
Adicione os dois métodos mostrados abaixo, para conseguirmos converter de forma prática as datas da classe.

```
function get_dt_created_from_l(){
  $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	@$date->setTimestamp($this->dt_created);
	return $date->format('Y-m-d H:i:s');
}
  
function set_dt_deadline_from_l($dt){
	$date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
	@$date->setTimestamp($dt);
  $this->dt_deadline = $date->format('Y-m-d H:i:s');
}
```

Salve o script e vamos para a parte final! Agora vamos construir as requisições para as tarefas. Abra/Crie o arquivo `/tasks/index.php`. 

Obs: todo o código será comentado durante a aula.

Primeiro bloco de código: declarar tipo de retorno no header, importar as variáveis de Miscellaneous, adquirir o tipo de requisição e programar o `switch case` de acordo com o código abaixo:

```
switch($method)
{
	case 'GET':
		$result = request_get();
		break;
	case 'POST':
		$result = request_post();
		break;
	case 'PUT':
		$result = request_put();
		break;
	case 'DELETE':
		$result = request_delete();
		break;
	default:
		header($R_405);
  	$result = '{ "tx_message": "'.$ERR_405.'"}';
}

echo($result);
```

Uma função para cada tipo de requisição. Observe que todos retornam a mensagem final, qual é apresentada pelo comando `echo` após o switch case. Agora, vamos às funções:

## POST
```
require '../Miscellaneous.php';
require './task.php';
require '../login/auth.php';
		
// acessa os Headers da requisição
$headers = apache_request_headers();
		
// valida o token
if(!isset($headers["token"]) || empty($headers["token"])){
	header($R_400);
	$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
	return $result;
}

$user = check_auth($headers["token"]);
if(!$user){
	header($R_401);
	$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
	return $result;
}

// valida e insere os dados no banco
if(
	(isset($_POST["tx_title"]) && !empty($_POST["tx_title"])) &&
	(isset($_POST["ch_tag"]) && !empty($_POST["ch_tag"])) &&
	(isset($_POST["dt_deadline"]) && !empty($_POST["dt_deadline"]))
){
	$n_reg = new Task("", $_POST["tx_title"], $_POST["tx_description"], $_POST["ch_tag"], "", $_POST["dt_deadline"]);
	$n_reg->set_dt_deadline_from_l( $n_reg->get_dt_deadline() );
			
	include_once '../DBManager.php';
	$dbm = new DBManager();
	if($dbm->db_connect()){
		$sql = "INSERT INTO tasks (tx_title, tx_description, ch_tag, dt_deadline, id_user) VALUES ('".$n_reg->get_title()."', '".$n_reg->get_description()."', '".$n_reg->get_ch_tag()."', '".$n_reg->get_dt_deadline()."', '".$user->get_id()."')";
		$result = $dbm->db_exec_sql($sql);
		if($result == "1" || $result == 1){
			header($R_200);
			$result = '{ "tx_message": "'.$DB_SUC_INS.'" }';
		}else{
			header($R_401);
			$result = '{ "tx_message": "'.$DB_ERR_INS.'" }';
		}
	}else{
		header($R_401);
		$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
	}
}else{
	header($R_400);
	$result = '{ "tx_message": "'.$DB_ERR_INS_VAL.'Título, Status e Prazo." }';
}
		
return $result;
```
## GET
```
require '../Miscellaneous.php';
		require './task.php';
		require '../login/auth.php';
		
		// acessa os Headers da requisição
		$headers = apache_request_headers();
		
		// valida o token
		if(!isset($headers["token"]) || empty($headers["token"])){
			header($R_400);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}
		
		$user = check_auth($headers["token"]);
		if(!$user){
			header($R_401);
			$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
			return $result;
		}

		include_once '../DBManager.php';
		$dbm = new DBManager();
		if($dbm->db_connect()){
			$sql = "SELECT * FROM tasks WHERE id_user='".$user->get_id()."'";
			$db_res = $dbm->db_exec_sql($sql);

			if ($db_res->num_rows > 0) {
				$result = '[';
				while($row = $db_res->fetch_assoc()) {
					$dt_c = strtotime($row["dt_created"]);
					$dt_d = strtotime($row["dt_deadline"]);
					$result .= '{ "_id": "'.$row["_id"].'", "tx_title": "'.$row["tx_title"].'", "tx_description": "'.$row["tx_description"].'", "ch_tag": "'.$row["ch_tag"].'", "dt_created": "'.$dt_c.'", "dt_deadline": "'.$dt_d.'" },';
				}
				$result = substr($result, 0, -1);
				$result .= ']';
				header($R_200);
			} else {
				$result = '{ "tx_message": "'.$DB_SUC_GET_EMP.'" }';
				header($R_200);
			}
		}else{
			header($R_401);
			$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
		}
		
		return $result;
```
## PUT
```
require '../Miscellaneous.php';
require './task.php';
require '../login/auth.php';
		
// acessa os Headers da requisição
$headers = apache_request_headers();
parse_str(file_get_contents("php://input"), $put_params);
		
// valida o token
if(!isset($headers["token"]) || empty($headers["token"])){
	header($R_400);
	$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
	return $result;
}
		
$user = check_auth($headers["token"]);
if(!$user){
	header($R_401);
	$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
	return $result;
}
		
$u_reg = new Task("", "", "", "", "", "");
if((!isset($put_params['id_task']) || empty($put_params['id_task']))){
	header($R_400);
	$result = '{ "tx_message": "'.$ERR_400.'" }';
	return $result;
}
		
$u_reg->set_id($put_params['id_task']);

if(isset($put_params['ch_tag']) && !empty($put_params['ch_tag'])){
	$u_reg->set_ch_tag($put_params['ch_tag']);
}

if(isset($put_params['dt_deadline']) && !empty($put_params['dt_deadline'])){
	$u_reg->set_dt_deadline_from_l($put_params['ch_tag']);
}
		
include_once '../DBManager.php';
$dbm = new DBManager();
if($dbm->db_connect()){
	$sql = "UPDATE tasks SET";
			
	if($u_reg->get_ch_tag() == "" || $u_reg->get_dt_deadline() == ""){
		header($R_400);
		$result = '{ "tx_message": "'.$DB_ERR_UP_VAL.' Status ou Prazo" }';
		return $result;
	}
			
	if($u_reg->get_ch_tag() != "" && $u_reg->get_ch_tag() == $put_params['ch_tag']){
		$sql .= " ch_tag='".$u_reg->get_ch_tag()."'";
		if($u_reg->get_dt_deadline() != "")
			$sql .= ",";
	}
			
	if($u_reg->get_dt_deadline() != ""){
		$sql .= " dt_deadline='".$u_reg->get_dt_deadline()."'";
	}
			
	$sql .= " WHERE _id='".$u_reg->get_id()."'";
		
	if($dbm->db_exec_sql($sql)){
		header($R_200);
		$result = '{ "tx_message": "'.$DB_SUC_UP.'" }';
	}else{
		header($R_401);
		$result = '{ "tx_message": "'.$DB_ERR_UP.'" }';
	}
}else{
	header($R_401);
	$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
}

return $result;
```
## DELETE
```
require '../Miscellaneous.php';
require './task.php';
require '../login/auth.php';
		
// acessa os Headers da requisição
$headers = apache_request_headers();
		
// valida o token
if(!isset($headers["token"]) || empty($headers["token"])){
	header($R_400);
	$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
	return $result;
}
		
$user = check_auth($headers["token"]);
if(!$user){
	header($R_401);
	$result = '{ "tx_message": "'.$SESS_ERR_TOKEN.'" }';
	return $result;
}
		
$u_reg = new Task("", "", "", "", "", "");
if((!isset($_GET['id_task']) || empty($_GET['id_task']))){
	header($R_400);
	$result = '{ "tx_message": "'.$ERR_400.'" }';
	return $result;
}
		
$u_reg->set_id($_GET['id_task']);

include_once '../DBManager.php';
$dbm = new DBManager();
if($dbm->db_connect()){
	$sql = "DELETE FROM tasks WHERE _id='".$u_reg->get_id()."'";
		
	if($dbm->db_exec_sql($sql)){
		header($R_200);
		$result = '{ "tx_message": "'.$DB_SUC_DEL.'" }';
	}else{
		header($R_401);
		$result = '{ "tx_message": "'.$DB_ERR_DEL.'" }';
	}
}else{
	header($R_401);
	$result = '{ "tx_message": "'.$DB_ERR_CONN.'" }';
}
		
return $result;
```

Salve o script e teste todas as requisições. Não se esqueça de efetuar o login antes!





