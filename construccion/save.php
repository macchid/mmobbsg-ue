<?php
	include('configuracion.php');
	include_once('auth.php');
	control();
	
	$query = "";

	if ( $_POST['modo'] == "insert" ) {
		$query = "INSERT INTO construccion (grupo_id,id,gid,nivel,usuario,aldea) VALUES ";
		$query .= "(".$_POST['grupo_id'].",";
		$query .= "".$_POST['id'].",";
		$query .= "".$_POST['gid'].",";
		$query .= "".$_POST['nivel'].",";
		$query .= "'".$_SESSION['usuario']."',";
		$query .= $_POST['aldea'].")";
	} else if ($_POST['modo'] == "update" ) {
		$query = "UPDATE construccion SET ";
		$query .= " gid = ".$_POST['gid'].", ";
		$query .= " nivel = ".$_POST['nivel'].", ";
		$query .= " aldea = ".$_POST['aldea']." ";
		$query .= "WHERE id=".$_POST['id']." ";
		$query .= "  AND grupo_id =".$_POST['grupo_id']." ";
		$query .= "  AND usuario ='".$_SESSION['usuario']."' ";
	} else if ($_POST['modo'] == "delete" ) {
		$query = "DELETE FROM construccion ";
		$query .= "WHERE id=".$_POST['id']." ";
		$query .= "  AND grupo_id =".$_POST['grupo_id']." ";
		$query .= "  AND usuario ='".$_SESSION['usuario']."' ";
	}
	
	echo $query."<br/>";
	
	$result = pg_query($query);
?>
