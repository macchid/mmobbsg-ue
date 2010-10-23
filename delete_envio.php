<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	echo $_POST['id'];	

	$query  = "DELETE FROM envio_recursos WHERE id = " . $_POST['id'];
	$result = pg_query($query);
?>