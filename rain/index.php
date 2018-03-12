<?php

require_once('../core/layout/engine.php');

$page = new page();

$page->title('Rain Gauge');
$page->add_styles(array('/core/chartist/chartist.min.css'));
$page->header();


?>

<section>
<div class="page__header">     	
	<h2 class="heading--small">Rain Gauge</h2>
	<!-- Year Selection -->
</div>
<h3 class="heading--label">Monthly Rainfall</h3>
<div class="flex">
	<div id="chart--rain" class="flex__box--70"></div>
	<aside class="flex__box--20 aside--right">
	<button class="button button--blue" id="add_product">Log Rain Fall</button>
	<h4 class="heading--label">Stats</h4>
	<ul class="stats">
		<li><span class="stats__value">1"</span><span class="stats__label">2 Days Ago</span></li>	
		<li><span class="stats__value">17"</span><span class="stats__label">Rain to date</span></li>
	</ul>
	</aside>
	
</div>
</section>   
<?php
	$page->add_scripts(array('/core/chartist/chartist.min.js', '/core/layout/scripts/rain_accumulation.php'));
	$page->footer();
?>