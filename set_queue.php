<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	$query = "";

	if ( $_POST['modo'] == "insert" ) {
		$query  = "INSERT INTO fila (id, usuario, front, rear) VALUES (";
		$query .= $_POST['id'].",";
		$query .= "'".$_SESSION['usuario']."',";
		$query .= $_POST['front'].",";
		$query .= $_POST['rear'].")";
	} else if ( $_POST['modo'] == 'update') {
		$query  = "UPDATE fila SET";
		$query .= " 	front = ".$_POST['front'];
		$query .= " WHERE id = ".$_POST['id'];
		$query .= "   AND usuario = '".$_SESSION['usuario']."'";
	} else if ( $_POST['modo'] == "delete" ) {
		$query  = "DELETE FROM fila ";
		$query .= " WHERE id =".$_POST['id'];
		$query .= "   AND usuario = '".$_SESSION['usuario']."'";
	}

	echo $query."<br/>";	
	
	$result = pg_query($query);
?>
