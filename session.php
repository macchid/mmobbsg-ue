<?php

	include('database.php');

	session_start();

	function login($username, $password)
	{

		try{
			$username = db::escape_string($username);

			#get salt to combine with the typed password, this will be needed for a SQL query to get username and 
			#password combination
			$result = db::select("SELECT salt FROM users WHERE username = '".$username."'");
			$salt = $result[0]['salt'];
			
			$password = db::escape_string($password);
			$password = md5(md5($username).md5($password).md5($salt));

			#check if username and password combination is matching
			$result = db::select("SELECT id, group_id as group, server, breed FROM users WHERE username = '".$username."' AND password = '".$password."' AND active = true");
		
			#if username and password matches put userID in authentication session for later use
			if (count($result) == 1) {
				$row = $result[0];
				$_SESSION['auth_userID'] = $row['id'];
				$_SESSION['auth_username'] = $username;
				$_SESSION['auth_groupID'] = $row['group'];
				$_SESSION['server'] = $row['server'];
				$_SESSION['breed'] = $row['breed'];

				return true;
			}
		
			# if something went wrong don't allow login
			return false;
		}
		catch( Exception $ex)
		{
			echo $ex->getMessage();
			return false;
		}
	}

	function logout()
	{
		unset($_SESSION['auth_userID']);
		unset($_SESSION['auth_groupID']);
		unset($_SESSION['auth_username']);
		unset($_SESSION['server']);
		unset($_SESSION['breed']);
	}
?>
