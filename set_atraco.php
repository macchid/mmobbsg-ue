<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	$query = "";

	if ( $_POST['modo'] == "insert" ) {
		$query  = "INSERT INTO atraco (id, id_atraco, id_fila, usuario, siguiente) VALUES (";
		$query .= $_POST['id'].",";
		$query .= $_POST['atraco'].",";
		$query .= $_POST['queue'].",";
		$query .= "'".$_SESSION['usuario']."',";
		$query .= $_POST['siguiente'].")";
	} else if ( $_POST['modo'] == "delete" ) {
		$query  = "DELETE FROM atraco ";
		$query .= " WHERE id_queue =".$_POST['queue'];
		$query .= "   AND usuario = '".$_SESSION['usuario']."'";
	}

	echo $query."<br/>";	
	
	$result = pg_query($query);
?>
