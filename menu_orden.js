	var edificios = new Array();
	const TO_CONSTRUCCION = "construccion";
	const TO_ENVIORECURSOS = "comercio";
	const TO_SUBIRPRODUCCION = "produccion";
	const TO_ENTRENAMIENTO = "entrenamiento";
	const TO_ATRACO = "atraco";

	edificios[1]="Le&ntilde;ador";
	edificios[2]="Barrera";
	edificios[3]="Mina de Hierro";
	edificios[4]="Granja";
	edificios[5]="Serreria";
	edificios[6]="Ladrillar";
	edificios[7]="Fundicion de Hierro";
	edificios[8]="Molino";
	edificios[9]="Panaderia";
	edificios[10]="Almacen";
	edificios[11]="Granero";
	edificios[12]="Armeria";
	edificios[13]="Herreria";
	edificios[14]="Plaza de Torneos";
	edificios[15]="Edificio Principal ";
	edificios[16]="Plaza de Reuniones";
	edificios[17]="Mercado";
	edificios[18]="Embajada";
	edificios[19]="Cuartel";
	edificios[20]="Establo";
	edificios[21]="Taller";
	edificios[22]="Academia";
	edificios[23]="Escondite";
	edificios[24]="Ayuntamiento";
	edificios[25]="Residencia";
	edificios[26]="Palacio";
	edificios[27]="Tesoro";
	edificios[28]="Oficina de Comercio";
	edificios[29]="Cuartel Grande";
	edificios[30]="Establo Grande";
	edificios[31]="?? (muralla)";
	edificios[32]="Terraplen";
	edificios[33]="?? (empalizada)";
	edificios[34]="Cantero";
	edificios[35]="?? (Trampero/Cerveceria/Abrevadero)";
	edificios[36]="?? (Trampero/Cerveceria/Abrevadero)";
	edificios[37]="Hogar del Heroe";
	edificios[38]="Gran Almacen";
	edificios[39]="Gran Granero";
	edificios[40]="";


/**
 *	Clase Orden
 *		- Informacion de una orden particular
 *		- Permite guardar, obtener y borrar una orden del servidor.
 */
	function Orden(xmlText)
	{
		if (xmlText != undefined) //Initialization from xml text.
		{
			var parser = DOMParser();
			var xml = parser.parserFromString(xmlText);

			this.id = xml.getElementsByTagName('orden')[0].getAttribute('id');
			this.usuario = xml.getElementsByTagName('usuario')[0].textContent;
			this.inicio = new Date(xml.getElementsByTagName('inicio')[0].textContent);
			this.tipo = xml.getElementsByTagName('tipo')[0].textContent;
		}
		else //Default initialization
		{
			this.id = new Number();
			this.usuario = new String();
			this.inicio = new Date();
			this.tipo = new String();
		}

		this.save = saveOrden;
		this.get = getOrden;
		this.drop = dropOrden;
		this.show = showOrden;
	}

	function getOrden(id)
	{
		var orden;

		var request = new Ajax.Request(
			'../get.php',
			{
				method:	'POST',
				parameters: { id: this.id },
				onSuccess: function( response ){
					orden = new Orden(response.responseText);
				}
			}
		);

		return orden;
	}

	function saveOrden()
	{
		var request = new Ajax.Request(
			'../set.php',
			{
				method: 'POST',
				parameters: {
					id: 		(this.id ? this.id : new Number()),
					usuario:	this.usuario,
					inicio:		this.inicio.format('yyyymmddhh24miss'),
					tipo:		this.tipo
				},
				onSuccess: function( response ){
					/* actualizar los datos de la clase */
				}
			}
		);
	}

	function dropOrden()
	{
		var request = new Ajax.Request(
			'../drop.php',
			{
				method:	'POST',
				parameters: { id: this.id },
				onSuccess: function (response){
					/* que hacer cuando se borra bien? */
				}
			}
		);
	}

