<?php
require 'config.php';
require 'inc/session.php';

if(isset($_POST['a']) && isset($_POST['user']) && isset($_POST['pass'])) {
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	if($user == '' || $pass == '') die('2');
	
	if($_session->login($user, $pass) == false)
		die('1');
	die('3');
}

if($_session->isLogged())
	header('Location: home.php');
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
	<title>OSWSCRIPT - Login</title>
	
	<link type="text/css" rel="stylesheet" href="media/css/login.css" media="all" />
	<!--<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">-->
	<link href="media/css/all.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,600" rel="stylesheet" type="text/css">
	<link rel="icon" href="media/img/favicon.ico" type="image/x-icon" />
	
	<script type="text/javascript" src="media/js/jquery.min.js"></script>
	<script type="text/javascript" src="media/js/login.js"></script>
</head>
<body>
	<div id="center"></div>
	
	<div id="content">
		<div id="logo">
			<h2>INVENTARIO</h2>
			<!--<img src="media/img/oswscript.png" width="55" height="55" alt="OSWSCRIPT INVENTARIO" />-->
		</div>
		
		<div id="login">
			<div id="error"></div>
			<form method="POST" action="" name="login">
				NOMBRE DE USUARIO:<br />
				<input type="text" name="username" value="admin" /><br />
				CLAVE:<br />
				<input type="password" name="password" value="123456"/><br />
				
				<img src="media/img/loader.gif" id="loader">
				<input type="submit" name="send" value="Entrar" style="width:100%" />
			</form>
		</div>
	</div>
</body>
</html>