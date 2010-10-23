<?
	$nuevo = false;
	$saveOrdenArg = '';

	$query =  "SELECT * FROM entrenamiento";
	$query .= " WHERE orden_id = ".$orden[$i]['id'];
	$query .= " ORDER BY id asc";

	$result = pg_query($query);
	$entrenamiento = pg_fetch_assoc($result);
?>
	//Entrenamiento
	datos = { 
		tropas: new Array(),
		orden_id: <?=$orden[$i]['id']?>,
		sgte_tropa:  <?=$entrenamiento['sgte_tropa']?>,
		activo:  '<?=$entrenamiento['activo']?>',
		aldea:  '<?=$entrenamiento['aldea']?>'
	};
<?
	for($j = 1; $j < 9; $j++){
?>
	datos.tropas[<?=$j?>] = <?=$entrenamiento['t'.$j]?>;
<?
	}
?>
	descripcion = getEntrenamientoInfo(datos);