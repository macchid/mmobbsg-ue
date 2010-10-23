<!--
	1. tipo_orden = 'ataque'
	2. Estructuras de base de datos relativa a 'ataque'
	--------------------Userscript--------------------
	3. Funcion de userscript de 'ataque' y auxiliares
	---------------------Interfaz---------------------
	4. orden_ataque.php (ventana del menu)
	5. Objeto Orden de ataque { setParams, getInfo, tipo_orden }
	5.1 setParams: Funcion que recibe el id de la orden y obtiene los datos desde el formulario para guardarlos en la BD via AJAX.
	5.2 getInfo: Funcion que recibe los datos en una estructura especifica de la orden, y construye una vista previa de la orden.
	6. set_ataque.php (interfaz inserción, modificacion y eliminación)
	7. delete_ataque.php (interfaz para eliminacion directa).
	8. init_ataque.php (inicializacion de los datos de atauqe, para introducir en la descripcion de la orden).
	8.1 Se encarga de generar la estructura datos utilizada en el item 5.2.
	9. xml_ataque.php (presentacion de los parametros de la orden al userscript para que los utilice).

-->

<?
	include_once('auth.php');
	control();
?>

<!--------------------------------------------------------------------------------------------------------------------------
  -- PARTE DINAMICA DE LA PAGINA
  -------------------------------------------------------------------------------------------------------------------------->
<script type="text/javascript">

	// Primero se agrega la opcion seleccione una aldea (muestra todo)
	var selection = document.getElementById('origen');
	item = document.createElement('option');
	item.value = -1;
	item.innerHTML = "Seleccione una aldea...";
	selection.appendChild(item);

	// Despues agrega la lista de aldeas asociadas a la cuenta.
	for(i = 0; i < aldeas.length; i++ ){
		item = document.createElement('option');
		item.value = i;
		item.innerHTML = aldeas[i].descripcion + " ("+aldeas[i].x+"|"+aldeas[i].y+")";
		selection.appendChild(item);
	}

	showAtracos = function ()
	{
		var row, cell;
		var nCols = 15;

		var table = document.getElementById('atracos');

		var raza = <?="'".$_SESSION['raza']."'"?>;

		table.innerHTML  = '';	//Limpiar la tabla
		
		table.setAttribute('Style', 'Width:900;Height:' + (end-begin));

		row = document.createElement('tr');	//Crear la fila de cabeceras

		cell = document.createElement('th');	//Cabecera 0: Enumeracion de atracos
		row.appendChild(cell);
		
		for (var t=1; t <= 11 ; t++ )			//Cabecera 1 - 11: Tropas
		{
			cell = document.createElement('th');
			
			var img = document.createElement('img');
			img.setAttribute('src', 'img/tropas/'+ raza + t + '.png');
			cell.appendChild(img);

			row.appendChild(cell);
		}

		cell = document.createElement('th');		//Cabecera 12: Origen
		cell.appendChild(document.createTextNode('Origen'));
		row.appendChild(cell);

		cell = document.createElement('th');		//Cabecera 13: Destino
		cell.appendChild(document.createTextNode('Destino'));
		row.appendChild(cell);

		cell = document.createElement('th');		//Cabecera 14: Distancia
		cell.appendChild(document.createTextNode('Distancia'));
		row.appendChild(cell);

		cell = document.createElement('th');		//Cabecera 15: Checkbox
		cell.appendChild(document.createTextNode('Enviar?'));
		row.appendChild(cell);

		table.appendChild(row);

		for(var i=begin;  i < end; i++){
			row=document.createElement('tr');
			for(var j=0; j <= nCols; j++){
				cell=document.createElement('td');

				switch(j){
					case 0:
						cell.appendChild(document.createTextNode((i+1) + '.'));
						break;
					case 1:	 // tropa 1
					case 2:	 // tropa 2
					case 3:  // tropa 3
					case 4:  // tropa 4
					case 5:  // tropa 5
					case 6:  // tropa 6
					case 7:  // tropa 7
					case 8:  // tropa 8
					case 9:  // tropa 9
					case 10: // tropa 10
					case 11: // tropa 11
						var tropa = document.createTextNode(atracos[i].tropas[j]? atracos[i].tropas[j]: 0);
						cell.appendChild(tropa);
						cell.setAttribute('style', 'text-align:center;vertical-align:middle;');
						break;
					case 12:
						cell.appendChild(document.createTextNode(atracos[i].origen));
						break;
					case 13:
						cell.appendChild(document.createTextNode(atracos[i].destino));
						break;
					case 14:
						cell.appendChild(document.createTextNode(atracos[i].distancia));
						break;
					case 15:
						var input = document.createElement('input');
						input.setAttribute('type', 'checkbox');
						input.setAttribute('onClick', 'checkRaid('+ i +')');
						input.setAttribute('id', 'guardar'+ (i - begin));
						if (atracos[i].enviar) input.setAttribute('checked', 'true');
						cell.appendChild(input);
						break;
				}
				row.appendChild(cell);
			}

			var input = document.createElement('input');
			input.setAttribute('type', 'hidden');
			input.setAttribute('name', 'idAtraco' + i);
			input.setAttribute('value', atracos[i].id);

			row.appendChild(input);
			table.appendChild(row);
		}
	}

	checkRaid = function(i)
	{
		atracos[i].enviar = !atracos[i].enviar;
		cantOrdenes = document.getElementById('cantOrdenes');
		cantOrdenes.value = parseInt(cantOrdenes.value) + 1;
	}

	getDestinos = function()
	{
		var sel = document.getElementById('origen').value;
		var oid = null;

		if (sel >= 0){
			oid = (400 - parseInt(aldeas[sel].y))*801 + (401 + parseInt(aldeas[sel].x));

			var getAtracos = new Ajax.Request(
				'datos_atracos.php',
				{
					method: "GET",
					parameters: { oid: oid },
					evalScripts: false,
					onSuccess: function( response ){
						body = document.getElementsByTagName('body')[0];
						script = document.createElement('script');
						script.innerHTML = response.responseText;
						body.appendChild(script);
					}
				}
			);
		}
		else{
			var getAtracos = new Ajax.Request(
				'datos_atracos.php',
				{
					method: "GET",
					parameters: { },
					evalScripts: false,
					onSuccess: function( response ){
						body = document.getElementsByTagName('body')[0];
						script = document.createElement('script');
						script.innerHTML = response.responseText;
						body.appendChild(script);
					}
				}
			);
		}
	}

