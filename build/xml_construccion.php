<?php	
	$query =  "SELECT c.*, a.did FROM construccion c, aldea a";
	$query .= " WHERE c.usuario = '".$_SESSION['usuario']."'";
	$query .= "   AND a.usuario = '".$_SESSION['usuario']."'";
	$query .= "   AND c.aldea = a.id";
	$query .= "   AND c.grupo_id = ".$orden['id'];
	$result = pg_query($query);
	
	if ( $result ){
		$restantes = pg_num_rows($result)-1;
		$construccion = pg_fetch_assoc($result);
	} else {
		$construccion = array('id'=>"NotFound");
	}
?>
	<construccion restantes="<?=$restantes?>" id="<?=$construccion['id']?>" aldea="<?=$construccion['did']?>">
		<gid><?=$construccion['gid']?></gid>
		<nivel><?=$construccion['nivel']?></nivel><?
	if ( $construccion['gid'] <= 4 ) {
		$query =  "SELECT p.id FROM parcela p, aldea a";
		$query .= " WHERE a.id = '".$construccion['aldea']."' ";
		$query .= "   AND a.tipo_aldea = p.tipo_aldea ";
		$query .= "   AND p.tipo_parcela = '".$construccion['gid']."'";

		$result = pg_query($query);

		while($fila = pg_fetch_assoc($result)){
?>
		<parcela><?=$fila['id']?></parcela>
<?			
		}
	}
?></construccion>
