<?php
	include('../configuracion.php');
	include('../auth.php');
	control();

        $x = $_POST['x'];
        $y = $_POST['y'];
	$destino = $_POST['d'];
	$origen = $_POST['o'];
        $nombre = "'".$_POST['nombre']."'";
        $usuario = "'".$_SESSION['usuario']."'";

        $query  = "SELECT * FROM vaca";
        $query .= " WHERE id = " . $destino;
        $query .= "   AND usuario = " . $usuario;

        if ( pg_num_rows(pg_query($query)) == 0 ) {
                $query  = "INSERT INTO vaca (id, x, y, nombre, usuario) VALUES ";
                $query .= "($destino,$x,$y,$nombre,$usuario)";
                pg_query($query);
        }
	
	$query  = "SELECT * FROM detalle_atracos";
	$query .= " WHERE origen = " . $origen;
	$query .= "   AND destino = " . $destino;
	$query .= "   AND usuario = " . $usuario;

	log($origen);

	if ( pg_num_rows(pg_query($query)) == 0 ) {
		$query  = "INSERT INTO detalle_atracos (origen, destino, usuario) VALUES ";
		$query .= "($origen,$destino,$usuario)";
		pg_query($query);
	}
?>
