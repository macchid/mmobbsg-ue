<?php
	include_once('session.php');
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="slave.css" />
		<script type="text/javascript" src="prototype.js"></script>
	</head>
	<body>
<?php

	#try to login
	if (isset($_POST['login'])) { 
		if(! login($_POST['username'], $_POST['password'])){
?>
			<p><strong>Combinaci&oacute;n usuario/contrase&ntilde;a incorrecta! Usted no tiene permiso de acceso.</strong></p>
<?php 
		}
	}
	
	#if asked to logout
	if (isset($_GET['logout'])) {
		logout();
		echo "<p><strong>Usuario desconectado!</strong></p>";
	}

	#show login form when not logged in
	if (!isset($_SESSION['auth_userID'])) {
?>
		<form action="main.php" method="post">
			<p><label>Usuario: </label><input type="text" name="username" /></p>
			<p><label>Contrase&ntilde;a: </label><input type="password" name="password" /></p>
			<input type='submit' name='login' value='Ingresar' />
		</form>
<?php
    die();
} 
?>
		<p><strong>Logeado con usuario: <?php echo $_SESSION['auth_username'];?></strong><br />
		<a class="cerrar" href='main.php?logout'>Cerrar Sesi&oacute;n</a></p>

		<div id="bot_status"><?include("status.php");?></div>
		<h4>Server : <?=$_SESSION['server']?></h4>
		<h4>User : <?=$_SESSION['usuario']?></h4>
		<?include('menu_bar.php');?>
		<table>
			<tr>
				<td class="ordenes_container" width="480">
					<h3>Ordenes<a href="javascript:resetOrdenes()"> Borrar todo </a></h3>
					<table id="ordenes"></table>
			</td>
			</tr>
		</table>
		<script type="text/javascript" src="motor.js"></script>
		<script language="JavaScript" type="text/javascript" id="updateOrdenes">
			<?include('ordenes.php');?>
		</script>

	</body>
</html>
