<?php

class database {
    
    public function connect() {
        
        // define connection variables
        $server = 'localhost';
        $db = 'ashley_market';
        $user = 'ashley_service';
        $pass = 'root';
		$charset = 'utf8';
		
		$dsn = "mysql:host=$server;dbname=$db;charset=$charset";
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
        
        // connect to database
        //$conn = new mysqli($server, $username, $password, $db);
		$pdo = new PDO($dsn, $user, $pass, $opt);

        // Check connection
        /*if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }*/
        //return $conn;
		return $pdo;
    }
	
	public function runSQL ($sql) {
        $db = $this->connect();
        
        
        if (!$statement = $db->prepare($sql)) {
            return 'Error preparing MySQL query: ' . $db->errorCode();
        }
        
        if (!$statement->execute()) {
            return 'Error executing MySQL query: ' . $db->errorCode();
        }
        
        /*$result_object = new stdClass();
        $result_object->id = $statement->insert_id;
        
        $result_object->result = $statement->get_result();*/

        //$db->close();
        
        return $statement;
    }
    
}

?>