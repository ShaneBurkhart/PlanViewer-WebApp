<?php
	class Page_Model extends Model{

		public function getPagesByJobID($jid){
			$query = "	SELECT *
						FROM pages
						WHERE job_id = ?
						ORDER BY page_num ASC";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $jid);
			$stmt->execute();
			$stmt->bind_result($id, $date, $jobId, $pageName, $pageNum, $filename, $version);
			$f = array();
			while($stmt->fetch())
				$f[] = array("id" => $id , "date" => $date, "jobId" => $jobId, "pageName" => $pageName, "pageNum" => $pageNum, "filename" => $filename, "version" => $version);
			if($stmt)
				$stmt->close();
			return $f;
		}

		public function getPage($id){
			$query = "	SELECT *
						FROM pages
						WHERE id = ?
						ORDER BY page_num ASC";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt->bind_result($id, $date, $jobId, $pageName, $pageNum, $filename, $version);
			if($stmt->fetch())
				$p = array("id" => $id , "date" => $date, "jobId" => $jobId, "pageName" => $pageName, "pageNum" => $pageNum, "filename" => $filename, "version" => $version);
			else
				$p = array();
			if($stmt)
				$stmt->close();
			return $p;
		}

		public function getPageID($jid, $pageName){
			$query = "	SELECT id
						FROM pages
						WHERE job_id = ? AND page_name = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("is", $jid, $pageName);
			$stmt->execute();
			$stmt->bind_result($id);
			if(!$stmt->fetch())
				$id = 0;
			if($stmt)
				$stmt->close();
			return $id;
		}

		public function create($jid, $pageName){
			if($this->getPageID($jid, $pageName))
				return 0;
			$pageNum = $this->getHightestPageNum($jid) + 1;
			$query = "	INSERT INTO pages(page_num, job_id, page_name) VALUES (?, ?, ?)";
			$stmt = $this->db->prepare($query);

			$stmt->bind_param("iis", $pageNum, $jid, $pageName);
			if($stmt->execute())
				return $this->db->insert_id;
			else 
				return 0;
		}

		public function update($id, $jid, $pageNum){
			$query = "	UPDATE pages SET page_num = ?
						WHERE id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("ii", $pageNum, $id);
			if(!$stmt->execute())
				return;
			if($stmt)
				$stmt->close();
			$query = "	UPDATE pages SET page_num = page_num + 1
						WHERE job_id = ? AND page_num >= ? AND id != ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("iii", $jid, $pageNum, $id);
			$stmt->execute();
			if($stmt)
				$stmt->close();
		}

		public function delete($id){
			$query = "	DELETE FROM pages 
						WHERE id = ?";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $id);
			if(!$stmt->execute())
				return;
			if($stmt)
				$stmt->close();
		}

		public function getHightestPageNum($jid){
			$query = "	SELECT page_num
						FROM pages
						WHERE job_id = ?
						ORDER BY page_num DESC
						LIMIT 0, 1";
			$stmt = $this->db->prepare($query);
			$stmt->bind_param("i", $jid);
			$stmt->execute();
			$stmt->bind_result($pageNum);
			if(!$stmt->fetch())
				$pageNum = 0;
			if($stmt)
				$stmt->close();
			return $pageNum;
		}
	}
?>