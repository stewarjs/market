<?php
require_once('database.php');

if(isset($_POST['get'])) {
	get_houses();
} else if(isset($_POST['addHouse'])) {
	add_house($_POST['house']);
} else if(isset($_POST['addBird'])) {
	add_bird($_POST['breed'], $_POST['birth'], $_POST['house']);
} else if(isset($_POST['deleteHouse'])) {
	delete_house($_POST['house']);
} else if(isset($_POST['addEggs'])) {
	add_eggs($_POST['house'], $_POST['amount']);
}

function get_houses($id = null) {
	$db = new database();
	$db->connect();
	if($id == null) {
		return $db->runSQL('SELECT * from poultry_houses;');
	} else {
		return $db->runSQL('SELECT * from poultry_houses WHERE id=' . $id . ';');
	}
	
}

function get_egg_timeline ($house) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('SELECT sum(eggs_laid) as total, date FROM egg_production WHERE date > NOW() - INTERVAL 14 DAY AND house = '. $house . ' GROUP BY date ORDER BY date ASC;');
	
	$list = [];
	foreach($result as $row) {
		array_push($list, $row);
	}
	return $list;
}

function add_eggs($house, $amount) {
	$db = new database();
	$db->connect();
	/*$ = $db->runSQL('SELECT * from poultry WHERE house=' . $house . ';');
	$birds = $birds->rowCount();
	
	$amount = round($amount / $birds, 2);*/
	//return $db->runSQL('UPDATE egg_production SET eggs_laid = eggs_laid + ' . $amount . ' WHERE house=' . $house . ';');
	return $db->runSQL('INSERT INTO egg_production(eggs_laid, house, date) VALUES (' . $amount . ', ' . $house . ', "' . date('Y-m-d') . '");');
}

function total_eggs($house) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('SELECT sum(eggs_laid) as total from egg_production WHERE house=' . $house . ';');
	return $result->fetchObject()->total;
}

function total_cost($house) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('SELECT sum(cost) as total from poultry WHERE house=' . $house . ';');
	return $result->fetchObject()->total;
}

function add_house($name) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('INSERT INTO poultry_houses(name) VALUES ("' . $name . '");');
}

function get_birds($id = null) {
	$db = new database();
	$db->connect();
	return $db->runSQL('SELECT * from poultry WHERE house=' . $id . ';');
}

function add_bird($breed, $date, $house) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('INSERT INTO poultry(breed, birth, house) VALUES ("' . $breed . '", "' . $date . '", ' . $house . ');');
}

function delete_bird($id) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('DELETE FROM poultry WHERE id = ' . $id . ';');
}

function delete_house($id) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('DELETE FROM poultry_houses WHERE id = ' . $id . ';');
	print_r( $result );
}
?>