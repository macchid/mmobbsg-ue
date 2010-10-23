<?php
	include('../configuracion.php');
	include('../auth.php');
	control();

	$id = $_POST['id'];
	$x = $_POST['x'];
	$y = $_POST['y'];
	$nombre = "'".$_POST['nombre']."'";
	$usuario = "'".$_SESSION['usuario']."'";
	
	$query  = "SELECT * FROM vaca";
	$query .= " WHERE id = " . $id;
	$query .= "   AND usuario = " . $usuario;

	if ( pg_num_rows(pg_query($query)) == 0 ) {
		$query  = "INSERT INTO vaca (id, x, y, nombre, usuario) VALUES ";
		$query .= "($id,$x,$y,$nombre,$usuario)";
		pg_query($query);
	}
?>