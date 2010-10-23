<?php
	$zOrigen = "((400 - a.y)*801 + 401 + a.x)";

	$query  = "SELECT at.id as id, a.did as origen, da.destino as destino, at.siguiente as siguiente,";
	$query .= "		  da.t1  as t1, da.t2  as t2, da.t3  as t3, da.t4  as t4, da.t5  as t5,";
	$query .= "		  da.t6  as t6, da.t7  as t7, da.t8  as t8, da.t9  as t9, da.t10 as t10,";
	$query .= "		  da.t11 as t11";
	$query .= "  FROM fila f, atraco at, detalle_atracos da, aldea a";
	$query .= " WHERE f.usuario = '".$_SESSION['usuario']."'";
	$query .= "   AND f.id = ".$orden['id'];
	$query .= "   AND at.usuario = f.usuario";
	$query .= "   AND at.id_fila = f.id";
	$query .= "   AND at.id = f.front";
	$query .= "   AND at.id_atraco = da.id";
	$query .= "   AND $zOrigen = da.origen";

	$result = pg_query($query);

	$tab = 1;
	
	if ( $result ){
		$atraco = pg_fetch_assoc($result);
		echo str_repeat("\t", $tab)."<fila id='${orden['id']}'>"; $tab++;
		echo str_repeat("\t", $tab)."<atraco id='${atraco['id']}'>\n"; $tab++;
		echo str_repeat("\t", $tab)."<origen>${atraco['origen']}</origen>\n";
		echo str_repeat("\t", $tab)."<destino>${atraco['destino']}</destino>\n";
		echo str_repeat("\t", $tab)."<tropas>\n";
		$tab++;
		
		for ($j = 1; $j <= 11; $j++) {
			$indice = "t$j";
			echo str_repeat("\t", $tab)."<t$j>${atraco[$indice]}</t$j>\n";
		}
		
		$tab --;
		echo str_repeat("\t", $tab)."</tropas>\n";

		$tab --;
		echo str_repeat("\t", $tab)."</atraco>\n";
		echo str_repeat("\t", $tab)."<siguiente>${atraco['siguiente']}</siguiente>\n"; $tab--;
		echo str_repeat("\t", $tab)."</fila>";
	} else {
		echo str_repeat("\t", $tab)."<atraco id='NotFound'/>";
	}
?>



