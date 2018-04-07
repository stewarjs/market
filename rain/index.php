<?php

require_once('../core/layout/engine.php');
require_once('../core/api/rain.php');

$list = get();
if(!empty($list)) {
	$rain_total = weekly_rain()->fetchObject()->total;
	/*foreach($list as $entry) {
		$rain_total = $rain_total + $entry['amount'];
	}*/
	$now = new DateTime('now');
	$last_rainfall = new DateTime($list[0]['date']);
	$last_amount = $list[0]['amount'];
	$interval = $last_rainfall->diff($now)->format('%a days ago');
}else{
	$rain_total = 0;
	$interval = 'No rain logged';
	$last_amount = 0;
}

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
	<button class="button button--blue" id="log_rain">Log Rain Fall</button>
	<h4 class="heading--label">Stats</h4>
	<ul class="stats">
		<li><span class="stats__value"><?php echo $last_amount; ?>"</span><span class="stats__label"><?php echo $interval; ?></span></li>	
		<li><span class="stats__value"><?php echo $rain_total; ?>"</span><span class="stats__label">Rain this week</span></li>
	</ul>
	</aside>
	
</div>
</section>   
<?php
	$page->add_scripts(array('/core/chartist/chartist.min.js', '/core/layout/scripts/rain_accumulation.php', '/core/layout/scripts/log_rain.js'));
	$page->footer();
?>