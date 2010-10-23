<?php
	include('../configuracion.php');
	include('../auth.php');
	control();
?>
<html>
<head>
	<title> Slave 0.9 - <?=$_SESSION['usuario']?> atracando en <?=$_SESSION['server']?></title>
	<link rel="stylesheet" type="text/css" href="../slave.css" />
	<script type="text/javascript" src="../prototype.js"></script>
</head>
<body>
	<table>
		<tr>
			<td><div id="export-list"></div></td>
		</tr>
		<tr>
			<td><b>Abrir ventanas desde el</b></td>
			<td><input type="text" id="desde" value="1" size="3" onchange="calcNecesarias()"></td>
			<td><b>hasta el</b></td>
			<td><input type="text" id="hasta" value="1" size="3" onchange="calcNecesarias()"></td>
			<td><a href="javascript:atracar()"> Atracar </a></td>
			<td><a href="javascript:exportar()"> |  Exportar </a></td>
		</tr>
		
	</table>
	<table id="atracos">
		<tr>
			<th/>
<?
	$raza = $_SESSION['raza'];
	for($j = 1; $j <= 11; $j++){
?>
			<th<img src="../img/tropas/<?=$raza.$j?>.png"/></th>
<?
	}
?>
			<th> Origen </th>
			<th> Destino </th>
			<th> Distancia </th>
			<th> Tiempo </th>
			<th/>
		</tr>
		<tr id="necesarias"></tr>
<?

	$usuario = "'".$_SESSION['usuario']."'";
	$distancia = "sqrt((a.x-v.x)*(a.x-v.x) + (a.y-v.y)*(a.y-v.y))";
	$origen_equality = " (1 + (400-a.y)*801 + (400+a.x)) = da.origen ";

	$query  = "SELECT da.id as id,t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,";
	$query .= " origen as oid, destino as did,";
	$query .= " a.descripcion as origen, v.nombre as destino, $distancia as distancia ";
	$query .= "  FROM detalle_atracos da, aldea a, vaca v";
	$query .= " WHERE da.usuario = $usuario";
	$query .= "   AND a.usuario = $usuario";
	$query .= "   AND v.usuario = $usuario";
	$query .= "   AND $origen_equality";
	$query .= "   AND v.id = da.destino";
	$query .= " ORDER BY distancia";
	$result = pg_query($query);

	$n = pg_num_rows($result);
	for ( $i = 1; $i <= $n; $i++ ){
		$atraco = pg_fetch_assoc($result);
		$atraco_link = $_SESSION['server']."/a2b.php?z=".$atraco['did']."&c=4";
		for($j = 1; $j <= 11; $j++){
			if ( $atraco["t$j"] > 0 ){
				$atraco_link .= "&t$j=".$atraco["t$j"];
			}
		}
		$borrar_link = "javascript:borrarAtraco(".$atraco['id'].")";
		$guardar_link = "javascript:guardarAtraco($i)";
?>
		<tr>
			<td><?=$i?>. </td>
			<input type="hidden" id="id<?=$i?>" value="<?=$atraco['id']?>" />
			<input type="hidden" id="atraco<?=$i?>" value="<?=$atraco_link?>" />
<?
		for($j = 1; $j <= 11; $j++){
?>
			<td>
				<img src="../img/tropas/<?=$raza.$j?>.png"/>
				<br/>
				<input type="text" id="a<?=$i?>t<?=$j?>" value="<?=$atraco["t$j"]?>" size="4">
			</td>
<?
		}
?>
			<td><?=$atraco['origen']?></td>
			<td>
				<a href="<?=$_SESSION['server']?>/karte.php?z=<?=$atraco['did']?>">
					<?=$atraco['destino']?>
				</a>
			</td>
			<td id="distancia<?=$i?>"><?=round($atraco['distancia'],3)?></td>
			<td id="tiempo<?=$i?>"/>
			<td>
				<a href="<?=$atraco_link?>">
					<img src="../img/atacar.png"/>
				</a>
				<a href="<?=$guardar_link?>">
					<img src="../img/guardar.png"/>
				</a>
				<a href="<?=$borrar_link?>">
					<img src="../img/borrar.png"/>
				</a>
			</td>
		</tr>
<?
	}
