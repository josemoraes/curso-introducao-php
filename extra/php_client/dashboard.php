<?php
	session_start();
	if(! isset($_SESSION['user'])){
		header('Location: http://appcurso.local/index.php');
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<title>Introdução à Programação Web com PHP</title>
	<link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
	<header>
		<nav class="container">
			<ul>
				<li><h1 class="logo">Minhas Tarefas</h1></li>
				<li class="right"><a href="controller/users/logout.php">logout</a></li>
			</ul>
		</nav>
	</header>
	<main class="dashboard">
		<?php if(isset($_GET['msg'])): ?>
			<div class="toast show"><?php echo $_GET['msg']; ?> <span class="close">X</span></div>
		<?php endif; ?>
		<section id="do">
			<h2 class="board-title">Para Fazer</h2>
			<div class="contents">
				<!-- MODELO PADRÃO DE CARD -->
				<div class="card">
					<div class="card-header"><h3>Título da tarefa aklsçdasçld kaslçd kajsfka dsjkldjskladjlkasjd</h3><span class="prazo">21/09/2018 15:30</span></div>
					<div class="card-content">
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta eos voluptate eligendi non iste tempora quasi quae impedit ullam minima ex consequatur, nobis asperiores libero quas expedita nam enim vel.
						</p>
					</div>
					<div class="card-footer">
						<a href="#" class="btn delete">Excluir</a>
						<a href="#" class="btn">Editar</a>
					</div>
				</div>

			</div>
		</section>
		<section id="doing">
			<h2 class="board-title">Fazendo</h2>
			<div class="contents"></div>
		</section>
		<section id="done">
			<h2 class="board-title">Feito</h2>
			<div class="contents"></div>
		</section>
	</main>
	<footer>
		(SEU NOME). 2018. Introdução à Programação Web com PHP
	</footer>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/dashboard.js"></script>
</body>
</html>