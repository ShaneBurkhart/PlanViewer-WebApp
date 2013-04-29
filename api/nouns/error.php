<?php
	class Error extends Noun {
		
		function get(){
			header("Content-Type: text/html");
			$errorModel = new Error_Model();
			$a = $errorModel->getErrors();
			foreach ($a as $key => $value)
				echo $value["date"] . "</br>" . $value["message"] . "</br></br>";
		}

		function post(){
			if(!isset($this->data["message"]))
				die("Dead");
			$errorModel = new Error_Model();
			$errorModel->create($this->data["message"]);
		}

		function put(){
			die("Nothing");
		}

		function delete(){
			die("Nothing");
		}
	}
?>