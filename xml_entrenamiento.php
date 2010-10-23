<?php
/*
SELECT e.*, a.did
  FROM entrenamiento e, aldea a
 WHERE e.orden_id = 7
   AND c.aldea = a.id
   AND e.activo
 **/

	$query =  "SELECT e.*, a.did";
	$query .= "  FROM entrenamiento e, aldea a";
	$query .= " WHERE e.orden_id = ".$orden['id'];
	$query .= "   AND e.aldea = a.id";
	$query .= "   AND e.activo";
	$result = pg_query($query);
	if ( ! $result ){
		$entrenamiento = array('id'=>"NotFound");
	}
	
	$entrenamiento = pg_fetch_assoc($result);
	
	$tropa = "t".$entrenamiento['sgte_tropa'];
	$cantidad = $entrenamiento[$tropa];

	$query  = "SELECT ct.* FROM costo_tropa ct, usuario u";
	$query .= " WHERE ct.raza = u.raza";
	$query .= "   AND u.username = '".$_SESSION['usuario']."'";
	$query .= "   AND ct.id_tropa = '".$entrenamiento['sgte_tropa']."'";
	$result = pg_query($query);
	$tropa_info = pg_fetch_assoc($result);
	
	$query  = "SELECT * FROM recursos_minimos";
	$query .= " WHERE id_aldea = ".$entrenamiento['aldea'];
	$query .= "   AND usuario = '".$_SESSION['usuario']."'";
	$result = pg_query($query);
	$minimos = pg_fetch_assoc($result);

	$t = $entrenamiento['sgte_tropa'];
	$proxima_tropa = $t;

	for ( $i = 0; $i <= 8; $i++ ){
		$t = ( $t + $i ) % 8 + 1;

		if ( $entrenamiento['t'.$t] > 0 ){
			$proxima_tropa = $t;
			break;
		}
	}
	
	$madera = $cantidad*$tropa_info['madera']+$minimos['madera'];
	$barro = $cantidad*$tropa_info['barro']+$minimos['barro'];
	$hierro = $cantidad*$tropa_info['hierro']+$minimos['hierro'];
	$cereal =$cantidad*$tropa_info['cereal']+$minimos['cereal'];
?>
	<entrenamiento id="<?=$entrenamiento['id']?>" aldea="<?=$entrenamiento['aldea']?>">
		<gid><?=$tropa_info['edificio']?></gid>
		<tropa><?=$tropa?></tropa>
		<proxima_tropa><?=$proxima_tropa?></proxima_tropa>
		<cantidad><?=$cantidad?></cantidad>
		<madera><?=$madera?></madera>
		<barro><?=$barro?></barro>
		<hierro><?=$hierro?></hierro>
		<cereal><?=$cereal?></cereal>
	</entrenamiento>