<?php

class page {
	
	private $template_directory = __DIR__.'/templates/';
	private $require_login = false;
	public $app_name = 'Market Garden';
	public $title = '';	
	private $scripts = [];
	private $styles = [];
	
	function __construct() {
		/*session_start();
		if($this->require_login === true && !isset($_SESSION['active']) && !isset($_REQUEST['login'])) {
			
			header('Location: /apps/management/auth/?page='.$_SERVER['PHP_SELF'].'&login');
			
		}*/
		
	}

	public function title($text) {
		$this->title = $text;
	}	
	
	public function add_scripts($array) {
		foreach($array as $path) {
			array_push($this->scripts, $path);
		}
	}
	
	public function get_scripts() {
		if(!empty($this->scripts)) {
			foreach($this->scripts as $script) {
				print('<script src="' . $script . '"></script>' . "\n\r");
			}
		}
	}
	
	public function add_styles($array) {
		foreach($array as $path) {
			array_push($this->styles, $path);
		}
	}
	
	public function get_styles() {
		if(!empty($this->styles)) {
			foreach($this->styles as $style) {
				print('<link href="' . $style . '" type="text/css" rel="stylesheet">' . "\n\r");
			}
		}
	}


	public function header($header_name = null) {
		global $page;
		
		if(isset($header_name)) {
			// Specify header
			if(is_file($this->template_directory . $header_name . '.php')) {
				require($this->template_directory . $header_name . '.php');
			}
		}else{
			// Render default header
			require($this->template_directory . 'header.php');
		}
		
	}
	
	public function menu($menu_name) {
		if(isset($menu_name)) {
			// Specify header
			if(is_file($this->template_directory . $menu_name . '.php')) {
				require($this->template_directory . $menu_name . '.php');
			}else{
				die('Error: Menu file not found.');
			}
		}else{
			die('Error: Path to menu not specified.');
		}
		
	}


	public function footer($footer_name = null) {
		global $page;
		if(isset($footer_name)) {
			// Specify header
			if(is_file($this->template_directory . $footer_name . '.php')) {
				require($this->template_directory . $footer_name . '.php');
			}
		}else{
			// Render default header
			require($this->template_directory . 'footer.php');
		}
		
	}




}

?>