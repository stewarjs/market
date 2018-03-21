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
<?php if(!isset($_GET['type'])) :?>
<a href="index.php?type" class="button button--blue">Add Activity</a>
<ul class="activity__list">	
	<li><button class="activity" id="activity_1">
		<svg class="icon activity__icon" role="presentation"><use xlink:href="#framework_svg_check" /></svg>
		<span id="label" class="activity__name">Plant Sunflowers</span>
		<span id="date" class="activity__date">March 17</span>
	</div>
	</button> </li> 
</ul>

<?php else: ?>
<div class="inline-grid align--center">
<button id="fertilize" class="card card--selection">Fertilize</button>
<button id="feed" class="card card--selection">Feed</button>
<button id="harvest" class="card card--selection">Harvest</button>
</div>

<?php endif; ?>
<?php
	$page->add_scripts(array('/core/layout/scripts/activities.php'));
	$page->footer();
?>