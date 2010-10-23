<?php
	$query = "SELECT er.id, er.madera, er.barro, er.hierro, er.cereal, er.intervalo, er.viajes,";
	$query .=" o.did, er.origen, er.destino, d.x as dx, d.y as dy ";
	$query .= " FROM envio_recursos er, aldea o, aldea d";
	$query .= " WHERE orden_id = ".$orden['id'];
	$query .= "   AND er.origen = o.id";
	$query .= "   AND er.destino = d.id";
	$result = pg_query($query);
	
	if ( $result ){
		$envio = pg_fetch_assoc($result);
	} else {
		$envio = array('id'=>"NotFound");
	}

	
?>
	<envio id="<?=$envio['id']?>">
		<viajes><?=$envio['viajes']?></viajes>
		<intervalo><?=$envio['intervalo']?></intervalo>
		<madera><?=$envio['madera']?></madera>
		<barro><?=$envio['barro']?></barro>
		<hierro><?=$envio['hierro']?></hierro>
		<cereal><?=$envio['cereal']?></cereal>
		<destino id="<?=$envio['destino']?>">
			<x><?=$envio['dx']?></x>
			<y><?=$envio['dy']?></y>
		</destino>
		<origen id="<?=$envio['origen']?>"><?=$envio['did']?></origen>
	</envio>
