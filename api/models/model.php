<?php
	class Model{
		public $db;
		public function __construct(){
			$this->db = $GLOBALS['db'];
		}
		public function __destruct(){
		}
	}
?>