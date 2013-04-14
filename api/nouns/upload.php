<?php
	class Upload extends Noun {
		
		function get(){
			die("No");
		}

		function post(){
			header('Content-type: text/html');
			$uploadModel = new Upload_Model();
			$pageModel = new Page_Model();
			
			if(!isset($_FILES["f"]) or !isset($_POST["pid"]))
				die("No Creds");

			$id = $_POST["pid"];
			$f = $_FILES["f"];

			if(!is_numeric($id))
				die("No Num");

			if(!$pageModel->getPage($id))
				die("No Page");

			$uploadModel->upload($id, $f["tmp_name"], $f["name"]);

			echo 	"<script type=\"text/javascript\">" .
						"(function(){window.parent.app.hideLoading();})()" .
					"</script>";
		}

		function put(){
			die("No");
		}

		function delete(){
			die("No");
		}
	}
?>