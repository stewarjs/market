<?php

require_once('core/layout/engine.php');

$page = new page();

$page->title('Home');
$page->header();

if(isset($_POST['username']) && isset($_POST['password'])) {
	$status = $page->login($_POST['username'], $_POST['password']);
	
	if($status !== true) {
		header('Location: index.php?error='. $status);
	}else{
		header('Location: /garden/');
	}
}

if(isset($_GET['logout'])) {
	$page->logout();
}

?>

<section>
<div class="card card--sign-in align--left">
            
	<h3 class="heading--medium align--center">Sign In</h3>
		
		<?php
			if(isset($_GET['error'])) {
				$error = $page->error_to_string($_GET['error']);
				$error = '<div class="align--center">'.
						'<div id="login-error" class="toast toast--error align--center">'.
        				'<svg class="icon" role="presentation"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#framework_svg_cross"></use></svg>'.
        				'<span role="alert">ERROR: '. $error .'</span></div></div>';
			}
		?>
		<form method="post" action="index.php"<?php (isset($error) ? print(' aria-describedby="login-error"') : false) ?>>
		<?php (isset($error) ? print($error) : false) ?>
		<p>Please sign in with your credentials below. The User ID and Password fields are required and marked with an asteriks.</p>

			<label for="username" class="username"><svg focusable="false" class="icon" role="presentation"><use xlink:href="#framework_svg_SingleUser" /></svg>User Name <abbr title="This field requires input" class="label__required-field">*</abbr></label>
			<input type="text" id="username" name="username" required />

			<label for="password" class="password"><svg class="icon" role="presentation"><use xlink:href="#framework_svg_Lock" /></svg>Password <abbr title="This field requires input" class="label__required-field">*</abbr></label>
			<input type="password" id="password" name="password" required />

			<button type="submit" class="button button--blue button--full-width">Sign In</button>

		</form>

</div>
</section>   
<?php
	$page->footer();
?>