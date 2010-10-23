<?php
	include('../configuracion.php');
	include_once('../auth.php');
	control();
	echo $_POST['id'];

	$query  = "DELETE FROM detalle_atracos WHERE id = " . $_POST['id'];
	$query .= "   AND usuario = '".$_SESSION['usuario']."'";
	$result = pg_query($query);
?>