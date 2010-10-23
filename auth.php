<?php

$valorfijo = "27091985blablabla";

function nuevo_usuario( $usuario, $password, $tipo ){
	global $valorfijo;
	
	$query = "INSERT INTO usuario (username,password, tipo) VALUES ";
	$query.= " '$usuario', md5 ('$password' || '$usuario' || '$valorfijo'),'$tipo' )";
	
	$result = pg_query($query);
}

function autenticar_usuario($usuario, $password){
	global $valorfijo;
	
	$query = "SELECT tipo, server, raza FROM usuario WHERE password = ";
	$query.= "md5('$password' ||'$usuario' || '$valorfijo' ) and username ='$usuario'";
	
	$result = pg_query($query);
	
	if ($tmp = pg_fetch_assoc($result)){

		$_SESSION['logueado'] = true;
		$_SESSION['usuario'] = $usuario;
		$_SESSION['tipo'] = $tmp['tipo'];
		$_SESSION['server'] = $tmp['server'];
		$_SESSION['raza'] = $tmp['raza'];
	}
}

function desloguear(){
	$_SESSION['logueado'] = false;
	$_SESSION['usuario'] = null;
	$_SESSION['tipo'] = null;
	$_SESSION['server'] = null;	
}

include_once('configuracion.php');

function control(){

	if ( ! $_SESSION['logueado']){
		echo "NO LOGUEADO";
		exit(0);
	}
}

/*
 * Realiza la autenticacion y setea el valor $_SESSION['logueado'] para registrar
 * el resultado de la autenticacion.
 * 
 * Ademas retorna false, si no se intento autenticar (si no se completo el form del login)
 * y retorna true si se intento autenticar.
 * 
 */
function login(){
	global $_POST;

	if( $_POST['usuario'] ){
		$usuario = $_POST['usuario'];
		$password = $_POST['password'];
		
		autenticar_usuario($usuario, $password);

		return true;
	}
		
	return false;
}
?>
