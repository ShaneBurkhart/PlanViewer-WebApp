<?php
	//class loader so we dont have to do the shit with the includes.
	function aloader($classname){
		list($filename) = explode("_", $classname);
		$fname = "models/" . strtolower($filename) . ".php";
		if(file_exists($fname)){
			include_once($fname);
		}else{
			//header("Location: /pagenotfound");
			die("Not found $classname, $fname");
		}
	}
	spl_autoload_register('aloader');

	define("SERVER_ROOT", $_SERVER["DOCUMENT_ROOT"]);

	ini_set("log_errors", 1);
	ini_set("error_log", SERVER_ROOT . "/php-error.log");

	//Boiler Plate include
	include("nouns/noun.php");

	//Specify JSON
	header('Content-type: application/json');

	//Fetch request VARS
	$requestMethod = strtolower($_SERVER["REQUEST_METHOD"]);
	$requestURI = $_SERVER["REQUEST_URI"];
	
	//Get data
	switch ($requestMethod){  
        case 'get':  
            $data = $_GET;  
            break;  
        case 'post':  
        case 'put': 
        case 'delete':
            $data = json_decode(file_get_contents('php://input'), true);  
            break; 
    }

    //Process URI
    $temp = explode("?", $requestURI);
	$URIParts = explode("/", $temp[0]);
	if($URIParts[1] != "api")
		die("Not API");

	//Route the request to appropriate noun
	$noun = $URIParts[2];
	$filePath = "nouns/" . $noun . ".php";
	if(file_exists($filePath))
		include($filePath);
	else
		die("File DNE " . $filePath);
	$className = ucfirst($noun);
	if(class_exists($className))
		$class = new $className();
	else
		die("Class DNE");

	//Init DB after class verification
	include("config.php");
	$db = new mysqli($server, $user, $pass, $db_name);
	if($db->errno){
		die("Could not connect");
	}
	$GLOBALS['db'] = $db;

	//Init the noun
	$class->setURI($requestURI);
	$class->setURIParts($URIParts);
	$class->setData($data);

	//Call the appropriate method
	if(method_exists($class, $requestMethod))
		$class->$requestMethod();
	else
		die("Method DNE");
?>