<?php
	include_once('session.php');
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/slave.css"/>
		<script type="text/javascript" src="prototype.js"></script>
		<script type="text/javascript" src="menu_orden.js"></script>
	</head>
	<body>
<?php

	#try to login
	if (isset($_POST['login'])) { 
		if(! login($_POST['username'], $_POST['password'])){
?>
			<p class='error'>Combinaci&oacute;n usuario/contrase&ntilde;a incorrecta! Usted no tiene permiso de acceso.</p>
<?php 
		}
		else{
		#clean post parameters.
?>
			<script type='text/javascript'> window.location.assign('index.php');</script>
<?php
		}
	}
	
	#if asked to logout
	if (isset($_GET['logout'])) {
		logout();
		$_SESSION['info'] = "<p class='info'>Usuario desconectado!</p>";
	}

	#show login form when not logged in
	if (!isset($_SESSION['auth_userID'])) {
?>
		<div class='bg'>
			<form class='login' action="index.php" method="post">
				<table>
					<tr><td><label>Usuario: </label></td><td><input type="text" name="username" /></td></tr>
					<tr><td><label>Contrase&ntilde;a: </label></td><td><input type="password" name="password" /></td></tr>
				</table>
				<input type='submit' name='login' value='Ingresar' />
				<?=$_SESSION['info']?>
			</form>
		</div>

<?php
    die();
} 
?>
		<p class='header'>
			<b>Servidor:</b><i> <?=$_SESSION['server']?></i> | 
			<b>Usuario:</b><i> <?= $_SESSION['auth_username']?></i> |
			<a href='index.php?logout' class='header'>Cerrar Sesi&oacute;n</a>
		</p>

		<div class='menu'>
			<ul>
				<li>
					<a href="javascript:menu.go('market')" style="background: url('img/mercado.png') no-repeat; color: #449944">
						Enviar<br/>Recursos
					</a>
				</li>
				<li>
					<a href="javascript:menu.go('resource')" style="background: url('img/produccion.png') no-repeat; color: #449944">
						Subir<br/>Recursos
					</a>
				</li>
				<li>
					<a href="javascript:menu.go('build')" style="background: url('img/edif_princ.png') no-repeat; color: #449944">
						Construir<br/>Edificio
					</a>
				</li>
				<li>
					<a href="javascript:menu.go('raid')" style="background: url('img/porra.png') no-repeat; color: #449944">
						Lanzar<br/>Atracos
					</a>
				</li>
				<!--li>
					<a href="javascript:menu.go('')" style="background: url('img/imperano.png') no-repeat; color: #449944">
						Lanzar<br/>Ataques
					</a>
				</li-->
				<li>
					<a href="javascript:menu.go('training')" style="background: url('img/cuartel.gif') no-repeat; color: #449944">
						Entrenar<br/>Tropas
					</a>
				</li>
			</ul>
		</div>
		<div class='orders'>
			<h3>Ordenes<a href='javascript:menu.clear()'> Borrar todo </a></h3>
			<table id='ordenes'></table>
		</div>
		<iframe class='travian' src="http://<?=$_SESSION['server']?>/dorf1.php" frameborder='0'> 
			iFrame no soportado! Mejor utilice firefox, chrome u opera 
		</iframe>
		<script type="text/javascript">
			var menu = new Menu();
			//menu.display();
		</script>
	</body>
</html>
