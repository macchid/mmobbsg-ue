/**
 *	Clase Orden
 *		- Informacion de una orden particular
 *		- Cada orden particular sabe como guardarse a si misma y a la informacion de la orden.
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
/*
		this.save = saveOrden;
		this.get = getOrden;
		this.drop = dropOrden;
		this.show = showOrden;
*/
	}

/**
 *	Clase Ordenes
 *		- Lista de ordenes definidas en el servidor.
 *		- Permite listar, guardar y borrar todas las ordenes.
 */
	function Ordenes(){ }

	Ordenes.save = function (ordenes)
	{
		if ( confirm('Esta seguro de eliminar estas ordenes?') )
		for(var i = 0; i < ordenes.length; i++ )
			ordenes[i].drop();
	};

	Ordenes.list = function ()
	{
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
	};

	Ordenes.drop = function (ordenes)
	{
		for (var i = 0; i < ordenes.length; i++ )
			ordenes[i].drop();
	};

/**
 *	Clase Form
 *		Formularios para manejo de los distintos tipos de ordenes.
 */
	function Form(background, form)
	{
		this.background = background;
		this.form = form;
	}

	/* Inicializa el formulario */
	Form.prototype.init = function()
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

	/* Muestra los campos del formulario para una orden */
	Form.prototype.show = function (orden)
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

	/* Oculta el formulario */
	Form.prototype.hide = function()
	{
		var body = getElementByTag('body');
		body.removeChild(document.getElementById(this.form));
		body.removeChild(document.getElementById(this.background));
	}

	/* Guarda la informacion del formulario */
	Form.prototype.submit = function()
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
	}
	
	/* Realiza una accion del menu */
	Menu.prototype.go = function (tipo, i)
	{
		var orden;
	
		if (i == undefined) 
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

	/* Recarga todas las entradas del menu */
	Menu.prototype.refresh = function ()
	{
		this.entries.delete;
		this.entries = Ordenes.list();
		this.display();
	}

	/* Muestra todas las entradas del menu */
	Menu.prototype.display = function ()
	{
		var table = document.getElementById('ordenes');

		/* Borrar todos los elementos de la tabla */
		table.innerHTML = new String();

		/* Carga las ordenes por turno */
		for (var i = 0; i < this.entries.count; i++)
			this.appendEntry(i);
	}

	/* Borra todas las entradas del menu */
	Menu.prototype.clear = function ()
	{
		var table = document.getElementById('ordenes');
		
		/* Borrar todas las entradas de la base de datos */
		Ordenes.drop(this.entries);

		/* Borrar toda la informacion en memoria*/
		this.entries.delete;
		
		/* Mostrar el menu vacio */
		this.display();
	}

	/* Muestra una entrada del menu en la pagina */
	Menu.prototype.showEntry = function(parent, i)
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

	/* Agrega una entrada al menu */
	Menu.prototype.appendEntry = function (orden)
	{
		/* Se guarda la entrada en la base de datos */
		orden.save();

		/* Se agrega a la lista de valores */
		this.entries.push(orden);

		/* Se actualiza la pagina */
		var table = document.getElementById('ordenes');
		this.show(table, this.entries.length - 1);
	}

	/* Borra una entrada de la lista de entradas del menu */
	Menu.prototype.removeEntry = function(erased)
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

	/* Muestra u oculta los detalles de la entrada del menu */
	Menu.prototype.entryDeatils = function(i, show)
	{
		if (i > this.entries.length) return 0;

		if (show)
		{
			this.entries[i].show();
			document.getElementById('info' + this.entries[i].id).style['display'] = 'block';
		}
		else
			document.getElementById('info' + this.entries[i].id).style['display'] = 'none';
	}

