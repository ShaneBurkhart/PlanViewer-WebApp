<?php

	class Upload_Model extends Model{

		var $basePath;

		public function __construct(){
			parent::__construct();
			$this->basePath = SERVER_ROOT . "/_files";
		}

		public function upload($pid, $tfname, $fname){
			if(!($this->updateFile($pid, $fname)))
				return 0;
			$this->saveFile($pid, $tfname);
		}

		private function updateFile($pid, $fname){
			$query = "	UPDATE pages 
						SET filename = ?, version = version + 1
						WHERE id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("si", $fname, $pid);
			$r = $stmt->execute();
			if($stmt)
				$stmt->close();
			return $r;
		}

		private function saveFile($pid, $tfname){
			move_uploaded_file($tfname, $this->basePath . "/" . $pid);
		}
	}
?>