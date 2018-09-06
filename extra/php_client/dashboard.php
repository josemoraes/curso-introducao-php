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
				<li class="right"><a href="#" id="new-task" data-ref="new-task" class="btn">Nova Tarefa</a></li>
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
	
	<div class="modal" data-ref="new-task">
		<span class="close">X</span>
		<div class="modal-wrapper">
			<div class="modal-content">
				<h2 class="page-title">Cadastrar Nova Tarefa</h2>
				<form action="controller/tasks/add.php" method="POST">
					<label for="tx_title">Título</label>
					<input type="text" id="tx_title" name="tx-title" class="form-field" required>
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
					<input type="date" name="dt_deadline" id="dt_deadline" class="form-field">
					<br>
					<input type="submit" class="btn right" value="Salvar Tarefa">
				</form>
			</div>
		</div>	
	</div>

	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/dashboard.js"></script>
</body>
</html>