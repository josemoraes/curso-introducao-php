<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Location: http://appcurso.local/index.php');
}
include_once "model/Request.php"; # Importo a classe, para criar objeto de requisição
$request  = new Request('http://appserver.local/tasks', $_SESSION['user']['tx_token']);
$response = $request->doGet(); 

if(intval($response['code']) == 401)
{
	$msg = $response['result']->tx_message;
	session_unset(); //Remove todas as variáveis da sessão
	session_destroy(); // Destrói a sessão
	header('Location: http://appcurso.local/index.php?msg='.$msg);	
}
# False, significa que cada item, será tratado como objeto, não como array
$tasks   = $response['result'];
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
				<?php if (isset($tasks[0]->_id)): ?>
					<?php foreach ($tasks as $to_do_task): ?>
						<?php if ($to_do_task->ch_tag == 'todo'): ?>
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
									<a href="#" class="btn">Editar</a>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				<?php endif ?>
			</div>
		</section>
		<section id="doing">
			<h2 class="board-title">Fazendo</h2>
			<div class="contents">
				<?php if (isset($tasks[0]->_id)): ?>
					<?php foreach ($tasks as $doing_task): ?>
						<?php if ($doing_task->ch_tag == 'doing'): ?>
							<div class="card">
								<div class="card-header"><h3><?php echo $doing_task->tx_title; ?></h3><span class="prazo"><?php echo empty($doing_task->dt_deadline) ? '' : date('d/m/Y \à\s H:i', $doing_task->dt_deadline); ?></span></div>
								<div class="card-content">
									<p><?php echo $doing_task->tx_description; ?></p>
								</div>
								<div class="card-footer">
									<form action="controller/tasks/delete.php" method="POST" class="delete-task">
										<input type="hidden" name="id_task" value="<?php echo $doing_task->_id ?>" method="DELETE">
										<button type="submit" class="btn delete">Excluir</button>
									</form>
									<a href="#" class="btn">Editar</a>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				<?php endif ?>
			</div>
		</section>
		<section id="done">
			<h2 class="board-title">Feito</h2>
			<div class="contents">
				<?php if (isset($tasks[0]->_id)): ?>
					<?php foreach ($tasks as $done_task): ?>
						<?php if ($done_task->ch_tag == 'done'): ?>
							<div class="card">
								<div class="card-header"><h3><?php echo $done_task->tx_title; ?></h3><span class="prazo"><?php echo empty($done_task->dt_deadline) ? '' : date('d/m/Y \à\s H:i', $done_task->dt_deadline); ?></span></div>
								<div class="card-content">
									<p><?php echo $done_task->tx_description; ?></p>
								</div>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				<?php endif ?>
			</div>
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

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.mask.js"></script>
<script src="assets/js/dashboard.js"></script>
</body>
</html>