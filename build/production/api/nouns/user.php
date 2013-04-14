<?php
	class User extends Noun {
		
		function get(){
			$userModel = new User_Model();
			if(isset($this->URIParts[3]) and is_numeric($this->URIParts[3]))
				$this->data["id"] = $this->URIParts[3];
			if(!isset($this->data["id"]) and !isset($this->data["uid"]))//Display All Users
				$this->sendJSON($userModel->getUsers());
			else 														
				$this->sendJSON($userModel->getUser($this->data["id"]));
		}

		function post(){
			$userModel = new User_Model();
			if(!isset($this->data["name"]) or !isset($this->data["email"]))
				die("No names"); // send response
			
			if($id = $userModel->create($this->data["name"], $this->data["email"]))
				$this->sendJSON($userModel->getUser($id));
			else
				$this->sendJSON($userModel->getUser($userModel->getUserID($this->data["name"])));
		}

		function put(){
			$userModel = new User_Model();
			if(!isset($this->data["id"]) or !isset($this->data["name"]))
				exit();//send failed response
			$userModel->rename($this->data["id"], $this->data["name"]);
			$this->sendJSON($userModel->getUsers());
		}

		function delete(){
			$userModel = new User_Model();
			//Get the id from uri
			if(count($this->URIParts) >= 4 and is_numeric($this->URIParts[3]))
				$id = $this->URIParts[3];
			else
				exit;
			$userModel->delete($id);
			$this->sendJSON($userModel->getUsers());	
		}
	}
?>