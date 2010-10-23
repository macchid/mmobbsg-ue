<?
	include_once('auth.php');
	control();
	$modo = "insert";
?>
<a class="cerrar" href="javascript:cerrar_menu()">X</a>
<table>
	<tr><td colspan="3"><img src="img/produccion.png"/><h2>Subir Produccion</h2></td></tr>
	<tr align="center">
		<td colspan="1">
			<input id="inicio" type="hidden" value="fijar_hora" />
			<input id="cantOrdenes" type="hidden" value="0" />
			<input id="guardar0" type="hidden" checked />
			<h4>Inicio</h4>
			<a href="javascript:cambiar_inicio()"/> cambiar modalidad </a> <br/>
			<span class="opcion" id="inicio_text">Fijar horario de inicio</span> <br/>
			<span id="horario">
				<input id="dia" size="2"/>/
				<input id="mes" size="2"/>/
				<input id="anho" size="2"/> - 
				<input id="hora" size="2"/>:
				<input id="minutos" size="2"/>
			</span>
		</td>
	</tr>
	<tr align="center">
		<td><h4>Aldea</h4> <select id="aldea"></select></td>
	</tr>
	<tr align="center">
		<td><h4>Duracion (en minutos)</h4><input type="text" id="duracion"></td>
	</tr>
	<tr align="center">
		<td><h4>Razon</h4><input type="text" id="razon"></td>
	</tr>
<?
	$saveOrdenArg = "";
	if (isset($_GET['orden'])) {
		$query =  "SELECT * FROM orden";
		$query .= " WHERE usuario = '".$_SESSION['usuario']."'";
		$query .= "   AND id = '".$_GET['orden']."'";
		$result = pg_query($query);
		$orden = pg_fetch_assoc($result);

		$query =  "SELECT * FROM subir_produccion sp";
		$query .= " WHERE sp.orden_id = ".$_GET['orden'];
		$result = pg_query($query);

		$sp = pg_fetch_assoc($result);
		$orden_id = $sp['orden_id'];
		$saveOrdenArg = ", $orden_id";	
		$modo = "update";
	}
?>
	<input id="modo" type="hidden" value="<?=$modo?>" />
	<tr>
		<td colspan="4">
			<a href="javascript:saveOrden(subir_produccion<?=$saveOrdenArg?>)"> Guardar </a> /
			<a href="javascript:cerrar_menu()"> Cancelar </a>
		</td>
	</tr>
</table>


<script type="text/javascript">
	for(i = 0; i < aldeas.length; i++ ){
		item = document.createElement('option');
		item.value = i;
		item.innerHTML = aldeas[i].descripcion + " ("+aldeas[i].x+"|"+aldeas[i].y+")";
		$('aldea').appendChild(item);
	}
<?
	if ( isset($_GET['orden'])  ){
?>	
	inicio = new Date("<?=$orden['inicio']?>");
	$('dia').value = inicio.getDate();
	$('mes').value = inicio.getMonth()+1;
	$('anho').value = inicio.getFullYear();
	$('hora').value = inicio.getHours();
	$('minutos').value = inicio.getMinutes();
	$('aldea').value = "<?=$sp['aldea']?>";
	$('razon').value = "<?=$sp['razon']?>";
	$('duracion').value = (new Date("<?=$sp['fin']?>")-new Date("<?=$sp['inicio']?>"))/60000;
	
<?
	} else {
?>
	$('dia').value = new Date().getDate();
	$('mes').value = new Date().getMonth()+1;
	$('anho').value = new Date().getFullYear();
	$('hora').value = new Date().getHours();
	$('minutos').value = new Date().getMinutes();
	$('duracion').value = 60*5;
	$('razon').value = "0.25/0.3/0.25/0.2";
<?
	}
?>
</script>