<?php

class database {
    
    public function connect() {
        
        // define connection variables
        $server = 'localhost';
        $db = 'market';
        $username = 'root';
        $password = '';
        
        // connect to database
        $conn = new mysqli($server, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
	
	protected function dynamicSQL ($metrics, $dimension, $filter) {
		
		$sql = 'SELECT ';
		
		// Get our metrics
		//$count = 1;
		foreach($metrics as $metric) {
			if($metric === 'count') {
				$sql .= 'count(reports_table.report_id) as count, ';
			}else if ($metric !== 0){
				$sql .= 'reports_table.'.$metric.', ';
			}
		};
		
		if($dimension == 'hour') {
			$sql .= 'DATE_FORMAT(hunt_time, "%H%i") as hour FROM reports_table ';
		}else{
			$sql .= $dimension.' FROM reports_table ';
		}
		// Always include the species table
		$sql .= 'LEFT JOIN (species_table) ON (reports_table.species_id = species_table.species_id) ';
		
		// Are filtering the data?
		$sql .= $filter;
		
		// Group our data
		$sql .= 'GROUP BY '.$dimension;
		
		return $sql;
		
		
	}
    
    public function runSQL ($sql) {
        $db = $this->connect();
        
        
        if (!$statement = $db->prepare($sql)) {
            return 'Error preparing MySQL query: ' . $db->error;
        }
        
        if (!$statement->execute()) {
            return 'Error executing MySQL query: ' . $db->error;
        }
        
        $result_object = new stdClass();
        $result_object->id = $statement->insert_id;
        
        $result_object->result = $statement->get_result();

        $db->close();
        
        return $result_object;
    }
    
}

?>