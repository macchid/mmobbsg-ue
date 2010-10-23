<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	$query = "";

	if ( $_POST['modo'] == "insert" ) {
		$query = "INSERT INTO envio_recursos (orden_id,madera,barro,hierro,cereal,origen,destino,viajes,intervalo) VALUES (";
		$query.= $_POST['orden_id'].",'";
		$query.= $_POST['madera']."','";
		$query.= $_POST['barro']."','";
		$query.= $_POST['hierro']."','";
		$query.= $_POST['cereal']."',";
		$query.= $_POST['origen'].",";
		$query.= $_POST['destino'].",";
		$query.= $_POST['viajes'].",";
		$query.= $_POST['intervalo'].")";
	} else if ( $_POST['modo'] == "update" ) {
		$query = "UPDATE envio_recursos SET ";
		$query .= " madera = '".$_POST['madera']."', ";
		$query .= " barro = '".$_POST['barro']."', ";
		$query .= " hierro = '".$_POST['hierro']."', ";
		$query .= " cereal = '".$_POST['cereal']."', ";
		$query .= " origen = ".$_POST['origen'].", ";
		$query .= " destino = ".$_POST['destino'].", ";
		$query .= " viajes = ".$_POST['viajes'].", ";
		$query .= " intervalo = ".$_POST['intervalo']." ";
		$query .= "WHERE orden_id=".$_POST['orden_id'];
	} else if ( $_POST['modo'] == "delete" ) {
		$query = "DELETE FROM envio_recursos ";
		$query .= "WHERE orden_id =".$_POST['orden_id']." ";
	}
	
	echo $query."<br/>";
	
	$result = pg_query($query);
?>
