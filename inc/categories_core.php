<?php

class Categories {
	private $self_file = 'categories_core.php';
	private $mysqli = false;
	private $session = false;
	
	public function __construct($m) { $this->mysqli = $m; }
	
	//Datos de sesion
	public function set_session_obj($obj) { $this->session = $obj; }
	//Cargar lista de categorias
	public function get_cats($page, $items_per_page) {
		$page = stripslashes($page);
		$items_per_page = stripslashes($items_per_page);
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($items_per_page * ($page-1));
		$y = $items_per_page;
		$q = $this->query("SELECT * FROM invento_categories ORDER BY id DESC LIMIT $x,$y", 'get_cats()');
		return $q;
	}
	//buscar categoria especifica
	public function search($string, $page, $items_per_page) {
		$s = "%$string%";
		
		if($page == 0 || $page == 1)
			$x = 0;
		else
			$x = ($items_per_page * ($page-1));
		$y = $items_per_page;

		$prepared = $this->prepare("SELECT * FROM invento_categories WHERE id LIKE ? OR name LIKE ? OR place LIKE ? OR descrp LIKE ? OR date_added LIKE ? ORDER BY id DESC LIMIT $x,$y", 'search()');
		$this->bind_param($prepared->bind_param('sssss', $s, $s, $s, $s, $s), 'search()');
		$this->execute($prepared, 'search()');
		
		$result = $prepared->get_result();
		return $result;
	}
	//contar categorias
	public function count_cats() {
		$res = $this->query("SELECT COUNT(*) as c FROM invento_categories", 'count_cats()');
		$obj = $res->fetch_object();
		return $obj->c;
	}
	//Contar categorias encontradas en la busqueda
	public function count_cats_search($string) {
		$string = "%$string%";
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM invento_categories WHERE id LIKE ? OR name LIKE ? OR place LIKE ? OR descrp LIKE ? OR date_added LIKE ?", 'count_cats_search()');
		$this->bind_param($prepared->bind_param('sssss', $string, $string, $string, $string, $string), 'count_cats_search()');
		$this->execute($prepared, 'count_cats_search()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		
		return $row->c;
	}
	//Borrar categoria
	public function delete_cat($catid) {
		$prepared = $this->prepare("DELETE FROM invento_categories WHERE id=?", 'delete_cat()');
		$this->bind_param($prepared->bind_param('i', $catid), 'delete_cat()');
		$this->execute($prepared, 'delete_cat()');
		return true;
	}
	//Borrar productos si la categoria se borra
	public function delete_cat_item($catid) {
		$prepared = $this->prepare("DELETE FROM invento_items WHERE category=?", 'delete_cat_item()');
		$this->bind_param($prepared->bind_param('i', $catid), 'delete_cat_item()');
		$this->execute($prepared, 'delete_cat_item()');
		return true;
	}
	//categorias decendentes
	public function get_cats_dropdown() {
		$q = $this->query("SELECT id,name FROM invento_categories", 'get_cats_dropdown()');
		return $q;
	}
	//Nueva categoria
	public function new_cat($name, $place, $desc) {
		$date = date('Y-m-d');
		$prepared = $this->prepare("INSERT INTO invento_categories(name,place,descrp,date_added) VALUES(?,?,?,?)", 'new_cat()');
		$this->bind_param($prepared->bind_param('ssss', $name, $place, $desc, $date), 'new_cat()');
		$this->execute($prepared, 'new_cat()');
		return true;
	}
	//Actualizar categoria
	public function edit_cat($catid, $name, $place, $desc) {
		$prepared = $this->prepare("UPDATE invento_categories SET name=?, place=?, descrp=? WHERE id=?", 'edit_cat()');
		$this->bind_param($prepared->bind_param('sssi', $name, $place, $desc, $catid), 'edit_cat()');
		$this->execute($prepared, 'edit_cat()');
		return true;
	}
	//Buscar categoria especifica
	public function get_cat($catid) {
		$res = $this->query("SELECT * FROM invento_categories WHERE id=$catid", 'get_cat()');
		$obj = $res->fetch_object();
		return $obj;
	}
//Verificar categoria si existe
	public function cat_exists($name) {
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM invento_categories WHERE name=?", 'cat_exists()');
		$this->bind_param($prepared->bind_param('s', $name), 'cat_exists()');
		$this->execute($prepared, 'cat_exists()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		if($row->c >= 1)
			return true;
		return false;
	}
//Verificar categoria si existe al editar
	public function cat_exists_edit($name,$id) {
		$prepared = $this->prepare("SELECT COUNT(*) as c FROM invento_categories WHERE name=? AND id != '".$id."'", 'cat_exists_edit()');
		$this->bind_param($prepared->bind_param('s', $name), 'cat_exists_edit()');
		$this->execute($prepared, 'cat_exists_edit()');
		
		$result = $prepared->get_result();
		$row = $result->fetch_object();
		if($row->c >= 1)
			return true;
		return false;
	}
	
	
	/***
	  *  Private functions
	  *
	***/
	private function prepare($query, $func) {
		$prepared = $this->mysqli->prepare($query);
		if(!$prepared)
			die("Couldn't prepare query. inc/{$this->self_file} - $func");
		return $prepared;
	}
	private function bind_param($param, $func) {
		if(!$param)
			die("Couldn't bind parameters. inc/{$this->self_file} - $func");
		return $param;
	}
	private function execute($prepared, $func) {
		$exec = $prepared->execute();
		if(!$exec)
			die("Couldn't execute query. inc/{$this->self_file} - $func");
		return $exec;
	}
	private function query($query, $func) {
		$q = $this->mysqli->query($query);
		if(!$q)
			die("Couldn't run query. inc/{$this->self_file} - $func");
		return $q;
	}
	public function __destruct() {
		if(is_resource($this->mysqli) && get_resource_type($this->mysqli) == 'mysql link')
			$this->mysqli->close();
	}
}

$_cats = new Categories($mysqli);