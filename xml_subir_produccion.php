<?php
	$query = "SELECT inicio,fin, a.did, aldea, sp.id, sp.razon ";
	$query .= " FROM subir_produccion sp, aldea a ";
	$query .= " WHERE orden_id = ".$orden['id'];
	$query .= "   AND sp.aldea = a.id";
	$result = pg_query($query);
	
	if ( $result ){
		$sp = pg_fetch_assoc($result);
	} else {
		$sp = array('id'=>"NotFound");
	}
?>
	<subir_produccion id="<?=$sp['id']?>" aldea="<?=$sp['did']?>">
		<fin><?=$sp['fin']?></fin>
		<razon><?=$sp['razon']?></razon>
<?

	$query =  "SELECT p.id, p.tipo_parcela FROM parcela p, aldea a";
	$query .= " WHERE a.id = ".$sp['aldea'];
	$query .= "   AND a.tipo_aldea = p.tipo_aldea ";
	$query .= " ORDER BY tipo_parcela, id";
	$result = pg_query($query);
	
	$gid = 1;
	$i = 0;
	$parcelas = Array();
	$parcelas[1] = Array();

	while($fila = pg_fetch_assoc($result)){
		if ( $gid != $fila['tipo_parcela'] ){
				$gid = $fila['tipo_parcela'];
				$parcelas[$gid] = Array();
				$i = 0;
		}
		$parcelas[$gid][$i] = $fila['id'];
		$i++;
	}

	for ( $i = 1; $i <= count($parcelas); $i++ ){
?>
		<parcela gid="<?=$i?>">
<?
		for ($j=0; $j < count($parcelas[$i]) ; $j++){
?>
			<id><?=$parcelas[$i][$j]?></id>
<?
		}
?>
		</parcela>
<?
	}
?>
	</subir_produccion>
