<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	
	$query = "";

//id | aldea | t1 | t2 | t3 | t4 | t5 | t6 | t7 | t8 | sgte_tropa | activo | orden_id

	if ( $_POST['modo'] == "insert" ) {
		/*
		 * Parametros necesarios
		 * id, aldea, t{1..8}, sgte_tropa,orden_id
		 */
		$query = "INSERT INTO entrenamiento (aldea,t1,t2,t3,t4,t5,t6,t7,t8,sgte_tropa,activo,orden_id) VALUES ";
		$query .= "(".$_POST['aldea'].",";
		$query .= "".$_POST['t1'].",";
		$query .= "".$_POST['t2'].",";
		$query .= "".$_POST['t3'].",";
		$query .= "".$_POST['t4'].",";
		$query .= "".$_POST['t5'].",";
		$query .= "".$_POST['t6'].",";
		$query .= "".$_POST['t7'].",";
		$query .= "".$_POST['t8'].",";
		$query .= "".$_POST['sgte_tropa'].",";
		$query .= "true,";
		$query .= $_POST['orden_id'].")";
	} else if ($_POST['modo'] == "update" ) {
		/*
		 * Parametros necesarios
		 * id, aldea, t{1..8}, sgte_tropa,activo
		 */
		$query = "UPDATE entrenamiento SET ";
		$query .= " aldea = ".$_POST['aldea'].", ";
		$query .= " t1 = ".$_POST['t1'].", ";
		$query .= " t2 = ".$_POST['t2'].", ";
		$query .= " t3 = ".$_POST['t3'].", ";
		$query .= " t4 = ".$_POST['t4'].", ";
		$query .= " t5 = ".$_POST['t5'].", ";
		$query .= " t6 = ".$_POST['t6'].", ";
		$query .= " t7 = ".$_POST['t7'].", ";
		$query .= " t8 = ".$_POST['t8'].", ";
		$query .= " sgte_tropa = ".$_POST['sgte_tropa']." ";
		$query .= " activo = ".$_POST['activo'].", ";
		$query .= "WHERE id=".$_POST['id']." ";
	} else if ($_POST['modo'] == "tropa_update" ) {
		/*
		 * Parametros necesarios
		 * id, sgte_tropa
		 */
		$query = "UPDATE entrenamiento SET ";
		$query .= " sgte_tropa = ".$_POST['proxima_tropa'];
		$query .= "WHERE id=".$_POST['id'];
	} else if ($_POST['modo'] == "delete" ) {
		/*
		 * Parametros necesarios
		 * id
		 */
		$query = "DELETE FROM entrenamiento ";
		$query .= "WHERE id=".$_POST['id'];
	}
	
	echo $query."<br/>";
	
	$result = pg_query($query);
?>
