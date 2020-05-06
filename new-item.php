<?php
require 'config.php';
require 'inc/session.php';
require 'inc/items_core.php';
require 'inc/categories_core.php';
if($_session->isLogged() == false)
	header('Location: index.php');

$_page = 2;

$role = $_session->get_user_role();

if(isset($_POST['act'])) {
	if($_POST['act'] == '1') {
		if(!isset($_POST['name']) || !isset($_POST['descrp']) || !isset($_POST['cat']) || !isset($_POST['qty']) || !isset($_POST['code']))
			die('wrong');
		if($_POST['name'] == '' || $_POST['cat'] == '' || $_POST['code'] == '')
			die('wrong');
		if($_items->item_exists($_POST['code']) == true)
			die('code');
		
		$name = $_POST['name'];
		$descrp = $_POST['descrp'];
		$cat = $_POST['cat'];
		$qty = $_POST['qty'];
		$code = $_POST['code'];
		$price = 0.00;
		
		// Fix price
		$price = (string)$price;
		if(strpos($price, '.') === false) {
			$price = $price.'.00';
		}else{
			$pos = strpos($price, '.');
			if($price{$pos+1} == null)
				$price = $price.'00';
			elseif(!isset($price{$pos+2}))
				$price = $price.'0';
			else
				$price = substr($price,0,$pos+3);
		}
		
		if(substr_count($price, '.') > 1)
			die('wrong');
		
		if($_items->new_item($name, $code, $descrp, $cat, $qty, $price) == false)
			die('wrong');
		die('1');
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
			<h2>Nuevo Producto</h2>
			<div class="center">
				<div class="new-item form">
					<form method="post" action="" name="new-item">
						Nombre del producto:<br />
						<div class="ni-cont">
							<input type="text" name="item-name" class="ni" />
						</div>
						Código único (sólo números):<br />
						<div class="ni-cont">
							<input onkeypress="return valida(event,this);" type="text" name="item-code" class="ni" />
						</div>
						<span class="item-desc-left">Descripción (400 caracteres):</span><br />
						<div class="ni-cont">
							<textarea name="item-descrp" class="ni"></textarea>
						</div>
						Categoría:<br />
						<div class="select-holder">
							<i class="fa fa-caret-down"></i>
							<?php
							if($_cats->count_cats() == 0)
								echo '<select name="item-category" disabled><option value="no">Necesita crear una nueva categoría primero</option></select>';
							else{
								echo '<select name="item-category">';
								$cats = $_cats->get_cats_dropdown();
								while($catt = $cats->fetch_object()) {
									echo "<option value=\"{$catt->id}\">{$catt->name}</option>";
								}
								echo '</select>';
							}
							?>
						</div>
						Cantidad:<br />
						<input type="text" name="item-qty" class="ni-small" placeholder="0" />
						<!--Precio del producto:<br />
						<input type="text" name="item-price" class="ni-small" placeholder="0.00" />-->
						<input type="submit" name="item-submit" class="ni btn blue" value="Crear" />
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