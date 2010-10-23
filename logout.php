<?php
	include('auth.php');
	desloguear();
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="slave.css" />
	</head>
	<body>
		<div id="container">
			<h1> Se ha desconectado exitosamente </h1>
			En breve sera redirigido a la pagina principal.
			<script type="text/javascript">
				setTimeout("document.location.href='index.php'",5000);
			</script>		
		</div>
	</body>
</html>