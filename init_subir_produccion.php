<?
	$saveOrdenArg = '';

	$query =  "SELECT * FROM subir_produccion";
	$query .= " WHERE orden_id = ".$orden[$i]['id'];

	$result = pg_query($query);
	$sp = pg_fetch_assoc($result);
	
?>
	datos = { 
		n: 0,
		id: <?=$sp['id']?>,
		orden_id: <?=$orden[$i]['id']?>,
		aldea: <?=$sp['aldea']?>,
		fin: showDate(new Date('<?=$sp['fin']?>')),
		razon: '<?=$sp['razon']?>'
	};

	descripcion = getSubirProduccionInfo(datos);
