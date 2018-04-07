<?php

require_once('../core/layout/engine.php');
require_once('../core/api/garden.php');
$page = new page();

$title = 'Garden';
$page->title($title);
$page->header();

if(isset($_GET['id'])){
	$bed_id = $_GET['id'];
	$beds = get_beds($bed_id);
	$title = $beds->fetchObject()->name;
	$add_button = '<button class="card garden garden--add" data-bed="' . $bed_id . '" id="add_plant"><svg class="garden__icon" viewBox="0 0 20 20"><path d="M10,1.6c-4.639,0-8.4,3.761-8.4,8.4s3.761,8.4,8.4,8.4s8.4-3.761,8.4-8.4S14.639,1.6,10,1.6z M15,11h-4v4H9
	v-4H5V9h4V5h2v4h4V11z"/></svg><h3 class="heading--label garden__heading">Add Plant</h3></button>';
}else{
	$beds = get_beds();
	$add_button = '<button class="card garden garden--add" id="add_bed"><svg class="garden__icon" viewBox="0 0 20 20"><path d="M10,1.6c-4.639,0-8.4,3.761-8.4,8.4s3.761,8.4,8.4,8.4s8.4-3.761,8.4-8.4S14.639,1.6,10,1.6z M15,11h-4v4H9
	v-4H5V9h4V5h2v4h4V11z"/></svg><h3 class="heading--label garden__heading">Add Bed</h3></button>';
}

?>

<section>
<div class="page__header">     	
	<h2 class="heading--small"><?php echo $title; ?></h2>
	<?php
	if(isset($bed_id) && !isset($_GET['schedule'])) {
		echo '<button class="button button--gray button--red" data-bed="' . $bed_id . '" id="delete_bed">Delete</button> '.
			'<a href="index.php?id=' . $bed_id . '&schedule=show" class="button button--blue">View Schedule</a>';
	}
	?>
</div>
	
<?php
	if(!isset($bed_id)){
		echo '<div class="inline-grid">';
		foreach($beds as $bed) {
			$number_of_plants = number_of_plants($bed['id']);
			$number_of_plants = $number_of_plants->fetchObject()->total;
			echo '<a class="card garden" href="index.php?id=' . $bed['id'] . '"><svg class="garden__icon garden__icon--green" role="presentation"><use xlink:href="#framework_svg_leaf" /></svg><h3 class="heading--label garden__heading">' . $bed['name'] . '</h3><span class="garden__date">Total plants: '. $number_of_plants . '</span></a>';
		}
		echo $add_button;
		echo '</div>';
	}else if(!isset($_GET['schedule'])){
		$plants = get_plants($bed_id);
		
		echo '<div class="flex"><div class="inline-grid flex__box--70">';
		foreach($plants as $plant) {
			echo '<input type="checkbox" name="plant__' . $plant['id'] . '" id="plant__' . $plant['id'] . '" class="bird"/><label class="card garden bird" for="plant__' . $plant['id'] . '"><svg class="garden__icon" role="presentation"><use xlink:href="#framework_svg_leaf" /></svg><h3 class="heading--label garden__heading">' . $plant['name'] . '<br><span class="garden__heading__variety">' . $plant['variety'] . ' (' . $plant['number_of_plantings'] . ')</span></h3><span class="garden__date">Plant date: '. date('M d', strtotime($plant['plant_date'])) .'</span></label>';
		}
		echo $add_button;
	}else if(isset($_GET['schedule'])){
		echo '<div class = "svg"></div><div id = "tag"></div>';
	}
	
	
	
?>

</section>   
<?php
	if(isset($_GET['schedule'])){
		$page->add_scripts(array('https://cdnjs.cloudflare.com/ajax/libs/d3/3.3.3/d3.min.js', '/core/layout/scripts/garden.php','/core/layout/scripts/garden_schedule.php?id=' . $bed_id));
	}else{
		$page->add_scripts(array('/core/layout/scripts/garden.php'));
	}
	$page->footer();
?>