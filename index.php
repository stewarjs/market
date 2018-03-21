<?php

require_once('core/layout/engine.php');

$page = new page();

$page->title('Home');
$page->header();


?>

<section>
<div class="page__header">     	
	<h2 class="heading--small">Market Garden</h2>
	<!-- Year Selection -->
	<button id="fertilize" class="button button--gray">Fertilize</button>
	<button id="harvest" class="button button--gray">Harvest</button>
</div>
<div class="inline-grid">
<div class="card garden">
	<svg class="garden__icon garden__icon--green" role="presentation"><use xlink:href="#framework_svg_leaf" /></svg>
	<h3 class="heading--label garden__heading">Bed 1</h3>
	<ul class="garden__list">
		<li>Tomatoes</li>
		<li>Peppers</li>
		<li>Nasturtium</li>
	</ul>
</div>
	
<div class="card garden">
	<svg class="garden__icon garden__icon--green" role="presentation"><use xlink:href="#framework_svg_leaf" /></svg>
	<h3 class="heading--label garden__heading">Bed 2</h3>
	<ul class="garden__list">
		<li>Beans</li>
	</ul>
</div>
	
<button class="card garden garden--add">
	<svg class="garden__icon" viewBox="0 0 20 20">
		<path d="M10,1.6c-4.639,0-8.4,3.761-8.4,8.4s3.761,8.4,8.4,8.4s8.4-3.761,8.4-8.4S14.639,1.6,10,1.6z M15,11h-4v4H9
	v-4H5V9h4V5h2v4h4V11z"/>
</svg>
	<h3 class="heading--label garden__heading">Add New Bed</h3>
</button>
	
</div>
</section>   
<?php
	$page->footer();
?>