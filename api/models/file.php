<?php
	class File_Model extends Model{

		public function getFilesByJobID($jid){
			$query = "	SELECT *
						FROM files
						WHERE job_id = ?
						ORDER BY page_num ASC";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $jid);
			$stmt->execute();
			$stmt->bind_result($id, $date, $jobId, $pageNum, $filename, $version);
			$f = array();
			while($stmt->fetch())
				$f[] = array("id" => $id , "date" => $date, "jobId" => $jobId, "pageNum" => $pageNum, "filename" => $filename, "version" => $version);
			if($stmt)
				$stmt->close();
			return $f;
		}

		public function getUser($id){
			$query = "	SELECT *
						FROM users
						WHERE id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($id, $name);
			$p = array();
			while($stmt->fetch())
				$p[] = array("id" => $row[0] , "name" => $row[1]);
			if($stmt)
				$stmt->close();
			return $p;
		}

		public function create($user){
			if($this->getUserID($user))
				return 0;
			$query = "	INSERT INTO users(job_name) VALUES (?)";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("s", $job);
			if($stmt->execute())
				return $this->db->insert_id;
			else 
				return 0;
		}

		public function getJobID($n){
			$query = "	SELECT id
						FROM jobs
						WHERE job_name = ?";
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

		public function delete($jid){
			$query = "	DELETE FROM jobs
						WHERE id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $jid);
			$r1 = $stmt->execute();

			$query = "	DELETE FROM assignments
						WHERE job_id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $jid);
			$r2 = $stmt->execute();

			//Delete files
			$query = "	SELECT id
						FROM files
						WHERE job_id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $jid);
			$stmt->execute();
			$stmt->bind_result($id);
			while($stmt->fetch()){
				$f = SITE_ROOT . "/files/" + $id + ".pdf";
				while(file_exists($f))
					unlink($f);
			}

			$query = "	DELETE FROM files
						WHERE job_id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $jid);
			$r3 = $stmt->execute();

			if($r1 and $r2 and $r3)
				return 1;
			else 
				return 0;
		}
	}
?>