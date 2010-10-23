<?php

	include_once('../database/postgres.php');
	include_once('../session.php');

	$query  = "SELECT id, usuario, tipo_orden as tipo, inicio";
	$query .= "  FROM orden";
	$query .= " WHERE usuario = '${_SESSION['usuario']}'";
		
	if(isset($_POST['id']))
		$query .= "    AND id = ${_POST['id']}";

	if($result = pg_query($database, $query))
	{
		$rows = pg_num_rows($result);

		if ($rows > 1)
			echo "<ordenes n='$rows'>\n";

		for ($i = 0; $i < $rows; $i++)
		{
			$orden = pg_fetch_assoc($result);

			echo "<orden id='${orden['id']}'>";
			echo 	"<usuario>${orden['usuario']}</usuario>";
			echo 	"<tipo>${orden['tipo']}</tipo>";
			echo 	"<inicio>${orden['inicio']}</inicio>";
			echo "</orden>\n";
		}
		
		if($rows > 1)
			echo "</ordenes>";

		return 0;
	}

#	include('../pg_error.php');
?>
