<?php
	header("Content-type: text/xml");
	include('configuracion.php');
	include_once('auth.php');
	control();

	$query  =  "SELECT * FROM orden ";
	$query .= " WHERE usuario = '".$_SESSION['usuario']."'";
	$query .= " ORDER BY inicio asc limit 1";

	$result = pg_query($query);
	
	if ( $result ){
		$orden = pg_fetch_assoc($result);
	} else {
		$orden = array('id'=>"NotFound");
	}

	echo "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
?>
<orden id="<?=$orden['id']?>">
	<inicio><?=$orden['inicio']?></inicio>
	<usuario><?=$_SESSION['usuario']?></usuario>
	<tipo><?=$orden['tipo_orden']?></tipo>
<?
	if ( $orden['tipo_orden'] == 'construccion' ){
		include('xml_construccion.php');
	} else if ( $orden['tipo_orden'] == 'envio_recursos' ){
		include('xml_envio_recursos.php');
	} else if ( $orden['tipo_orden'] == 'subir_produccion' ){
		include('xml_subir_produccion.php');
	} else if ( $orden['tipo_orden'] == 'entrenamiento' ){
		include('xml_entrenamiento.php');
	} else if($orden['tipo_orden'] == 'atraco'){
		include('xml_atraco.php');
	}
?>
</orden>

