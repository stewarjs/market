<?php
require(__DIR__.'/../core/api/database.php');

class authentication extends database {
	
	public $errors = null;
	
	public function logout() {
		
		session_unset();     // unset $_SESSION variable for the run-time 
		session_destroy();   // destroy session data in storage
		
	}
	
	public function error_to_string($error_no) {
		$error_table = array(
						1 => 'Username was left blank.',
						2 => 'Password was left blank.',
						3 => 'Too many failed login attempts.',
						4 => 'Incorrect login credentials.'
						);
		return $error_table[$error_no];
	}
	
	private function sanitize($string) {
		$search = array(
			'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		);
		$output = preg_replace($search, '', $string);
  		return addslashes($output);
	}
	
	public function login($user, $pass) {
		
		// check login form contents
        if (empty($user)) {
            $this->errors = 1; // Username left blank
        } elseif (empty($pass)) {
            $this->errors = 2; // Password left blank
		//} elseif ($_SESSION['Login_Attempts'] > 2) {
		//	$this->errors = 3; // Too many attempts
		} elseif (!empty($user) && !empty($pass)) {
			
			// continue with login
			$sql = 'SELECT * FROM users WHERE user = "' . $this->sanitize($user) . '";';
			$user_table = $this->runSQL($sql);
			
			if($user_table->rowCount() == 0) {
				$this->errors = 4; // Incorrect login credentials
			}else{
				$user_table = $user_table->fetchObject();
				//return $user_table;
				if(password_verify($pass, $user_table->pass)) {
					$_SESSION['user_name'] = $user;
					$_SESSION['user_login_status'] = 1;
				}else{
					$this->errors = 4; // Incorrect login credentials
				}
			}
		}
		
		if(isset($this->errors)) {
			//$_SESSION['Login_Attempts']++;
			return $this->errors;
		}else{
			return true;
		}
		
	}
	
	public function is_logged_in() {
		if (isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
	}
	
	
}

?>