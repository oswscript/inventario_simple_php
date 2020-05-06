<?php
require 'config.php';
require 'inc/session.php';
require 'inc/categories_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 8;
$role = $_session->get_user_role();
if($role != 1 && $role != 2 && $role != 3)
	header('Location: categories.php');

if(isset($_POST['act'])) {
	if($_POST['act'] == '1') {
		if(!isset($_POST['name']) || $_POST['name'] == '')
			die('wrong');
		if($_cats->cat_exists($_POST['name']) == true)
			die('1');
		if($_cats->new_cat($_POST['name'], $_POST['place'], $_POST['desc']) == true)
			die('2');
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
			<h2>Nueva Categoría</h2>
			<div class="center">
				<div class="new-cat form">
					<form method="post" action="" name="new-cat">
						Nombre:<br />
						<div class="ni-cont">
							<input type="text" name="ncat-name" class="ni" />
						</div>
						<!--Category Place:<br />-->
						<div class="ni-cont">
							<input type="hidden" name="ncat-place" class="ni" />
						</div>
						<span class="ncat-desc-left">Descripción (400 caracteres):</span><br />
						<div class="ni-cont">
							<textarea name="ncat-descrp" class="ni" maxlength="400"></textarea>
						</div>
						<input type="submit" name="nuser-submit" class="ni btn blue" value="Crear nueva categoría" />
					</form>
				</div>
			</div>
		</div>
		
		<div class="clear" style="margin-bottom:40px;"></div>
		<div class="border" style="margin-bottom:30px;"></div>
	</div>
</body>
</html>