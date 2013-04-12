<?php
	class Page extends Noun {
		
		function get(){
			$pageModel = new Page_Model();
			//get vars from URI
			if(isset($this->URIParts[3]) and is_numeric($this->URIParts[3]))
				$this->data["id"] = $this->URIParts[3];
			if(isset($this->data["id"]))//Display All Jobs
				$this->sendJSON($pageModel->getPagesByJobID($this->data["id"]));
			else
				$this->sendJSON($pageModel->getPages());
		}

		function post(){
			$pageModel = new Page_Model();
			if(!isset($this->data["pageName"]) or !isset($this->data["jobId"]))
				die("No"); 
		
			if(!($id = $pageModel->create($this->data["jobId"], $this->data["pageName"])))
				$id = $pageModel->getPageID($this->data["jobId"], $this->data["pageName"]);
			$this->sendJSON($pageModel->getPage($id));
		}

		function put(){
			$pageModel = new Page_Model();
			if(!isset($this->data["id"]) or !isset($this->data["pageNum"]) or !isset($this->data["jobId"]) or !isset($this->data["direction"]))
				die("No"); 
			
			$pageModel->update($this->data["id"], $this->data["jobId"], $this->data["pageNum"], $this->data["direction"]);		
			$this->sendJSON($pageModel->getPage($this->data["id"]));
		}

		function delete(){
			$pageModel = new Page_Model();
			if(count($this->URIParts) >= 5 and is_numeric($this->URIParts[4]))
				$id = $this->URIParts[4];
			else
				exit;
			$pageModel->delete($id);		
		}
	}
?>