<?
	include_once('auth.php');
	control();
	$raza = $_SESSION['raza'];
	
	$update = isset($_GET['orden']);
	$orden = null;
	$entrenamiento = null;
	
	if ( $update ){
		$saveOrdenArg = ','.$_GET['orden'];
		
		$query =  "SELECT * FROM orden";
		$query .= " WHERE id = ".$_GET['orden'];
		
		$result = pg_query($query);
		$orden = pg_fetch_assoc($result);
		
		$query =  "SELECT * FROM entrenamiento";
		$query .= " WHERE orden_id = ".$_GET['orden'];
		$query .= " ORDER BY id asc";
		
		$result = pg_query($query);
		$entrenamiento = pg_fetch_assoc($result);
	}
?>
<a class="cerrar" href="javascript:cerrar_menu()">X</a>
<table>
	<tr><td><h2>Entrenamiento</h2></td></tr>
	<tr>
		<td colspan="3">
			<input id="inicio" type="hidden" value="fijar_hora" />
			<a href="javascript:cambiar_inicio()"/> cambiar modalidad </a> <br/>
			<span class="opcion" id="inicio_text">Fijar horario de inicio</span> <br/>
			<span id="horario">
				Horario
				<input id="dia" size="2"/>/
				<input id="mes" size="2"/>/
				<input id="anho" size="2"/> - 
				<input id="hora" size="2"/>:
				<input id="minutos" size="2"/>
			</span>
		</td>
	</tr>
	<tr>
		<td><h2>Aldea</h2></td>
		<td colspan="3">
			<select id="aldea"></select>
		</td>
	</tr>
	<tr>
		<td><h2>Tropas</h2></td>
		<? for ( $i = 1; $i < 9; $i++ ){?>
			<td><img src="img/tropas/<?="${raza}${i}"?>.png"/>
			<input type="text" size="3" id="t<?=$i?>" value="<?=($update?$entrenamiento['t'.$i]:0)?>"></td>
		<? }?>
	</tr>
 
	<input id="cantOrdenes" type="hidden" value="0" />
	<input id="guardar0" type="hidden" checked />
	<input id="modo" type="hidden" value="insert" />
	<input id="activo" type="hidden" value="true" />
	<tr>
		<td colspan="4">
			<a href="javascript:saveOrden(entrenamiento<?=$saveOrdenArg?>)"> Guardar </a> /
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
	if ( $update  ){
?>	
	$("aldea").value = "<?=$entrenamiento['aldea']?>";
	inicio = new Date("<?=$orden['inicio']?>");
	$('dia').value = inicio.getDate();
	$('mes').value = inicio.getMonth()+1;
	$('anho').value = inicio.getFullYear();
	$('hora').value = inicio.getHours();
	$('minutos').value = inicio.getMinutes();
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