?>
</table>
<script type="text/javascript">
	raza = '<?=$raza?>'
	factor = 1;
	velocidadHeroe = <?=14?>;

	velocidad = new Array();
	velocidad['r'] = new Array(
		0,6,5,7,16,14,10,4,3,4,5,velocidadHeroe
	);

	velocidad['g'] = new Array(
		0,7,7,6,9,10,9,4,3,4,5,velocidadHeroe
	);

	function guardarAtraco(id){

		var saveAtraco = new Ajax.Request (
			'save_atraco.php',
			{
				method: "POST",
				parameters: {
<?
					for ($i = 1; $i < 12; $i++){
?>
					t<?=$i?>: $('a'+id+'t<?=$i?>').value,
<?
					}
?>
					id: $('id'+id).value
				}
			}
		);
	}

	function borrarAtraco(id){

		var borrarAtraco = new Ajax.Request (
			'borrar_atraco.php',
			{
				method: "POST",
				parameters: {
					id: id
				}
			}
		);
	}

	function calcularTiempo(id){
		maxVelocidad = -1;

		for ( i = 1; i < 12; i++ ){
			tmp = velocidad[raza][i] < maxVelocidad || maxVelocidad == -1;
			if ( $('a'+id+'t'+i).value > 0 && tmp ){
				maxVelocidad = velocidad[raza][i];
			}
		}

		if ( $('distancia'+id).innerHTML > 0 ){
			t = $('distancia'+id).innerHTML / (maxVelocidad*factor);
			h = Math.floor(t);
			m = Math.floor((t-h)*60);
			s = Math.floor(((t-h)*60-m)*60);
			$('tiempo'+id).innerHTML = h+":"+(m<10?"0":"")+m+":"+(s<10?"0":"")+s
		} else {
			$('tiempo'+id).innerHTML = "Nunca"
		}
	}

	function calcularTiempos(){
		for ( a = 1; a <= <?=$n?>; a++ ){
			calcularTiempo(a);
		}
	}

	calcularTiempos()

	function atracar(){
		desde = $('desde').value;
		hasta = $('hasta').value;

		a = new Array();

		for ( i = desde; i <= hasta; i++ ){
			a[i] = window.open($('atraco'+i).value, '_blank');
			setTimeout('a['+i+'].close()',20000);
		}
	}
	
	function exportar(){
		desde = $('desde').value;
		hasta = $('hasta').value;
		buffer = '';

		for ( i = desde; i <= hasta; i++ ){
			buffer += "'"+$('atraco'+i).value+"',<br/>";
		}

		$('export-list').innerHTML = buffer;
	}

	function calcNecesarias(){
		tr = $('necesarias');
		tr.innerHTML = "";
		td = document.createElement('td');
		td.appendChild(document.createTextNode('Necesarias'));
		tr.appendChild(td);

		desde = $('desde').value;
		hasta = $('hasta').value;

		for ( j = 1; j <= 10; j++ ){
			cantidad = 0;
			valor = 0;
			for(i = desde; i <= hasta; i++ ){
				valor = $('a'+i+'t'+j).value;
				if (valor == null) continue;
				cantidad += parseInt(valor);
			}
		
			td = document.createElement('td');
			td.appendChild( document.createTextNode(cantidad));
			tr.appendChild( td );
		}

		td = document.createElement('td');
		td.setAttribute('colspan','5');
		td.appendChild(document.createTextNode('Para ' + (hasta-desde+1) + ' atracos'));
		tr.appendChild(td);
	}
</script>
</body>
</html>
