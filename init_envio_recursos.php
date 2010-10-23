<?
	$query =  "SELECT * FROM envio_recursos";
	$query .= " WHERE orden_id = ".$orden[$i]['id'];

	$result = pg_query($query);
	$envio = pg_fetch_assoc($result);

	
	
?>
	datos = {
		orden_id: <?=$orden[$i]['id']?>,
		origen: <?=$envio['origen']?>,
		destino: <?=$envio['destino']?>,
		madera: <?=$envio['madera'] != null? $envio['madera']:0?>,
		barro: <?=$envio['barro'] != null? $envio['barro']:0?>,
		hierro: <?=$envio['hierro'] != null? $envio['hierro']:0?>,
		cereal: <?=$envio['cereal'] != null? $envio['cereal']:0?>,
		viajes: <?=$envio['viajes']?>,
		intervalo: <?=$envio['intervalo']?>
	};

	descripcion = getEnvioRecursosInfo(datos);
