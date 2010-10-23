<?
	$nuevo = false;
	$saveOrdenArg = '';

	$query =  "SELECT * FROM construccion";
	$query .= " WHERE usuario = '".$_SESSION['usuario']."'";
	$query .= "   AND grupo_id = ".$orden[$i]['id'];
	$query .= " ORDER BY id asc";

	$result = pg_query($query);
?>
	datos = { n: 0, construcciones: new Array(), id: <?=$orden[$i]['id']?>};
<?
	$n = 0;
	while ($construccion = pg_fetch_assoc($result) ) {
		
?>
	//Construccion <?=$construccion['id']?> 
	datos.construcciones[<?=$n?>] = {
		gid: <?=$construccion['gid']?>,
		aldea: <?=$construccion['aldea']?>,
		nivel: <?=$construccion['nivel']?> 
	};
<?
		$n++;
	}
?>
	datos.n = <?=$n?>;
	descripcion = getConstruccionInfo(datos);
