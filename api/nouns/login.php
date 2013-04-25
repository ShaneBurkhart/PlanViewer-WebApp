<?php
	class Job extends Noun {
		
		function get(){
			die("Nothing");
		}

		function post(){
			$userModel = new User_Model();
			if(!isset($this->data["username"]) or !isset($this->data["password"]))
				die("No creds"); // send response
			
			if($id = $jobModel->create($this->data["name"]))
				$this->sendJSON(array("id" => $id, "name" => $this->data["name"]));
			else
				$this->sendJSON(array("id" => $jobModel->getJobID($this->data["name"]), "name" => $this->data["name"]));
		}

		function put(){
			die("Nothing");
		}

		function delete(){
			die("Nothing");
		}
	}
?>