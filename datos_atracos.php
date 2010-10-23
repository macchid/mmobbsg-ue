<?
	include_once('auth.php');
	control();
?>

atracos = new Array();
<?
	$usuario = "'".$_SESSION['usuario']."'";
	$distancia = "sqrt((a.x-v.x)*(a.x-v.x) + (a.y-v.y)*(a.y-v.y))";
	$origenZ = "((400 - a.y)*801 + (401 + a.x))";
	$query = "";
	$tropas = "";

	for($t = 1; $t <= 11; $t++ ) $tropas .= "da.t$t as t$t, ";
	
	if (!isset($_GET['oid'])){

		$query  = "SELECT da.id as atraco_id, da.origen as oid, da.destino as did,";
		$query .= "       a.descripcion as origen, v.nombre as destino, $tropas";
		$query .= "       $distancia as distancia ";
		$query .= "  FROM detalle_atracos da, aldea a, vaca v";
		$query .= " WHERE da.usuario = $usuario";
		$query .= "   AND a.usuario = $usuario";
		$query .= "   AND v.usuario = $usuario";
		$query .= "   AND v.id = da.destino";
		$query .= "	  AND da.origen = $origenZ";
		$query .= " ORDER BY da.origen, distancia";
	}
	else{
		$oid = "'".$_GET['oid']."'";

		$query  = "SELECT da.id as atraco_id, da.origen as oid, da.destino as did,";
		$query .= "       a.descripcion as origen, v.nombre as destino, $tropas";
		$query .= "       $distancia as distancia ";
		$query .= "  FROM detalle_atracos da, aldea a, vaca v";
		$query .= " WHERE da.origen = $oid";				// El origen del da corresponde a la Z de la aldea elegida
		$query .= "   AND $origenZ = $oid";					// La z calculada corresponde a la Z de la aldea elegida.
		$query .= "   AND v.id = da.destino";				// La info de la vaca corresponde al destino
		$query .= " ORDER BY distancia";
	}

	$result = pg_query($query);
	$n = pg_num_rows($result);
?>
	nRows = <?=$n?>;
<?
	
	for ( $i = 0; $i < $n; $i++ ){
		$atraco = pg_fetch_assoc($result);
?>
	atracos[<?=$i?>] = {
						id:			<?=$atraco['atraco_id']?>,
						oid:		<?=$atraco['oid']?>,
						did:		<?=$atraco['did']?>,
						origen:		"<?=$atraco['origen']?>",
						destino:	"<?=$atraco['destino']?>",
						tropas:		[undefined, 
									 <?=$atraco['t1']?>,
									 <?=$atraco['t2']?>,  
									 <?=$atraco['t3']?>,  
									 <?=$atraco['t4']?>,
									 <?=$atraco['t5']?>, 
									 <?=$atraco['t6']?>,  
									 <?=$atraco['t7']?>,  
									 <?=$atraco['t8']?>,  
									 <?=$atraco['t9']?>,  
									 <?=$atraco['t10']?>,  
									 <?=$atraco['t11']?>],
						distancia:	<?=round($atraco['distancia'], 3)?>,
						enviar:		false,
						siguiente:	0
					  }
<?
	}
?>

// Se setea el valor de las variables
begin = 0;
end = nRows > 10 ? 10 : nRows;

showAtracos();
