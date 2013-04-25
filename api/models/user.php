<?php
	class User_Model extends Model{

		public function getUsers(){
			$query = "	SELECT *
						FROM users
						ORDER BY id DESC";
			$stmt = $this->db->query($query);
			$p = array();
			while($row = $stmt->fetch_row()){
				$p[] = array("id" => $row[0] , "name" => $row[1], "email" => $row[2]);
			}
			if($stmt)
				$stmt->close();
			return $p;
		}

		public function getUser($id){
			$query = "	SELECT *
						FROM users
						WHERE id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($id, $name, $email, $hash, $salt);
			$p = array();
			if($stmt->fetch())
				$p = array("id" => $id , "name" => $name, "email" => $email);
			if($stmt)
				$stmt->close();
			return $p;
		}

		public function create($user, $email){
			if($this->getUserID($user))
				return 0;
			$pass = $this->generatePassword();
			$query = "	INSERT INTO users(username, email, hash, salt) VALUES (?, ?, ?, ?)";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("ssss", $user, $email, $pass["hash"], $pass["salt"]);
			if($stmt->execute())
				return array("id" => $this->db->insert_id, "username" => $user, "email" => $email, "password" => $pass["password"], "hash" => $pass["hash"], "salt" => $pass["salt"]);
			else 
				return 0;
		}

		public function getUserID($n){
			$query = "	SELECT id
						FROM users
						WHERE username = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("s", $n);
			$stmt->execute();
			$stmt->bind_result($id);
			if($stmt->fetch())
				return $id;
			else
				return 0;
		}

		public function rename($jid, $name){
			$query = "	UPDATE jobs
						SET job_name = ? 
						WHERE id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("si", $name, $jid);
			$r1 = $stmt->execute();
			$stmt->close();
			if($r1)
				$r2 = $this->addOneToAllVersions($jid);
			return $r1 and $r2;
		}

		public function addOneToAllVersions($jid){
			$query = "	UPDATE files
						SET version = version + 1 
						WHERE job_id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $jid);
			$r1 = $stmt->execute();
			$stmt->close();
			return $r1;
		}

		public function delete($uid){
			$query = "	DELETE FROM users
						WHERE id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $uid);
			$r1 = $stmt->execute();

			$query = "	DELETE FROM assignments
						WHERE user_id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $uid);
			$r2 = $stmt->execute();

			return $r1 and $r2;
		}

		public function login($username, $password){
			$user = $this->getUser($this->getUserID($username));
		}

		private function generatePassword() {
		    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		    $pass = array(); //remember to declare $pass as an array
		    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		    for ($i = 0; $i < 8; $i++) {
		        $n = rand(0, $alphaLength);
		        $pass[] = $alphabet[$n];
		    }
		    $user["password"] = implode($pass);
		    $t = $this->toHash($user["password"]);
		    $user["hash"] = $t["hash"];
		    $user["salt"] = $t["salt"];
		    return $user;
		}

		private function toHash($pass){
			$a = array();
			$salt = mcrypt_create_iv(24, MCRYPT_DEV_RANDOM);
			$a['salt'] = $salt;
			$salted_pass = $salt . $pass;
			$hash = hash("sha256", $salted_pass);
			$a['hash'] = $hash;
			return $a;
		}

		private function toHashWithSalt($pass, $salt){
			$a = array();
			$a['salt'] = $salt;
			$salted_pass = $salt . $pass;
			$hash = hash("sha256", $salted_pass);
			$a['hash'] = $hash;
			return $a;
		}
	}
?>