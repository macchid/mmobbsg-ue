<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	echo $_POST['id'];	

	$query = "DELETE FROM subir_produccion WHERE id = " . $_POST['id'];
	$result = pg_query($query);
?>