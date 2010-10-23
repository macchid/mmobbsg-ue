<?php
	include_once('configuracion.php');
	include_once('auth.php');
	control();

	$status = "off";

	if ( isset($_POST['activar']) ){
		$status = "on";
		pg_query("UPDATE usuario SET habilitado = true WHERE username = '".$_SESSION['usuario']."'");
	} else if ( isset($_POST['desactivar']) ) {
		$status = "off";
		pg_query("UPDATE usuario SET habilitado = false WHERE username = '".$_SESSION['usuario']."'");
	} else {
		$query = "SELECT habilitado FROM usuario WHERE username = '".$_SESSION['usuario']."'";
		$tmp = pg_query($query);
		$tmp = pg_fetch_assoc($tmp);
		$status = ($tmp['habilitado'] == "t" ) ? "on" : "off";
	}
?>
<a href="javascript:cambiarEstado('<?=$status?>')" ><img src="img/<?=$status?>.png" /></a>