<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	$query = "";
	
	if ( $_POST['modo'] == "insert" ) {
		$query = "INSERT INTO orden (id,inicio,tipo_orden,usuario) VALUES ";
		$query .= "(".$_POST['id'].",";
		$query .= "'".$_POST['inicio']."',";
		$query .= "'".$_POST['tipo']."',";
		$query .= "'".$_SESSION['usuario']."')";
	} else if ($_POST['modo'] == "update" ) {
		$query = " UPDATE orden SET ";
		$query .= " inicio = '".$_POST['inicio']."' ";
		$query .= " WHERE id= ".$_POST['id'];
		$query .= "   AND usuario ='".$_SESSION['usuario']."' ";
	} else if ($_POST['modo'] == "delete" ) {
		$query = "DELETE FROM orden ";
		$query .= "WHERE id='".$_POST['id']."' ";
		$query .= "  AND usuario ='".$_SESSION['usuario']."' ";
	}
	
	echo $query."<br/>";
	
	$result = pg_query($query);
?>