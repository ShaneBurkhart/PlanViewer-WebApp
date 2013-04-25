<?php
	class Mobile extends Noun {
		
		function get(){
			die("Nothing");
		}

		function post(){
			$userModel = new User_Model();
			if(!isset($this->data["username"]) or !isset($this->data["password"]))
				die("No creds"); // send response
			
			if(!($id = $userModel->login($this->data["username"], $this->data["password"])))
				die('0');
			$jobModel = new Job_Model();
			$pageModel = new Page_Model();
			//Get jobs
			$jobs = $jobModel->getJobsByUser($id);
			//Add files to jobs
			for($i = 0 ; $i < count($jobs) ; $i ++)
				$jobs[$i]["pages"] = $pageModel->getPagesByJobID($jobs[$i]["id"]);
			$this->sendJSON($jobs);
		}

		function put(){
			die("Nothing");
		}

		function delete(){
			die("Nothing");
		}
	}
?>