<?php
session_start();
if(isset($_SESSION['user'])){
	header('Location: http://localhost/app-curso/index.php');
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Introdução à Programação Web com PHP</title>
	<link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
	<section class="container">
		<?php if(isset($_GET['msg']) && !empty($_GET['msg'])): ?>
			<div class="toast show"><?php echo $_GET['msg']; ?> <span class="close">X</span></div>
		<?php endif; ?>
		<fieldset id="form-login">
			<h1>Login</h1>
			<form action="controller/users/login.php" method="POST">
				<label for="tx_email">E-mail</label>
				<input type="email" name="tx_email" id="tx_email" class="form-field" required>
				<br>
				<label for="tx_password">Senha</label>
				<input type="password" name="tx_password" id="tx_password" class="form-field" required>
				<br>
				<a href="#" id="show-cadastro" class="action-link">Não é cadastrado? Clique aqui e cadastre-se</a>
				<input type="submit" value="Entrar">
			</form>
		</fieldset>
		<fieldset id="form-cadastro">
			<h1>Cadastre-se</h1>
			<form action="controller/users/add.php" method="POST">
				<label for="tx_name">Nome</label>
				<input type="text" name="tx_name" id="tx_name" class="form-field" required>
				<br>
				<label for="tx_email_cadastro">E-mail</label>
				<input type="email" name="tx_email" id="tx_email_cadastro" class="form-field" required>
				<br>
				<label for="tx_password_cadastro">Senha</label>
				<input type="password" name="tx_password" id="tx_password_cadastro" class="form-field" required>
				<br>
				<a href="#" id="show-login" class="action-link">Voltar para login</a>
				<input type="submit" value="Finalizar Cadastro">
			</form>
		</fieldset>
	</section>
	<footer>
		(SEU NOME). 2018. Introdução à Programação Web com PHP
	</footer>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/login.js"></script>
</body>
</html>