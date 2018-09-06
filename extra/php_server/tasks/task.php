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

	function set_id($id){
		$this->_id = $id;
	}
	
    function get_id(){
		return $this->_id;
	}
	
	function set_title($title){
		$this->tx_title = $title;
	}
	
	function get_title(){
		return $this->tx_title;
	}
	
	function set_description($description){
		$this->tx_description = $description;
	}
	
	function get_description(){
		return $this->tx_description;
	}
	
	function set_ch_tag($tag){
		if($tag != 'todo' && $tag != 'doing' && $tag != 'done')
			$this->ch_tag = 'todo';
		else
			$this->ch_tag = $tag;
	}
	
	function get_ch_tag(){
		return $this->ch_tag;
	}
	
	function set_dt_created($dt_created){
		$this->dt_created = $dt_created;
	}
	
	function get_dt_created(){
		return $this->dt_created;
	}
	
	function get_dt_created_from_l(){
		$date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
		@$date->setTimestamp($this->dt_created);
		return $date->format('Y-m-d H:i:s');
	}
	
	function set_dt_deadline($dt_deadline){
		$this->dt_deadline = $dt_deadline;
	}
	
	function get_dt_deadline(){
		return $this->dt_deadline;
	}
	
	function get_dt_deadline_l(){
		return strtotime($this->dt_deadline);
	}
	
	function set_dt_deadline_from_l($dt){
		$date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
		@$date->setTimestamp($dt);
		$this->dt_deadline = $date->format('Y-m-d H:i:s');
	}
}
?>