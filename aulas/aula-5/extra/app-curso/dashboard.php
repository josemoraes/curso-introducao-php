<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Location: http://localhost/app-curso/index.php');
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
				<li class="right"><a href="#" id="new-task" data-ref="new-task" class="btn">Nova Tarefa</a></li>
			</ul>
		</nav>
	</header>
	<main class="dashboard">
		<?php if(isset($_GET['msg']) && !empty($_GET['msg'])): ?>
			<div class="toast show"><?php echo $_GET['msg']; ?> <span class="close">X</span></div>
		<?php endif; ?>
		<section id="do">
			<h2 class="board-title">Para Fazer</h2>
			<div class="contents">
				<div class="card">
					<div class="card-header"><h3>Título da Tarefa</h3><span class="prazo">31/10/2018 21:00</span></div>
					<div class="card-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed alias quia deserunt fuga cum maxime unde sequi...</p>
					</div>
					<div class="card-footer">
						<form action="#" method="POST" class="delete-task">
							<input type="hidden" name="id_task" value="" method="DELETE">
							<button type="submit" class="btn delete">Excluir</button>
						</form>
						<a href="#" class="btn">Editar</a>
					</div>
				</div>
			</div>
		</section>
		<section id="doing">
			<h2 class="board-title">Fazendo</h2>
			<div class="contents">
				<div class="card">
					<div class="card-header"><h3>Título da Tarefa</h3><span class="prazo">31/10/2018 21:00</span></div>
					<div class="card-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed alias quia deserunt fuga cum maxime unde sequi...</p>
					</div>
					<div class="card-footer">
						<form action="#" method="POST" class="delete-task">
							<input type="hidden" name="id_task" value="" method="DELETE">
							<button type="submit" class="btn delete">Excluir</button>
						</form>
						<a href="#" class="btn">Editar</a>
					</div>
				</div>
			</div>
		</section>
		<section id="done">
			<h2 class="board-title">Feito</h2>
			<div class="contents">
				<div class="card">
					<div class="card-header"><h3>Título da Tarefa</h3><span class="prazo">31/10/2018 21:00</span></div>
					<div class="card-content">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed alias quia deserunt fuga cum maxime unde sequi...</p>
					</div>
				</div>
			</div>
		</section>
	</main>
	<footer>
		(SEU NOME). 2018. Introdução à Programação Web com PHP
	</footer>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.mask.js"></script>
<script src="assets/js/dashboard.js"></script>
</body>
</html>