<?php
require_once('database.php');

if(isset($_POST['getProducts']) && isset($_POST['type'])) {
	get_products($_POST['type']);
} else if(isset($_POST['addHouse'])) {
	add_house($_POST['house']);
} else if(isset($_POST['addBird'])) {
	add_bird($_POST['breed'], $_POST['birth'], $_POST['house']);
} else if(isset($_POST['deleteHouse'])) {
	delete_house($_POST['house']);
} else if(isset($_POST['addEggs'])) {
	add_eggs($_POST['house'], $_POST['amount']);
}

function get_products($type = null) {
	$db = new database();
	$db->connect();
	if($type == null) {
		return $db->runSQL('SELECT * from products;');
	} else {
		$sql = 'SELECT * FROM `products` WHERE ';
		$count = 0;
		foreach($type as $condition) {
			$sql .= '(type = "'. $condition .'")';
			$count++;
			if($count != sizeof($type)) {
				$sql .= ' OR ';
			}
		}
		$sql .= ';';
		return $db->runSQL($sql);
	}
	
}

function get_product_types($types) {
	
}

function get_metric_types($types) {
	
}

function add_product($name) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('INSERT INTO poultry_houses(name) VALUES ("' . $name . '");');
}

function delete_product($id) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('DELETE FROM poultry WHERE id = ' . $id . ';');
}
?>