<?php
	class File extends Noun {
		
		function get(){
			$jobModel = new Job_Model();
			//get vars from URI
			if(isset($this->URIParts[3]) and is_numeric($this->URIParts[3]))
				$this->data["id"] = $this->URIParts[3];
			if(!isset($this->data["id"]))//Display All Jobs
				$this->sendJSON($jobModel->getJobs());
			//elseif(isset($this->data["uid"])) 							//Display Jobs by user
			//	$this->sendJSON($jobModel->getJobsByUser($this->data["uid"]));
			else 														//Display Job by id
				$this->sendJSON($jobModel->getJob($this->data["id"]));
		}

		function post(){
			$jobModel = new Job_Model();
			if(!isset($this->data["name"]))
				die("No names"); // send response
			
			if($id = $jobModel->create($this->data["name"]))
				$this->sendJSON(array("id" => $id, "name" => $this->data["name"]));
			else
				$this->sendJSON(array("id" => $jobModel->getJobID($this->data["name"]), "name" => $this->data["name"]));
		}

		function put(){
			$jobModel = new Job_Model();
			if(!isset($this->data["id"]) or !isset($this->data["name"]))
				;//send failed response
			$jobModel->rename($this->data["id"], $this->data["name"]);
			$this->sendJSON($jobModel->getJobs());
		}

		function delete(){
			$jobModel = new Job_Model();
			//Get the id from uri
			if(count($this->URIParts) >= 4 and is_numeric($this->URIParts[3]))
				$id = $this->URIParts[3];
			else
				exit;
			$jobModel->delete($id);
			$this->sendJSON($jobModel->getJobs());	
		}
	}
?>