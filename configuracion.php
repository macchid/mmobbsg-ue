<?php
/*
 * Created on 03/05/2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

	$database = pg_connect("dbname=slave port=5432 user=slave password=master");
	session_start();

	function logMessage($msj){
		$url = getURL();
		$usuario = $_SESSION['usuario'];
		$logQuery = "INSERT INTO log VALUES (current_date,'$url','$msj','$usuario')";
		pg_query($logQuery);
	}

	function getURL() {
		$pageURL = 'http';
		
		if ($_SERVER["HTTPS"] == "on") $pageURL .= "s";
		
		$pageURL .= "://".$_SERVER["SERVER_NAME"];
 
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= ":".$_SERVER["SERVER_PORT"];
		}

		$pageURL .= $_SERVER["REQUEST_URI"];

 		return $pageURL;
	}

?>
