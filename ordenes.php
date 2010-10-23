<?
	include_once('configuracion.php');
	include_once('auth.php');
	control();
?>
	var ordenes = new Array();
<?

	if ( isset($_POST['delete_all']) ) {
		$query  =  "TRUNCATE TABLE orden;";
		$query .=  "TRUNCATE TABLE envio_recursos;";
		$query .=  "TRUNCATE TABLE construccion;";
		$query .=  "TRUNCATE TABLE subir_produccion;";
		$query .=  "TRUNCATE TABLE fila;";		
		$query .=  "TRUNCATE TABLE atraco;";
		$query .=  "TRUNCATE TABLE entrenamiento;";
		pg_query($query);
	}

	$query =  "SELECT * FROM orden";
	$query .= " WHERE usuario = '".$_SESSION['usuario']."'";
	$query .= " ORDER BY inicio asc";
	$ordenes = pg_query($query);
	$cant = 0;
	$orden_inicial = -1;
	$orden_final = -1;

	while ( $orden[$cant] = pg_fetch_assoc($ordenes) ){
		$cant++;
	}

	for ($i = 0; $i < $cant; $i++ ){
?>
	//Orden <?=$orden[$i]['id']?>

<?
		if ($orden_final < $orden[$i]['id']){
			$orden_final = $orden[$i]['id'];
		}

		$query =  "SELECT * FROM orden ";
		$query .= " WHERE usuario = '".$_SESSION['usuario']."'";
		$query .= "   AND id = ".$orden[$i]['id'];
		$result = pg_query($query);
		if ( $orden[$i]['tipo_orden'] == 'construccion' ){
			include('init_construccion.php');
		} else if ( $orden[$i]['tipo_orden'] == 'envio_recursos' ){
			include('init_envio_recursos.php');
		} else if ( $orden[$i]['tipo_orden'] == 'subir_produccion' ){
			include('init_subir_produccion.php');
		} else if ( $orden[$i]['tipo_orden'] == 'entrenamiento' ){
			include('init_entrenamiento.php');
		} else if ( $orden[$i]['tipo_orden'] == 'atraco'){
			include('init_atraco.php');
		}
?>
	addOrden(
		descripcion,
		<?=$orden[$i]['id']?>,
		'<?=$orden[$i]['tipo_orden']?>',
		new Date('<?=$orden[$i]['inicio']?>')
	);
	ordenes[<?=$i?>] = { inicio: new Date('<?=$orden[$i]['inicio']?>') };
<?
	}

	if ( $cant > 0 ){
		$orden_inicial = $orden[0]['id'];
	}
?>
	//Datos galacticos interespaciales y globales
	var orden_actual= <?=$orden_inicial?>;
	var ultima_orden = <?=$orden_final?>;

	nodo = document.getElementById('updateOrdenes');
	nodo.parentNode.removeChild(nodo);
