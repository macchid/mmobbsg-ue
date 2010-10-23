<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	echo $_POST['id'];	

	$query  = "DELETE FROM construccion WHERE id = " . $_POST['id'] ." and grupo_id = " . $_POST['orden_id'];
	$query .= "   AND usuario = '".$_SESSION['usuario']."'";
	$result = pg_query($query);
?>
