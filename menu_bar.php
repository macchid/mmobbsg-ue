<?
	include_once('auth.php');
	control();
?>
<div id="menu_bar">
	<ul>
		<li>
			<a href="javascript:menu.go('comercio')" style="background: url('img/mercado.png') no-repeat; color: #449944">
				Enviar<br/>Recursos</a>
			</li>
		<li>
			<a href="javascript:menu.go('recurso')" style="background: url('img/produccion.png') no-repeat; color: #449944">
				Subir<br/>Recursos
			</a>
		</li>
		<li>
			<a href="javascript:menu.go('construccion')" style="background: url('img/edif_princ.png') no-repeat; color: #449944">
				Construir<br/>Edificio
			</a>
		</li>
		<li>
			<a href="javascript:menu.go('atraco')" style="background: url('img/porra.png') no-repeat; color: #449944">
				Lanzar<br/>Atracos
			</a>
		</li>
		<li>
			<a href="javascript:menu.go('')" style="background: url('img/imperano.png') no-repeat; color: #449944">
				Lanzar<br/>Ataques
			</a>
		</li>
		<li>
			<a href="javascript:menu.go('entrenamiento')" style="background: url('img/cuartel.gif') no-repeat; color: #449944">
				Entrenar<br/>Tropas
			</a>
		</li>
	</ul>
</div>
