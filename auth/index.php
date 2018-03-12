<?php
set_time_limit(30);
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
ini_set('log_errors',0);

require_once(__DIR__.'\..\core\layout\engine.php');
require_once(__DIR__.'\..\core\api\ldap.php');

$page = new page();

$page->title('Login | TCB Trainer Dashboard');

$page->header();

$redirect = (isset($_GET['page']) ? $_GET['page'] : '/apps/Survey/index.php');

// Error Handling
$errorText = null;
$error = false;

// What AD group should have access?
$memberof = 'AFCG - Video Archive GESD - PCB';

if(!empty($_POST)) {

		$access_check = isMember($_POST['username'], $_POST['password'], $memberof);

		if($access_check === true) {
			// Set Session Data
			$_SESSION['active'] = 'true';
			// Redirect back to originating page
			header('Location: '.$redirect);
		}else{
			header('Location: '.$_SERVER['PHP_SELF'].'?page='.$redirect.'&login&error='.$access_check);
		}
	
}

if(isset($_GET['login']) && $_GET['login'] == 'false') {
		unset($_SESSION['active']);
		session_destroy();
}

if(isset($_GET['error'])) {
	
	// List of custom errors defined in LDAP core
	// All numerical errors are results from interacting with LDAP Server
	$error_list = array(
		'connection' 	=> 'Connection Error',
		'membership' 	=> 'Not Authorized',
		'login'			=> 'Invalid Credentials',
		'file'			=> 'File Not Found'
	);

	if(empty($error_list[$_GET['error']])) {
		// Display text of LDAP error
		$errorText = ldap_err2str($_GET['error']);
	}else{
		// Display custom error text
		$errorText = $error_list[$_GET['error']];
	}
	
	$error = true;
	
}

?>


<section>
      	
	<div class="align--center"> 
    <form method="post" action="<?php print($_SERVER['PHP_SELF']); ?>" <?php ($error === true ? print('aria-describedby="login__error"') : ''); ?> class="card card--sign-in align--left">
        <h1 class="heading--medium align--center">Sign In</h1>
        <?php if($error === true): ?>
        <div class="align--center">
			<div id="login__error" class="toast toast--error align--left">
				<svg focusable="false" class="icon" role="presentation"><use xlink:href="#framework_svg_cross" /></svg>
				<span role="alert"><?php echo $errorText; ?></span>
			</div>
		</div>
        <?php endif; ?>
        <p>To access this file you must log in with your Active Directory/Citrix credentials. The User ID and Password fields are required and marked with asterisks.</p>
        <label for="username" class="username">
        <svg class="icon" viewBox="0 0 20 20" role="presentation" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.725,2.146c-1.016,0.756-1.289,1.953-1.239,2.59C6.55,5.515,6.708,6.529,6.708,6.529  s-0.313,0.17-0.313,0.854C6.504,9.1,7.078,8.359,7.196,9.112c0.284,1.814,0.933,1.491,0.933,2.481c0,1.649-0.68,2.42-2.803,3.334  C3.196,15.845,1,17,1,19v1h18v-1c0-2-2.197-3.155-4.328-4.072c-2.123-0.914-2.801-1.684-2.801-3.334c0-0.99,0.647-0.667,0.932-2.481  c0.119-0.753,0.692-0.012,0.803-1.729c0-0.684-0.314-0.854-0.314-0.854s0.158-1.014,0.221-1.793c0.065-0.817-0.398-2.561-2.3-3.096  c-0.333-0.34-0.558-0.881,0.466-1.424C9.439,0.112,8.918,1.284,7.725,2.146z"/>
        </svg>
        User ID <abbr title="This field requires input" class="label__required-field">*</abbr></label>
        <input id="username" required name="username" autocomplete="off" type="text" />
        
        <label for="password" class="password">
        <svg class="icon" viewBox="0 0 20 20" role="presentation" xmlns="http://www.w3.org/2000/svg">
        <path d="M15.8,8H14V5.6C14,2.703,12.665,1,10,1C7.334,1,6,2.703,6,5.6V8H4C3.447,8,3,8.646,3,9.199V17  c0,0.549,0.428,1.139,0.951,1.307l1.197,0.387C5.672,18.861,6.55,19,7.1,19h5.8c0.549,0,1.428-0.139,1.951-0.307l1.196-0.387  C16.571,18.139,17,17.549,17,17V9.199C17,8.646,16.352,8,15.8,8z M12,8H8V5.199C8,3.754,8.797,3,10,3s2,0.754,2,2.199V8z"/>
        </svg>
        Password <abbr title="This field requires input" class="label__required-field">*</abbr></label>
        <input id="password" required name="password" type="password" />
        <input id="login" name="login" type="hidden" value="true" />
        <button type="submit" class="button button--blue button--full-width">Sign In</button>
    </form>
</div>
			
</section>
    
<?php $page->footer(); ?>
    
