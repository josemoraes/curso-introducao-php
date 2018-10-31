<?php 
session_start();
include_once "Request.php"; # Importo a classe, para criar objeto de requisição

class Task{
	protected $request;

	public function __construct(){

		$this->request = isset($_SESSION['user']) 
							? new Request('http://appserver.local/tasks', $_SESSION['user']['tx_token'])
							: new Request('http://appserver.local/tasks');
	}

	public function getTask($id = null){

	}

	public function getAllTasks(){

	}

	public function deleteTasks($id = null){
		
	}

}