<?php
	class Noun {
		var $URI, $URIParts, $data;
		function get(){

		}
		function post(){

		}
		function delete(){

		}
		function put(){

		}
		function sendJSON($array){
			echo json_encode($array);
		}
		function setURI($uri){
			$this->URI = $uri;
		}
		function setURIParts($uriParts){
			$this->URIParts = $uriParts;
		}
		function setData($data){
			$this->data = $data;
		}
	}
?>