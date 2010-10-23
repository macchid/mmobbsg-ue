	var frame = $("screen");
	var MERCADO = "/build.php?gid=17";
	var CAMPO_RECURSOS = "/dorf1.php";

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	////// EJECUCION DE ORDENES
	function resetearFrame(){
		frame.src = SERVER + CAMPO_RECURSOS;
	}

	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	////// MANEJO DE ORDENES
		
	function borrar_orden( ){
		orden = document.getElementsByClassName('orden')[0];
		padre = orden.parentNode;
		padre.removeChild( orden );
	}

	
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	////// FUNCIONES VARIAS
	
	function cambiar_inicio(){
		if ( $('inicio').value == "fijar_hora" ){
			
			$('inicio').value = 'inmediato';
			$('inicio_text').innerHTML = 'Un minuto despu&eacute;s del anterior';
			$('horario').style['display'] = "none";
		} else {
			$('inicio').value = 'fijar_hora';
			$('inicio_text').innerHTML = 'Fijar horario de inicio';
			$('horario').style['display'] = "inherit";
		}
	}
	
	function getProxNivel(id){
		$('prox_nivel'+id).innerHTML =  1 + parseInt($('nivel'+id).value);
	}
	
	function getElementByTag( tag ){
		return document.getElementsByTagName(tag)[0];
	}
	
	function showDate( date ){
		return fecha = (date.getDate() < 10 ? "0" : "") + date.getDate() + "/"
					+ ((date.getMonth()+1) < 10 ? "0" : "") + (date.getMonth()+1) + "/"
					+ date.getFullYear() + " "
					+ (date.getHours() < 10 ? "0" : "") + date.getHours() + ":"
					+ (date.getMinutes() < 10 ? "0" : "") + (date.getMinutes());
	}

	
	//////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////
	////// FUNCION PRINCIPAL
	function siguienteOrden(){
		orden_actual++;
	}

	function actualizar(){
		updateEstado();
		updateOrdenes();
	
		setTimeout('actualizar()',300000);
	}
	
	function updateOrdenes(){
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

	function updateEstado(){
		var getOrdenes = new Ajax.Updater(
			'bot_status',
			'status.php',
			{
				method: "GET",
			}
		);
	}

	function cambiarEstado(actual){
		if ( actual == 'off' ){
			var getOrdenes = new Ajax.Updater(
				'bot_status',
				'status.php',
				{
					method: "POST",
					parameters: { activar: true }
				}
			);	
		} else {
			var getOrdenes = new Ajax.Updater(
				'bot_status',
				'status.php',
				{
					method: "POST",
					parameters: { desactivar: true }
				}
			);	
		}
	}

	actualizar();