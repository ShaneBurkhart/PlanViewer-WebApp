<?php
	class Assignment extends Noun {
		
		function get(){
			$assignmentModel = new Assignment_Model();
			$jobModel = new Job_Model();

			if(isset($this->URIParts[3]) and is_numeric($this->URIParts[3]))
				$this->data["id"] = $this->URIParts[3];
			else
				die("No");
			
			$assigns = $assignmentModel->getAssignmentsForUser($this->data["id"]);
			$jobs = $jobModel->getJobs();

			for($i = 0 ; $i < count($jobs) ; $i ++){
				$jobs[$i]["userId"] = $this->data["id"];
				for($j = 0 ; $j < count($assigns) ; $j ++){
					if($assigns[$j]["jobId"] == $jobs[$i]["id"]){
						$jobs[$i]["assignment"] = 1;
						break;
					}
				}
				if(!isset($jobs[$i]["assignment"]))
					$jobs[$i]["assignment"] = 0;
			}

			$this->sendJSON($jobs);
		}

		function post(){
			die("No");
		}

		function put(){
			$assignmentModel = new Assignment_Model();

			$assignmentModel->update($this->data["userId"], $this->data["id"], $this->data["assignment"]);
		}

		function delete(){
			die("No");
		}
	}
?>