<?php

require_once('../core/layout/engine.php');

$page = new page();

$page->title('Activities');
$page->header();


?>

<section>
<div class="page__header">     	
	<h2 class="heading--small">Activities</h2>
	<!-- Year Selection -->
</div>
<button class="button button--blue">Add Activity</button>
	
<div class="activity" id="activity_1">
	<button class="activity__button" role="checkbox" aria-checked="false" aria-labelledby="label date"><svg class="icon" role="presentation"><use xlink:href="#framework_svg_check" /></svg></button>
	<span id="label" class="activity__name">Plant Sunflowers</span>
	<span id="date" class="activity__date">March 17</span>
</div>
</section>   
<?php
	$page->footer();
?>