<?
	include_once('auth.php');
	control();
?>
<a class="cerrar" href="javascript:cerrar_menu()">X</a>
<table>
	<tr><td colspan="3"><h2>Construccion</h2></td></tr>
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
		<td>Aldea</td>
		<td>Edificio</td>
		<td>Del nivel</td>
		<td>Al nivel</td>
		<td>Guardar</td>
	</tr>
<?
	$n = 0;
	$c = 0;
	$nuevo = false;
	$id = 0;
	$saveOrdenArg = '';

	if (isset($_GET['orden'])) {
		$query =  "SELECT * FROM orden";
		$query .= " WHERE usuario = '".$_SESSION['usuario']."'";
		$query .= "   AND id = '".$_GET['orden']."'";
		$result = pg_query($query);
		$orden = pg_fetch_assoc($result);

		$query =  "SELECT * FROM construccion c";
		$query .= " WHERE c.usuario = '".$_SESSION['usuario']."'";
		$query .= "   AND c.grupo_id = '".$_GET['orden']."'";
		$query .= " ORDER BY grupo_id asc";
		$result = pg_query($query);

		$construcciones = array();
		while ($construcciones[$c] = pg_fetch_assoc($result) ) {
			$id = $construcciones[$c]['id'];
			include('construccion_form.php');
			$c++;
		}
		$id = $id+1;

		$saveOrdenArg = ",".$_GET['orden'];
	}
	
	$nuevo = true;
	include('construccion_form.php');
	$n = $c;
?>
	<input id="cantOrdenes" type="hidden" value="<?=$n?>" />
	<tr>
		<td colspan="4">
			<a href="javascript:saveOrden(construccion<?=$saveOrdenArg?>)"> Guardar </a> /
			<a href="javascript:cerrar_menu()"> Cancelar </a>
		</td>
	</tr>  
</table>


<script type="text/javascript">
<?
	if ( isset($_GET['orden'])  ){
		for ($c = 0; $c < $n; $c++){
?>	
	for(i = 0; i < aldeas.length; i++ ){
		item = document.createElement('option');
		item.value = i;
		item.innerHTML = aldeas[i].descripcion + " ("+aldeas[i].x+"|"+aldeas[i].y+")";
		$('aldea<?=$c?>').appendChild(item);
	}

	$("aldea<?=$c?>").value = "<?=$construcciones[$c]['aldea']?>";
	$("edificio<?=$c?>").value ="<?=$construcciones[$c]['gid']?>";
	$("nivel<?=$c?>").value = "<?=$construcciones[$c]['nivel']?>";
<?
		}
?>
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
	for(i = 0; i < aldeas.length; i++ ){
		item = document.createElement('option');
		item.value = i;
		item.innerHTML = aldeas[i].descripcion + " ("+aldeas[i].x+"|"+aldeas[i].y+")";
		$('aldea<?=$n?>').appendChild(item);
	}
</script>