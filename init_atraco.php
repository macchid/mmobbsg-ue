<?
	$zOrigen = "((400 - a.y)*801 + 401 + a.x)";

	$query  = "SELECT a.descripcion as origen, v.nombre as destino, ";
	$query .= "		  da.t1 as t1, da.t2 as t2, da.t3 as t3, da.t4 as t4, da.t5 as t5,";
	$query .= "		  da.t6 as t6, da.t7 as t7, da.t8 as t8, da.t9 as t9, da.t10 as t10,";
	$query .= "		  da.t11 as t11";
	$query .= "  FROM fila f, atraco at, detalle_atracos da, aldea a, vaca v";
	$query .= " WHERE f.id = ".$orden[$i]['id'];
	$query .= "   AND f.usuario = '".$_SESSION['usuario']."'";
	$query .= "   AND at.id_fila = f.id";
	$query .= "   AND at.id = f.front";
	$query .= "   AND at.id_atraco = da.id";
	$query .= "   AND $zOrigen = da.origen";
	$query .= "   AND da.destino = v.id";

	$result = pg_query($query);
	$atraco = pg_fetch_assoc($result);
?>
	datos = { 
				raza: <?="'".$_SESSION['raza']."'"?>,
				atraco: {
					origen:		<?="'".$atraco['origen']."'"?>,
					destino:	<?="'".$atraco['destino']."'"?>,
					tropas:		[<?=$atraco['t1']?>,
							 	 <?=$atraco['t2']?>,
							 	 <?=$atraco['t3']?>,
								 <?=$atraco['t4']?>,
								 <?=$atraco['t5']?>,
								 <?=$atraco['t6']?>,
								 <?=$atraco['t7']?>,
								 <?=$atraco['t8']?>,
								 <?=$atraco['t9']?>,
								 <?=$atraco['t10']?>,
							 	 <?=$atraco['t11']?>]
				},
				orden_id: <?=$orden[$i]['id']?> 
			};

	descripcion = getAtracoInfo(datos);

