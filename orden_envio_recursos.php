<?
	include_once('auth.php');
	control();
	$modo = "insert";
	$saveOrdenArg = "";
?>
<a class="cerrar" href="javascript:cerrar_menu()">X</a>
<input id="cantOrdenes" type="hidden" value="0" />
<input id="guardar0" type="hidden" checked />
<table>
	<tr><td colspan="2"><h1><img src="img/mercado.png"/>Envio de Recursos</h1></td></tr>
	<tr>
		<td><h2>Aldeas</h2></td>
		<td>
			<label>De :</label>
			<select id="origen"></select>
			<br/>
			<label>Para :</label>
			<select id="destino"></select>
		</td>
	</tr>
	<tr>
	<td><h2>Recursos</h2></td>
		<td>
			<input id="madera" size="7"/>&nbsp;<img src="img/madera.png"/><br/>
			<input id="barro" size="7"/>&nbsp;<img src="img/barro.png"/><br/>
			<input id="hierro" size="7"/>&nbsp;<img src="img/hierro.png"/><br/>
			<input id="cereal" size="7"/>&nbsp;<img src="img/cereal.png"/>
		</td>
	</tr>
	<tr>
		<td><h2>Inicio</h2></td>
		<td>
			<input id="inicio" type="hidden" value="fijar_hora" />
			<a href="javascript:cambiar_inicio()"/> cambiar modalidad </a> <br/>
			<span class="opcion" id="inicio_text">Fijar horario de inicio</span> <br/>
			<span id="horario">
				Horario
				<input id="dia" size="2"/>/
				<input id="mes" size="2"/>/
				<input id="anho" size="4"/> - 
				<input id="hora" size="2"/> :
				<input id="minutos" size="2"/>
			</span>
		</td>
	</tr>
	<tr>
		<td><h2>Viajes</h2></td>
		<td>
			Cantidad de viajes :<input id="viajes" size="5"/><br/>
			Tiempo entre viajes : <input id="intervalo" size="7"/>
		</td>
	</tr>
		<td/>
<?
	if ( isset($_GET['orden']) ){
		$modo = "update";
		$saveOrdenArg = ", ".$_GET['orden'];
		$query = "SELECT * FROM envio_recursos WHERE orden_id = ".$_GET['orden'];
		$result = pg_query($query);
		$envio = pg_fetch_assoc($result);

		$query = "SELECT * FROM orden WHERE id = ".$_GET['orden'];
		$result = pg_query($query);
		$orden = pg_fetch_assoc($result);
	}
?>
	<input id="modo" type="hidden" value="<?=$modo?>" />
	<td>
		<a href="javascript:saveOrden(envio_recursos<?=$saveOrdenArg?>)"> Guardar </a> / 
		<a href="javascript:saveOrden(envio_recursos,null)"> Agregar </a> /

		<a href="javascript:cerrar_menu()"> Cancelar </a></td>
	</tr>
	</table>


<script type="text/javascript">
	for(i = 0; i < aldeas.length; i++ ){
		item = document.createElement('option');
		item.value = i;
		item.innerHTML = aldeas[i].descripcion + " ("+aldeas[i].x+"|"+aldeas[i].y+")";
		$('origen').appendChild(item);
					
		item = document.createElement('option');
		item.value = i;
		item.innerHTML = aldeas[i].descripcion + " ("+aldeas[i].x+"|"+aldeas[i].y+")";
		$('destino').appendChild(item);
	}

<?
	if ( isset($_GET['orden'])  ){
?>
		$('origen').value = <?=$envio['origen']?>;
		$('destino').value = <?=$envio['destino']?>;

		$('madera').value = <?=$envio['madera']?>;
		$('barro').value = <?=$envio['barro']?>;
		$('hierro').value = <?=$envio['hierro']?>;
		$('cereal').value = <?=$envio['cereal']?>;
		$('viajes').value = <?=$envio['viajes']?>;
		$('intervalo').value = <?=$envio['intervalo']?>;

		fecha = new Date('<?=$orden['inicio']?>');
		$('dia').value = fecha.getDate();
		$('mes').value = fecha.getMonth()+1;
		$('anho').value = fecha.getFullYear();
		$('hora').value = fecha.getHours();
		$('minutos').value = fecha.getMinutes();
<?
	} else {
?>
	$('dia').value = new Date().getDate();
	$('mes').value = new Date().getMonth()+1;
	$('anho').value = new Date().getFullYear();
	$('hora').value = new Date().getHours();
	$('minutos').value = new Date().getMinutes();
<?
	}
?>
</script>