/**
 *	Clase Ordenes
 *		- Lista de ordenes definidas en el servidor.
 *		- Permite listar, guardar y borrar todas las ordenes.
 */
	function Ordenes()
	{
		this.save = saveAll;
		this.list = listAll;
		this.drop = dropAll;
	}


	function listAll(){
		var ordenes = new Array();

		var request = new Ajax.Request(
			'../get.php',
			{
				method: "POST",
				parameters: {},
				evalScripts: true,
				onSuccess: function( response ){
					var xml = /(<orden id="[0-9]*">.*<\/orden>\n)+/.exec(response.responseText);
					for( var i = 0; i < xml.length; i++)
						this.data[i] = new Orden(xml[i]);
				}
			}
		);

		return ordenes;
	}

	function dropAll(ordenes)
	{
		if ( confirm('Esta seguro de eliminar estas ordenes?') )
			for(var i = 0; i < ordenes.length; i++ )
				ordenes[i].drop();
	}

	function saveAll(ordenes)
	{
		for (var i = 0; i < ordenes.length; i++ )
			ordenes[i].save();
	}

/**
 *	Clase Form
 *		Formularios para manejo de los distintos tipos de ordenes.
 */
	function Form(background, form)
	{
		this.background = background;
		this.form = form;

		this.init = initForm();
		this.show = showForm();
		this.hide = hideForm();
		this.submit = submitForm();
	}

	function initForm()
	{
		var body = document.getElementsByTagName('body')[0];

		var background = document.createElement('div');
		background.setAttribute('class',this.background);
		background.id = this.background;

		var form = document.createElement('div');
		form.setAttribute('class',this.form);
		form.id = this.form;

		body.insertBefore(background, body.firstChild);
		body.insertBefore(form, background);
	}

	function showForm(orden)
	{
		url = orden.tipo + '/form.php';
		var a = new Ajax.Updater(
			this.form,
			url,
			{
				method:"GET",
				parameters: orden.id ? {id:orden.id} : {},
				evalScripts: true
			}
		);
	}

	function hideForm()
	{
		var body = getElementByTag('body');
		body.removeChild(document.getElementById(this.form));
		body.removeChild(document.getElementById(this.background));
	}

	function submitForm()
	{
		/* va a ser parecido a saveOrden */




	};

/**
 *	Clase Menu
 *		Principalmente, se refiere al manejo de la lista de ordenes.
 */
	function Menu()
	{
		this.entries = Ordenes.list();

		this.go = goMenu;		/* Ejecuta los comandos de un menu */
		this.refresh = refreshMenu;	/* Vuelve a cargar todas las entradas */
		this.display = displayMenu;	/* Muestra todas las entradas */

		this.show = showEntry;		/* Muestra una entrada particular */
		this.add = addEntry;
		this.remove = removeEntry;	/* Elimina una entrada particular */
	}

	function displayMenu()
	{
		var table = document.getElementById('ordenes');

		/* Borrar todos los elementos de la tabla */
		table.innerHTML = new String();

		for (var i = 0; i < this.entries.count; i++)
			this.appendEntry(i);
	}

	function refreshMenu()
	{
		this.entries.delete;
		this.entries = Ordenes.list();
		this.show();
	}

	function goMenu(tipo, i)
	{
		var orden;
	
		if (orden == undefined) 
		{
			orden = new Orden();
			orden.tipo = tipo;
		}
		else
		{
			orden = this.entries[i];
		}
	
		var form = new Form('bg', 'form');	
		form.init();
		form.show(orden);
	}


	function showEntry(parent, i)
	{
		/* Primera fila: Información de la orden */
		var row = document.createElement('tr');
		row.setAttribute('id', 'orden' + this.entries[i].id);
		row.setAttribute('class', 'orden');

		var cell = document.createElement('td');
		cell.setAttribute('onMouseOver',"menu.showDetails("+ i + ")");
		cell.setAttribute('onMouseOut',"menu.hideDetails("+ i + ")");
		cell.innerHTML = this.ordenes[i].tipo;
		row.appendChild(cell);

		cell = document.createElement('td');
		cell.setAttribute('class', 'tiempo');
		cell.innerHTML = showDate( orden.inicio );
		row.appendChild(cell);

		cell = document.createElement('td');
		cell.innerHTML  = "<a href='javascript:menu.go('" + tipo + "'," + i + ")'>";
		cell.innerHTML += "<img src='../img/edit.jpg' border='0'/></a>";
		row.appendChild(cell);

		cell = document.createElement('td');
		cell.innerHTML  = "<a href='javascript:menu.remove(" + i + ")'>";
		cell.innerHTML += "<img src='../img/delete.jpg' border='0'/></a>";
		row.appendChild(cell);

		parent.appendChild(row);

		/* Segunda fila: Separador */
		row = document.createElement('tr');
		
		cell = document.createElement('td');
		cell.setAttribute('colspan', '4px');
		cell.innerHTML = '<hr />'
		row.appendChild(cell);
		parent.appendChild(row);

		return row;
	}

	function removeEntry(erased)
	{
		/* Se borra la entrada de la base de datos */
		this.entries[erased].drop;

		/* Se borra de la lista de ordenes de la pagina */
		var toRemove = document.getElementById('orden' + this.entries[i].id);
		var parent = toRemove.parentNode;
		parent.removeChild(toRemove);

		/* Se actualiza  los valores de la lista de entradas */
		for (var i = erased + 1; i < this.entries.length; i++)
			this.entries[i - 1] = this.entries[i];
	}

	function appendEntry(orden)
	{
		/* Se guarda la entrada en la base de datos */
		

		/* Se agrega a la lista de valores */
		this.entries.push(orden);

		/* Se actualiza la pagina */
		var table = document.getElementById('ordenes');
		this.show(table, this.entries.length - 1);
	}

	function showDetails(i)
	{
		if (i > this.entries.length) return 0;

		this.entries[i].show();
		document.getElementById('info' + this.entries[i].id).style['display'] = 'block';
	}

	function hideDetails(i)
	{
		if (i > this.entries.length) return 0;
	
		document.getElementById('info' + this.entries[i].id).style['display'] = 'none';
	}










