<?include('datos_atracos.php');?>


	nNext = function(n)
	{

		begin = end;
		end = end + n;

		if (end >= nRows) end = nRows;

		// Parche para que guarde aunque se seleccionen atracos de multiples paginas.
		document.getElementById('cantOrdenes').value = -1;

		var button = document.getElementById('prev');
		button.setAttribute('value', '<- ' + (begin + 1));
		if (begin > 0) button.disabled = false;

		button = document.getElementById('next');
		button.setAttribute('value', (end + 1) + ' ->');
		if (end == nRows) button.disabled = true;
		
		showAtracos();
	}

	nPrevious = function(n)
	{
		end = begin;
		begin = begin - n;

		if(begin <= 0) begin = 0;
	
		// Parche para que guarde aunque se seleccionen atracos de multiples paginas.
		document.getElementById('cantOrdenes').value = -1;

		var button = document.getElementById('prev');
		button.setAttribute('value', '<- ' + (begin+1));
		if (begin == 0) button.disabled = true;

		button = document.getElementById('next');
		button.setAttribute('value', (end+1) + ' ->');
		if (end < nRows) button.disabled = false;
		
		showAtracos();
	}

	var inicio = null;

<?
	$n = -1;
	$saveOrdenArg = '';

	if (isset($_GET['orden'])) {

		$query =  "SELECT * FROM orden";
		$query .= " WHERE usuario = '".$_SESSION['usuario']."'";
		$query .= "   AND id = '".$_GET['orden']."'";
		$result = pg_query($query);
		$orden = pg_fetch_assoc($result);

		$query =  "SELECT * FROM atraco ";
		$query .= " WHERE c.usuario = '".$_SESSION['usuario']."'";
		$query .= "   AND c.cola_id = '".$_GET['orden']."'";
		$query .= " ORDER BY atraco_id";
		$result = pg_query($query);

		$n = pg_num_rows($query);
		$saveOrdenArg = ",".$_GET['orden'];
?>
		inicio = new Date("<?=$orden['inicio']?>");
		$('dia').value = inicio.getDate();
		$('mes').value = inicio.getMonth()+1;
		$('anho').value = inicio.getFullYear();
		$('hora').value = inicio.getHours();
		$('minutos').value = inicio.getMinutes();
<?		
	}
	else {
?>
		inicio = new Date();
		$('dia').value = inicio.getDate();
		$('mes').value = inicio.getMonth()+1;
		$('anho').value = inicio.getFullYear();
		$('hora').value = inicio.getHours();
		$('minutos').value = inicio.getMinutes();
<?
	}
?>


</script>

<!--------------------------------------------------------------------------------------------------------------------------
  -- PARTE ESTATICA DE LA PAGINA
  -------------------------------------------------------------------------------------------------------------------------->
<div id="header">
<a class="cerrar" href="javascript:cerrar_menu()">X</a>
<h2>Atracos</h2>
</div>

<div id="form">
	<input type="hidden" id="cantOrdenes" value="<?=$n?>" />
	<input type="hidden" id="modo" value="insert" />
	<label>Aldea de Origen</label><select id="origen" onChange="javascript:getDestinos()"></select>

	<br />	
	
	<table id="atracos"></table>

	<input type="button" id="prev" onClick="javascript:nPrevious(10)"/>
	<input type="button" id="next" onClick="javascript:nNext(10)"/>

	<br />
	<div>
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
	</div>
</div>

<div id="buttons">
	<input type="button" id="save" value="Guardar" onClick="javascript:saveOrden(atraco<?=$saveOrdenArg?>)" />
	<input type="button" id="cancel" value="Cancelar" onClick="javascript:cerrar_menu()" />
</div>

<script type="text/javascript" >
	document.getElementById('prev').setAttribute('value', '<- ' + (begin + 1));
	document.getElementById('next').setAttribute('value', (end + 1) + ' ->');
</script>

