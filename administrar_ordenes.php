<?php
	include('configuracion.php');
	include('auth.php');
	control();
?>
<html>
<head>
</head>
<body>
	<form method="post" action="" />
		<input name="query" size="80" height="60" />
		<input type="submit" />
	</form>
<?
	$query = "SELECT er.id as id, er.madera, er.barro, er.hierro, er.cereal, er.vencimiento, d.x as dx, d.y as dy ";
	$query .= " FROM envio_recursos er, aldea d ";
	$query .= "WHERE er.destino = d.id ";
	$query .= "ORDER BY er.id";
	$result = pg_query($query);
	
	echo "<h1> ENVIO RECURSOS </h1>";
	while ($fila = pg_fetch_assoc($result)){
		echo "ID: " . $fila['id'] . " <br/> ";
		echo "madera: " . $fila['madera'] . " <br/> ";
		echo "barro: " . $fila['barro'] . " <br/> ";
		echo "hierro: " . $fila['hierro'] . " <br/> ";
		echo "cereal: " . $fila['cereal'] . " <br/> ";
		echo "vencimiento: " . $fila['vencimiento'] . " <br/> ";
		echo "destino : (" . $fila['dx'] . "|" . $fila['dy'] . ")";
		echo "<hr/>";
	}
	
	$query = "SELECT * FROM aldea ORDER BY id";
	$result = pg_query($query);
	echo "<h1> ALDEAS </h1>";
	while ($fila = pg_fetch_assoc($result)){
		echo "ID: " . $fila['id'] . " | ";
		echo "x: " . $fila['x'] . " | ";
		echo "y: " . $fila['y'] . " | ";
		echo "nucleo: " . $fila['nucleo'] . " | ";
		echo "descripcion: " . $fila['descripcion'] . " | ";
		echo "tipo: " . $fila['tipo_aldea'];
		echo "<hr/>";
	}
	
	$query = "SELECT * FROM parcela order by tipo_aldea, id";
	$result = pg_query($query);
	echo "<h1> Parcelas </h1>";
	while ($fila = pg_fetch_assoc($result)){
		$id = $fila['id'];
		$tipo_aldea = $fila['tipo_aldea'];
		$tipo_parcela = $fila['tipo_parcela'];

		echo "id: $id | aldea: $tipo_aldea | parcela: $tipo_parcela";
		echo "<hr/>";
		
	}
?>
</body>
</html>