/*


	function saveOrden(orden, id){
		if ( ! SERVER.length > 0 ){
			alert("Debe definir primero el servidor.!!");
			return;
		}
		
		if ( orden_actual < 0 ) {
			orden_actual = 0;
		}

		modificar = id != null;
		n = $('cantOrdenes').value;
		cantOrdenes = 0;

		for ( i = 0; i <= n; i++ ){
			cantOrdenes += ($('guardar'+i).checked) ? 1 : 0;
		}
		
		if ( ! modificar ){
			ultima_orden = ultima_orden + 1;
			id = ultima_orden;
		}

		if ( $('inicio').value == "fijar_hora") {
			fecha = new Date(
				$('anho').value + "/" + ($('mes').value) + "/" + $('dia').value +
				" " + $('hora').value + ":" + $('minutos').value
			);
		} else if ( $('inicio').value == "inmediato") {
			if ( id > 0 ){
				fecha = ordenes[id-1].inicio;
				fecha.setMinutes(fecha.getMinutes()+ordenes[id-1].duracion/60000);
			} else {
				fecha = new Date();
			}
		} else {
			alert('Error Interno: el valor del campo inicio es :' + $('inicio').value);
			return;
		}

		fecha2 =   fecha.getFullYear() + "/"
					+ ((fecha.getMonth()+1) < 10 ? "0" : "") + (fecha.getMonth()+1) + "/"
					+ (fecha.getDate() < 10 ? "0" : "") + fecha.getDate() + " "
					+ (fecha.getHours() < 10 ? "0" : "") + fecha.getHours() + ":"
					+ (fecha.getMinutes() < 10 ? "0" : "") + fecha.getMinutes();

		if( modificar ){
			if ( cantOrdenes > 0 ) {
				$('modo').value = modo = "update";
			} else {
				$('modo').value =modo = "delete";
			}
		} else {
			$('modo').value = modo = "insert";
		}

//			C	N
//			T	T	=> Se agrega / modifica ordenes existentes
//			T	F  => Se agrega una nueva orden
//			F	T	=> Se elimina completamente las ordenes
//			F	F  => Se abre el menu para agregar uno nuevo, pero no se agrega nada.

		if ( cantOrdenes > 0 || n > 0) {
			orden.setParams(id);
			var setOrden = new Ajax.Updater(
				'',
				'set_orden.php',
				{
					parameters: {
						id: id,
						tipo: orden.tipo,
						inicio: fecha2,
						modo: modo
					},
					method: "POST"
				}
			);
		}

		if (cantOrdenes > 0) {
			
			var getOrdenes = new Ajax.Request(
				'ordenes.php',
				{
					method: "GET",
					evalScripts: true,
					onSuccess: function( response ){
						$('ordenes').innerHTML = '';
						body = document.getElementsByTagName('body')[0];
						script = document.createElement('script');
						script.innerHTML = response.responseText;
						body.appendChild(script);
					}
				}
			);
		}
		
		if ((modo == "delete" || cantOrdenes == 0) && confirm('Desea agregar una orden más?') ){
		} else {
			cerrar_menu();
		}
	}

	function addOrden( descripcion, id, tipo, fecha ) {
		list_ordenes = $('ordenes');
		tr = document.createElement('tr');
		tr.id = 'orden'+id;
		tr.setAttribute('class', 'orden');
		td = document.createElement('td');
		td.setAttribute('onMouseOver',"showDescription("+id+")");
		td.setAttribute('onMouseOut',"hideDescription("+id+")");
		td.innerHTML = descripcion;
		tr.appendChild(td);
	
		td = document.createElement('td');
		td.setAttribute('class', 'tiempo');
		td.innerHTML = showDate( fecha );
		tr.appendChild(td);

		td = document.createElement('td');
		buffer = "<a href='javascript:show_menu(\""+tipo+"\","+id+")'>";
		buffer += "<img src='img/edit.jpg' border='0'/></a>";
		td.innerHTML = buffer;
		tr.appendChild(td);
		
		padre = $('ordenes');
		padre.appendChild(tr);
		padre.innerHTML += "</td></tr><tr><td colspan='4'><hr/></td>";
	}

	
	function showDescription(id_orden){
		if( id_orden > ultima_orden ){
			return;
		}

		$('info'+id_orden).style['display'] = "block";
	}

	function hideDescription(id_orden){
		if( id_orden > ultima_orden ){
			return;
		}

		$('info'+id_orden).style['display'] = "none";
	}

//Definicion de funciones y objetos del proceso de Construccion
	function setConstruccion(id){
		n = $('cantOrdenes').value;

		for ( i=0; i < n; i++ ){
			if( i < n ){
				if ( $('guardar'+i).checked ) {
					modo = "update"
				}else{
					modo = "delete";
				}
			}

			var construccion = new Ajax.Updater(
				'',
				'set_construccion.php',
				{
					parameters: {
						grupo_id: id,
						id: $('idConstruccion'+i).value,
						gid: $('edificio'+i).value,
						nivel: $('nivel'+i).value,
						aldea: $('aldea'+i).value,
						modo: modo
					},
					method: "POST"
				}
			);
		}

		if ( $('guardar'+n).checked ) {
			var construccion = new Ajax.Updater(
				'',
				'set_construccion.php',
				{
					parameters: {
						grupo_id: id,
						id: $('idConstruccion'+n).value,
						gid: $('edificio'+n).value,
						nivel: $('nivel'+n).value,
						aldea: $('aldea'+n).value,
						modo: "insert"
					},
					method: "POST"
				}
			);
		}
	}

	function getConstruccionInfo( datos ) {
		desc = '';
		n = datos.n;
		id = datos.id;
	
		for ( i = 0; i < n; i++ ){
			aldea = datos.construcciones[i].aldea;
			gid = datos.construcciones[i].gid;
			nivel = datos.construcciones[i].nivel;

			coords = "("+aldeas[aldea].x+"|"+aldeas[aldea].y+")";	
			desc += "Ampliar "+edificios[gid]+" de "+coords+" a nivel "+(parseInt(nivel)+1)+"<br/>";
		}

		desc = "<div id='info"+id+"' class='info' style='display:none'>"+desc+"</div>";
		desc = desc + "<img src='img/edif_princ.png' width='60' height='50'/>";

		return desc;
	}

	construccion = {
		setParams: setConstruccion,
		getInfo: getConstruccionInfo,
		duracion: 120000,
		tipo: TO_CONSTRUCCION
	};

//Definicion de funciones y objetos del proceso de Subir Produccion
	function setSubirProduccion(id){
		modo = $('modo').value;

		inicio = new Date(
				$('anho').value + "/" + ($('mes').value) + "/" + $('dia').value +
				" " + $('hora').value + ":" + $('minutos').value
		);

		fin = new Date(inicio);
		fin.setMinutes(fin.getMinutes()+parseInt($('duracion').value));

		fin =  fin.getFullYear() + "/"
					+ ((fin.getMonth()+1) < 10 ? "0" : "") + (fin.getMonth()+1) + "/"
					+ (fin.getDate() < 10 ? "0" : "") + fin.getDate() + " "
					+ (fin.getHours() < 10 ? "0" : "") + fin.getHours() + ":"
					+ (fin.getMinutes() < 10 ? "0" : "") + fin.getMinutes();
		
		inicio = inicio.getFullYear() + "/"
					+ ((inicio.getMonth()+1) < 10 ? "0" : "") + (inicio.getMonth()+1) + "/"
					+ (inicio.getDate() < 10 ? "0" : "") + inicio.getDate() + " "
					+ (inicio.getHours() < 10 ? "0" : "") + inicio.getHours() + ":"
					+ (inicio.getMinutes() < 10 ? "0" : "") + inicio.getMinutes();

		var subir_produccion = new Ajax.Request(
			'set_subir_produccion.php',
			{
				parameters: {
					orden_id: id,
					inicio: inicio,
					fin: fin,
					razon: $('razon').value,
					aldea: $('aldea').value,
					modo: modo
				},
				method: "POST"
			}
		);
	}	

	function getSubirProduccionInfo(datos){
		desc = '';
		id = datos.orden_id;
	
		aldea = datos.aldea;
		fin = datos.fin;
		razon = datos.razon;
		coords = "("+aldeas[aldea].x+"|"+aldeas[aldea].y+")";	
		desc += "Subir produccion de "+coords+" hasta el "+fin + " a razon de "+razon;

		desc = "<div id='info"+id+"' class='info' style='display:none'>"+desc+"</div>";
		desc = desc + "<img src='img/produccion.png'/>";

		return desc;
	}

	subir_produccion = {
		setParams: setSubirProduccion,
		getInfo: getSubirProduccionInfo,
		duracion: 120000,
		tipo: TO_SUBIRPRODUCCION
	};

//Definicion de funciones y objetos del proceso de Envio de Recursos
	function setEnvioRecursos(id){
		modo = $('modo').value;

		var envio = new Ajax.Request(
			'set_entrenamiento.php',
			{
				parameters: {
					modo: modo,
					orden_id: id,
					madera: $('madera').value,
					barro: $('barro').value,
					hierro: $('hierro').value,
					cereal: $('cereal').value,
					destino: $('destino').value,
					origen: $('origen').value,
					viajes: $('viajes').value,
					intervalo: $('intervalo').value
				},
				method: "POST"
			}
		);
	}	
	
	function getEnvioRecursosInfo(datos){
		origen = aldeas[datos.origen].descripcion;
		destino = aldeas[datos.destino].descripcion;

		desc = "<table style='color:white'><tr>";
		desc += "<td>Env&iacute;o de </td>";

		carga = "<table  class='carga'>";
		carga += "<tr><td><img src='img/madera.png'/></td><td>"+datos.madera+"</td></tr>";
		carga += "<tr><td><img src='img/barro.png'/></td><td>"+datos.barro+"</td></tr>";
		carga += "<tr><td><img src='img/hierro.png'/></td><td>"+datos.hierro+"</td></tr>";
		carga += "<tr><td><img src='img/cereal.png'/></td><td>"+datos.cereal+"</td></tr>";
		carga += "</table>"
		
		desc += "<td>"+carga+"</td>";
		desc += "<td/> desde la aldea "+origen+" a la aldea "+destino+" " + datos.viajes + " veces ";
		desc += "cada "+datos.intervalo+"mins </td>";
		desc += "</tr></table>";
		
		info = "<div id='info"+datos.orden_id+"' class='info' style='display:none'>"+desc+"</div>";
		info = info + "<img src='img/mercado.png' width='70' height='60' style='float: left'/>";

		return info;
	}

	envio_recursos = {
		setParams: setEnvioRecursos,
		getInfo: getEnvioRecursosInfo,
		duracion: 120000,
		tipo: TO_ENVIORECURSOS
	};
	
//-------------------------------------------------------------------------------------------------------------
	function setEntrenamiento(id){
		modo = $('modo').value;
		var i;
		
		for ( i = 1; i < 9; i++ ){
			if( $('t'+i).value > 0 ) {
				sgte_tropa = i;
				break;
			}
		}

		var entrenamiento = new Ajax.Request(
			'set_entrenamiento.php',
			{
				parameters: {
					modo: modo,
					orden_id: id,
					t1: $('t1').value,
					t2: $('t2').value,
					t3: $('t3').value,
					t4: $('t4').value,
					t5: $('t5').value,
					t6: $('t6').value,
					t7: $('t7').value,
					t8: $('t8').value,
					sgte_tropa: sgte_tropa,
					aldea: $('aldea').value,
					activo: $('activo').value
				},
				method: "POST"
			}
		);
	}
	
	function getEntrenamientoInfo(datos){
		desc = "<table style='color:white'><tr>";
		desc += "<td>Entrenamiento</td>";
			
		train_spec = "";
		train_img = "";
		for ( i = 1; i < 9; i++ ){
			train_img += "<td><img src='img/tropas/"+raza+i+".png'/></td>";
			train_spec += "<td>"+datos.tropas[i]+"</td>";
		}
		train_spec = "<tr>"+train_spec+"</tr>";
		train_img = "<tr>"+train_img+"</tr>";
		train_spec = "<table  class='train_spec'>"+train_img+train_spec+"</table>";

		aldea = datos.aldea;
		coords = "("+aldeas[aldea].x+"|"+aldeas[aldea].y+")";
			
		desc += coords + train_spec;
			
		info = "<div id='info"+datos.orden_id+"' class='info' style='display:none'>"+desc+"</div>";
		info = info + "<img src='img/cuartel.gif' width='65' height='90' style='float: left'/>";

		return info;
	}
	
	entrenamiento = {
		setParams: setEntrenamiento,
		getInfo: getEntrenamientoInfo,
		duracion: 120000,
		tipo: TO_ENTRENAMIENTO
	};



//------------------------------------------------------------------------------------------------------------
// Atracos
//------------------------------------------------------------------------------------------------------------	/**

//	 * No se guarda ninguna informacion con respecto al atraco en si. Esa informacion sera tratada aparte en 
//	 * la pagina de administracion de atracos.

	function setAtraco(orden_id){

	alert(orden_id);

//		Borrar los atracos en la fila 'orden_id' 
		if (orden_id)
		{
			var atraco = new Ajax.Request(
				'set_atraco.php',
				{
					parameters: {
						modo: 'delete',
						queue: orden_id
					},
					method: "POST"
				}
			);

//			Borrar la fila 'orden_id'
			var fila = new Ajax.Request(
				'set_queue.php',
				{
					parameters: {
						modo: 'delete',
						id: orden_id
					},
					method:"POST"
				}
			);
		}

//		 Construir la fila circular de atracos en memoria 
		var primerAtraco = null;
		var ultimoAtraco = null;

		for (var i = 0; i < nRows ; i++)
		{
			if(atracos[i].enviar)
			{
				if(!primerAtraco) //&& !ultimoAtraco
					primerAtraco = i;
				else
					 atracos[ultimoAtraco].siguiente = i;

				ultimoAtraco = i;
			}
		}
		atracos[ultimoAtraco].siguiente = primerAtraco;
	
//		 Crear el contenedor persistente de la fila de atracos 
		fila = new Ajax.Request(
			'set_queue.php',
			{
				parameters: {
					modo: 'insert',
					id: orden_id,
					front:primerAtraco,
					rear: ultimoAtraco
				},
				method:"POST"
			}
		);


//		 Guardar la fila circular de atracos de forma persistente 
		var curr = primerAtraco;
		do
		{
			atraco = new Ajax.Request(
				'set_atraco.php',
				{
					parameters: {
						modo: 'insert',
						id: curr,
						queue: orden_id,
						atraco: atracos[curr].id,
						siguiente: atracos[curr].siguiente
					},
					method: "POST"
				}
			);

			curr = atracos[curr].siguiente;
		}while(curr != primerAtraco) //Si volvemos al primer elemento, ya completamos la lista.
	}	


	function getAtracoInfo(datos){

		desc  = "<div style='color:white'><b>Atracos</b>";
		desc += "<table class='atracos' style='background-color:white;border-color:red'>"
		desc += "<tr><th colspan=100%>Atraco desde " + datos.atraco.origen + " hacia " + datos.atraco.destino + 
				"</th></tr>";

		var cabecera = new String();
		var valores = new String();		
		for (var t = 0; t < 11; t++){
			cabecera += "<th><img src='img/tropas/" + datos.raza + (t+1) + ".png'</th>";
			valores += "<td style='text-align:center'>"+ datos.atraco.tropas[t] +"</td>";
		}
		cabecera += "</tr>";
		valores +=  "</tr>";

		desc += cabecera + valores + "</table></div>";
		
		info = "<div id='info"+datos.orden_id+"' class='info' style='display:none'>"+desc+"</div>";
		info = info + "<img src='img/porra.png' width='70' height='60' style='float: left'/>";

		return info;
	}

	atraco = {
		setParams:	setAtraco,
		getInfo:	getAtracoInfo,
		duracion:	0,
		tipo:		TO_ATRACO
	};
*/
