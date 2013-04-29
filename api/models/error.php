<?php
	class Error_Model extends Model{

		public function getErrors(){
			$query = "	SELECT id, date, message
						FROM errors
						ORDER BY id DESC
						LIMIT 0, 10";
			$stmt = $this->db->query($query);
			$a = array();
			while($row = $stmt->fetch_row())
				$a[] = array("id" => $row[0], "date" => $row[1], "message" => $row[2]);
			$stmt && $stmt->close();
			return $a;
		}

		public function create($msg){
			$query = "	INSERT INTO errors(message) VALUES (?)";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("s", $msg);
			$r = $stmt->execute();
			$stmt && $stmt->close();
			return $r;
		}
	}
?>