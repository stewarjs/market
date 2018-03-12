<?php

require_once('../core/layout/engine.php');

$page = new page();

$page->title('Poultry');
$page->header();


?>

<section>
<div class="page__header">     	
	<h2 class="heading--small">Poultry</h2>
	<!-- Year Selection -->
</div>
<div class="inline-grid">
<div class="card garden">
	<svg class="garden__icon" role="presentation"><use xlink:href="#framework_svg_barn" /></svg>
	<h3 class="heading--label garden__heading">Laying House</h3>
</div>

<!-- Chicken Card -->
<!--
<div class="card garden">
	<svg class="garden__icon" role="presentation"><use xlink:href="#framework_svg_chicken" /></svg>
	<h3 class="heading--label garden__heading">Amercauna</h3>
	<span class="garden__date">24 weeks</span>
</div>
-->	
<button class="card garden garden--add">
	<svg class="garden__icon" viewBox="0 0 20 20">
		<path d="M10,1.6c-4.639,0-8.4,3.761-8.4,8.4s3.761,8.4,8.4,8.4s8.4-3.761,8.4-8.4S14.639,1.6,10,1.6z M15,11h-4v4H9
	v-4H5V9h4V5h2v4h4V11z"/>
</svg>
	<h3 class="heading--label garden__heading">Add New House</h3>
</button>
	
</div>
</section>   
<?php
	$page->footer();
?>