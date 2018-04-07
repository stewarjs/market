<?php
require_once('database.php');

if(isset($_POST['get'])) {
	get_beds();
} else if(isset($_POST['addBed'])) {
	add_bed($_POST['bed']);
} else if(isset($_POST['addPlant'])) {
	add_plant($_POST['name'], $_POST['variety'], $_POST['number'], $_POST['plant_date'], $_POST['days_to_maturity'], $_POST['bed']);
} else if(isset($_POST['deleteBed'])) {
	delete_bed($_POST['bed']);
}

function get_beds($id = null) {
	$db = new database();
	$db->connect();
	if($id == null) {
		return $db->runSQL('SELECT * from garden;');
	} else {
		return $db->runSQL('SELECT * from garden WHERE id=' . $id . ';');
	}
	
}

function number_of_plants($id) {
	$db = new database();
	$db->connect();
	return $db->runSQL('SELECT sum(number_of_plantings) as total from plants WHERE garden_bed=' . $id . ';');
}

function add_bed($name) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('INSERT INTO garden(name) VALUES ("' . $name . '");');
}

function get_plants($id = null) {
	$db = new database();
	$db->connect();
	return $db->runSQL('SELECT * from plants WHERE garden_bed=' . $id . ';');
}

function add_plant($name, $variety, $number_of_plantings, $plant_date, $days_to_maturity, $garden_bed) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('INSERT INTO plants(name, variety, number_of_plantings, plant_date, days_to_maturity, garden_bed) VALUES ("' . $name . '", "' . $variety . '", ' . $number_of_plantings . ', "' . $plant_date . '", ' . $days_to_maturity . ', ' . $garden_bed . ');');
}

function delete_bed($id) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('DELETE FROM garden WHERE id = ' . $id . ';');
	//print_r( $result );
}
?>