<?
	include('configuracion.php');
	
	$query = "SELECT * from aldea ORDER BY id asc";

	$result = pg_query($link,$query);
	$i = 0;

	while ( $aldea = pg_fetch_assoc($result) ) {
?>
		aldeas[<?=$i?>] = {
			x:"<?=$aldea['x']?>", y:"<?=$aldea['y']?>",
			link:"<?=$aldea['link']?>",
			descripcion:"<?=$aldea['descripcion']?>",
			nucleo: "<?=$aldea['nucleo']?>"
		};
<?
		$i = $i + 1;
	}
?>