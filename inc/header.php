<?php
$headrole = $_session->get_user_role();
if($headrole == 1)
	$as = 'Administrador';
elseif($headrole == 2)
	$as = 'Supervisor General';
elseif($headrole == 3)
	$as = 'Supervisor';
elseif($headrole == 4)
	$as = 'Empleado';
?>
<!--MENU PRINCIPAL-->
<div id="header">
			<div class="left">
				<a href="home.php"><h2>INVENTARIO</h2></a>
				<div style="font-size:12px; font-style:italic;color:#bbb;"><?php echo $as; ?></div>
			</div>
			<div class="right">
				<?php
				if($headrole == 1 || $headrole == 2 || $headrole == 3)
					echo '<a href="users.php" title="Usuarios">Usuarios</a>|';
				?>
				<a href="settings.php" title="Configuración">Configuración</a>|
				<a href="logout.php" title="Salir">Salir</a>
			</div>
			<div class="clear"></div>
		</div>
		
		<input type="checkbox" class="toggle" id="opmenu" style="display:none"/>
		<label for="opmenu" id="open-menu"><i class="fa fa-align-justify">=</i> Menú</label>
		<div id="menu">
			<ul id="menuli">
				<?php
				// El inicio es solo para admin y supervisor general
				if($headrole == 1 || $headrole == 2) {
				?>
					<li<?php if($_page == 1) { ?> class="active"<?php } ?>><a href="home.php" title="Inicio"><i class="fa fa-home"></i> Inicio</a></li>
				<?php
				}
				?>
				
				<?php
				// Agrenar nuevo producto solo para Admin, Supervidor General y Supervidor
				if($headrole == 1 || $headrole == 2 || $headrole == 3 || $headrole == 4){
				?>
					<li<?php if($_page == 2) { ?> class="active"<?php } ?>><a href="new-item.php" title="New Item"><i class="fa fa-plus"></i> Nuevo Producto</a></li>
				<?php
				}
				?>
				
				<li<?php if($_page == 3) { ?> class="active"<?php } ?>><a href="items.php" title="Items"><i class="fa fa-list-ul"></i> Productos</a></li>
				<li<?php if($_page == 4) { ?> class="active"<?php } ?>><a href="check-in.php" title="Check-In Item"><i class="fa fa-arrow-down"></i> Sumar producto</a></li>
				<li<?php if($_page == 5) { ?> class="active"<?php } ?>><a href="check-out.php" title="Check-Out Item"><i class="fa fa-arrow-up"></i> Restar producto</a></li>
				
				<?php
				/*
				// Agrenar nuevo producto solo para Admin, Supervidor General y Supervidor
				if($headrole == 1 || $headrole == 2 || $headrole == 3){
				?>
					<li<?php if($_page == 6) { ?> class="active"<?php } ?>><a href="logs.php" title="Logs"><i class="fa fa-file-text-o"></i> Logs</a></li>
				<?php
				}
				*/?>
				<li<?php if($_page == 7) { ?> class="active"<?php } ?>><a href="categories.php" title="Categories"><i class="fa fa-folder"></i> Categorías</a></li>
			</ul>
		</div>