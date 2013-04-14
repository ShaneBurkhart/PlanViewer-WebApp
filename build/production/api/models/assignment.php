<?php

	class Assignment_Model extends Model{

		public function getAssignmentsForUser($uid){
			$query = "	SELECT *
						FROM assignments
						WHERE user_id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $uid);
			$stmt->execute();
			$stmt->bind_result($userId, $jobId);
			$a = array();
			while($stmt->fetch())
				$a[] = array("userId" => $userId, "jobId" => $jobId);
			return $a;
		}

		public function update($userId, $jobId, $assign){
			$e = $this->exists($userId, $jobId);
			if(!$assign and $e)
				$this->delete($userId, $jobId);
			else if($assign and !$e)
				$this->add($userId, $jobId);
		}

		public function add($userId, $jobId){
			$query = "	INSERT INTO assignments(user_id, job_id)
						VALUES(?, ?)";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("ii", $userId, $jobId);
			$r = $stmt->execute();
			if($stmt)
				$stmt->close();
			return $r;
		}

		public function delete($userId, $jobId){
			$query = "	DELETE FROM assignments
						WHERE user_id = ? 
						AND job_id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("ii", $userId, $jobId);
			$r = $stmt->execute();
			if($stmt)
				$stmt->close();
			return $r;
		}

		public function exists($userId, $jobId){
			$query = "	SELECT *
						FROM assignments
						WHERE user_id = ?
						AND job_id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("ii", $userId, $jobId);
			$stmt->execute();
			$stmt->bind_result($jid, $uid);
			$r = $stmt->fetch();
			if($stmt)
				$stmt->close();
			return $r;
		}
	}
?>