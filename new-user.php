<?php
require 'config.php';
require 'inc/session.php';
require 'inc/users_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 10;

$role = $_session->get_user_role();
$id_user_active = $_session->get_user_id();

if($role == 4)
	header('Location: home.php');

if(isset($_POST['act'])) {
	if($_POST['act'] == '1') {
		$role_ = $_session->get_user_role();
		if(!isset($_POST['name']) || !isset($_POST['dni']) || !isset($_POST['username']) || !isset($_POST['password1']) || !isset($_POST['password2']) || !isset($_POST['email']) || !isset($_POST['role']))
			die('wrong');
		if($_POST['name'] == '' || $_POST['dni'] == '' || $_POST['username'] == '' || $_POST['password1'] == '' || $_POST['password2'] == '' || $_POST['email'] == '' || $_POST['role'] == '')
			die('wrong');
			
		$name = $_POST['name'];
		$dni = $_POST['dni'];
		$username = $_POST['username'];
		$password1 = md5($_POST['password1']);
		$password2 = md5($_POST['password2']);
		$email = $_POST['email'];
		$role = $_POST['role'];
		$date = date("m/d/Y");
		$id_user = $id_user_active;
		
		if($role != 1 && $role != 2 && $role != 3 && $role != 4)
			die('wrong');
		
		if($password1 != $password2)
			die('2');
		
		$rgpx = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/"; 
		if(preg_match($rgpx, $email) === false)
			die('3');
		
		if(strlen($password1) < 6)
			die('4');
		
		// Check if user exists
		if($_users->user_exists($username) == true)
			die('5');
		
		//Chequear si la cedula existe
		if($_users->dni_exists($dni) == true)
			die('6');
		
		// General Supervisor can only create Supervisors and Employees
		if($role_ == 2) {
			if($role != 3 && $role != 4)
				die('wrong');
		}
		
		// Supervisor can only create employees
		if($role_ == 3) {
			if($role != 4)
				die('wrong');
		}
		
		if($_users->new_user($name, $dni, $username, $password1, $email, $role, $id_user, date("m/d/Y")) == true)
			die('1');
		die('wrong');
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<?php require 'inc/head.php'; ?>
</head>
<body>
	<div id="main-wrapper">
		<?php require 'inc/header.php'; ?>
		
		<div class="wrapper-pad">
			<h2>Nuevo Usuario</h2>
			<div class="center">
				<div class="new-item form">
					<form method="post" action="" name="new-user">
						Nombre:<br />
						<div class="ni-cont">
							<input type="text" name="nuser-name" class="ni" />
						</div>
						Nombre de usuario:<br />
						<div class="ni-cont">
							<input type="text" name="nuser-user" class="ni" />
						</div>
						Cédula (sólo números):<br />
						<div class="ni-cont">
							<input onkeypress="return valida(event,this);" type="text" name="nuser-dni" class="ni" />
						</div>
						Clave:<br />
						<div class="ni-cont">
							<input type="password" name="nuser-pass" class="ni" />
						</div>
						Repetir clave:<br />
						<div class="ni-cont">
							<input type="password" name="nuser-passr" class="ni" />
						</div>
						Correo:<br />
						<div class="ni-cont">
							<input type="text" name="nuser-email" class="ni" />
						</div>
						Rol:<br />
						<div class="select-holder">
							<i class="fa fa-caret-down"></i>
							<select name="nuser-role">
								<?php
								if($role == 1){
									echo '<option value="1">Administrador</option>';
									echo '<option value="2">Supervidor General</option>';
								}
								if($role == 1 || $role == 2)
									echo '<option value="3">Supervisor</option>';
								if($role == 1 || $role == 2 || $role == 3)
									echo '<option value="4">Empleados</option>';
								?>
							</select>
						</div>
						<input type="submit" name="nuser-submit" class="ni btn blue" value="Crear nuevo usuario" />
					</form>
				</div>
			</div>
		</div>
		
		<div class="clear" style="margin-bottom:40px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>
	</div>

   <!--VALIDAR SOLO NUMEROS EN EL INPUT-->
  <script type="text/javascript">
      function valida(e){
          tecla = (document.all) ? e.keyCode : e.which;

          //Tecla de retroceso para borrar, siempre la permite
          if (tecla==8){
              return true;
          }
              
          // Patron de entrada, en este caso solo acepta numeros
          patron =/[0-9]/;
          tecla_final = String.fromCharCode(tecla);
          return patron.test(tecla_final);
      }
  </script>

</body>
</html>