<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	
	$query = "";
	$razon = $_POST['razon'];

	$num = "[0-9]*\.?[0-9]*";
	$regex = '/'.$num.'\/'.$num.'\/'.$num.'\/'.$num.'/';

	if ( preg_match($regex, $razon) == 0 ){
		$razon = "0.25/0.3/0.25/0.2";
	}

	$aldea = "";

	if ( isset($_POST['aldea_did']) ){
		$result = pg_query("SELECT id FROM aldea WHERE did = ".$_POST['aldea_did']);
		$aldea = pg_fetch_assoc($result);
		$aldea = $aldea['id'];
	}

	if ( isset($_POST['aldea']) ){
		$aldea = $_POST['aldea'];
	}

	if ( $_POST['modo'] == "insert" ) {
		$query = "INSERT INTO subir_produccion (inicio,fin,aldea,razon,orden_id) VALUES ";
		$query .= "('".$_POST['inicio']."',";
		$query .= "'".$_POST['fin']."',";
		$query .= $aldea.",";
		$query .= "'$razon',";
		$query .= "'".$_POST['orden_id']."')";
	} else if ($_POST['modo'] == "update" ) {
		$query = "UPDATE subir_produccion SET ";
		$query .= " inicio = '".$_POST['inicio']."', ";
		$query .= " fin = '".$_POST['fin']."', ";
		$query .= " aldea = ".$aldea.", ";
		$query .= " razon = '$razon' ";
		$query .= "WHERE id=".$_POST['id']." ";
	} else if ($_POST['modo'] == "delete" ) {
		$query = "DELETE FROM subir_produccion ";
		$query .= "WHERE id=".$_POST['id']." ";
	}
	
	echo $query."<br/>";
	
	$result = pg_query($query);
?>