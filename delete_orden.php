<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	echo $_POST['id'];	

	$query = "DELETE FROM orden WHERE id = " . $_POST['id'] . " and usuario = '";
	$query .= $_SESSION['usuario'] . "'";
	$result = pg_query($query);
?>