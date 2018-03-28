<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php print($page->title . ' | ' . $page->app_name); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#9b9b9b">
	<link rel="manifest" href="/manifest.json">
	<meta name="robots" content="noindex">
    <link href="/core/framework/css/nfc.framework.css" type="text/css" rel="stylesheet">
	<?php $page->get_styles(); ?>
	<link href="/core/framework/css/theme.css" type="text/css" rel="stylesheet">
</head>
<body class="collapse-navigation">
	<a href="#nav" class="skip-content" id="skipheader">Skip to Navigation</a>
    <a href="#main" class="skip-content" id="skipnav">Skip to Main Content</a>
		<header class="header">
    	<h1 class="header__logo align--left">
			<svg class="logo__icon" viewBox="0 0 20 20" role="presentation">
				<path d="M19.025,3.587c-4.356,2.556-4.044,7.806-7.096,10.175c-2.297,1.783-5.538,0.88-7.412,0.113
	c0,0-1.27,1.603-2.181,3.74c-0.305,0.717-1.644-0.073-1.409-0.68C3.905,9.25,14.037,5.416,14.037,5.416S6.888,5.113,2.11,11.356
	C1.982,9.93,1.77,6.072,5.47,3.706C10.486,0.495,20.042,2.991,19.025,3.587z"/>
			</svg>
			<span class="logo__text"><?php print($page->app_name); ?></span>
       </h1>
        
           <?php $page->menu('topmenu'); ?>

        </header>
        <?php 
			if(dirname($_SERVER['PHP_SELF']) != '\\'){
				$page->menu('sidemenu');
				echo '<main class="layout--two-column" id="main">';
			}else{
				echo '<main id="main">';
			}
		?>
        