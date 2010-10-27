<?php
	include('config.php');
	
	#Database exceptions
	class NoDataFoundException extends Exception {
		function __construct($sql){ parent::__construct("No data found:".$sql); }
	}

	class TooManyRowsException extends Exception {
		function __construct($sql){ parent::__construct("Too many rows:".$sql); }
	}

	class DatabaseException extends Exception {
		function __construct($msg) 
		{ 		
			parent::__construct($msg); 	
		}
	}

	switch($vendor){
		case 'postgres':
			include('database/postgres.php');
			break;

		case 'mysql':
			include('database/mysql.php');
			break;

		default:
			die('Database not supported');

	}
?>
