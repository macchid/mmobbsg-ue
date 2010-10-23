<?php
	include('../configuracion.php');
	include('../auth.php');
	control();

	$id = $_POST['id'];
        $usuario = "'".$_SESSION['usuario']."'";

	$query  = "UPDATE detalle_atracos SET ";
	for ( $i = 1; $i < 12; $i++ ){
		if ( $_POST["t$i"] > 0 ){
			$query .= "t$i = ". $_POST["t$i"];
		} else {
			$query .= "t$i = 0";
		}

		if ($i < 11){
			$query .= ", ";
		}
	}
	$query .= " WHERE id = " . $id;

	pg_query($query);
?>
