<?php
require_once('database.php');

if(isset($_POST['get'])) {
	get();
} else if(isset($_POST['add'])) {
	add($_POST['date'], $_POST['amount']);
}

function get($sort = 'desc') {
	$db = new database();
	$db->connect();
	if($sort == 'desc') {
		$result = $db->runSQL('SELECT * FROM rain WHERE date > NOW() - INTERVAL 30 DAY ORDER BY date DESC;');
	}else{
		$result = $db->runSQL('SELECT * FROM rain WHERE date > NOW() - INTERVAL 30 DAY ORDER BY date ASC;');
	}
	
	$list = [];
	foreach($result as $row) {
		array_push($list, $row);
	}
	return $list;
}

function weekly_rain() {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('SELECT sum(amount) as total FROM rain WHERE date > NOW() - INTERVAL 7 DAY;');
	return $result;
}

function add($date, $amount) {
	$db = new database();
	$db->connect();
	$result = $db->runSQL('INSERT INTO rain(date, amount) VALUES ("' . $date . '", ' . $amount . ') ON DUPLICATE KEY UPDATE amount = ' . $amount . ';');
	return $result;
}
?>