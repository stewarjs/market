<?php

require_once('../core/layout/engine.php');
require_once('../core/api/poultry.php');
$title = 'Poultry';


if(isset($_GET['id'])){
	$house_id = $_GET['id'];
	$houses = get_houses($house_id);
	$title = $houses->fetchObject()->name;
	$add_button = '<button class="card garden garden--add" data-house="' . $house_id . '" id="add_bird"><svg class="garden__icon" viewBox="0 0 20 20"><path d="M10,1.6c-4.639,0-8.4,3.761-8.4,8.4s3.761,8.4,8.4,8.4s8.4-3.761,8.4-8.4S14.639,1.6,10,1.6z M15,11h-4v4H9
	v-4H5V9h4V5h2v4h4V11z"/></svg><h3 class="heading--label garden__heading">Add Bird</h3></button>';
}else{
	$houses = get_houses();
	$add_button = '<button class="card garden garden--add" id="add_house"><svg class="garden__icon" viewBox="0 0 20 20"><path d="M10,1.6c-4.639,0-8.4,3.761-8.4,8.4s3.761,8.4,8.4,8.4s8.4-3.761,8.4-8.4S14.639,1.6,10,1.6z M15,11h-4v4H9
	v-4H5V9h4V5h2v4h4V11z"/></svg><h3 class="heading--label garden__heading">Add House</h3></button>';
}

$page = new page();

$page->title($title);
$page->header();


?>

<section>
<div class="page__header">     	
	<h2 class="heading--small"><?php echo $title; ?></h2>
	<?php
	if(isset($house_id)) {
		echo '<button class="button button--gray button--red" data-house="' . $house_id . '" id="delete_house">Delete</button>';
	}else{
		echo '<button id="activity" class="button button--gray">Add Activity</button>';
	}
	?>
</div>

<?php
	if(!isset($house_id)){
		echo '<div class="inline-grid">';
		foreach($houses as $house) {
			$birds = get_birds($house['id']);
			$bird_count = $birds->rowCount();
			echo '<a class="card garden" href="index.php?id=' . $house['id'] . '"><svg class="garden__icon" role="presentation"><use xlink:href="#framework_svg_barn" /></svg><h3 class="heading--label garden__heading">' . $house['name'] . '</h3><span class="garden__date">Total birds: '. $bird_count .'</span></a>';
		}
		echo $add_button;
		echo '</div>';
	}else{
		$birds = get_birds($house_id);
		/*$bird_count = $birds->result->num_rows;*/
		$now = new DateTime('now');
		$birthdate = new DateTime();
		echo '<div class="flex"><div class="inline-grid flex__box--70">';
		foreach($birds as $bird) {
			$birthdate->setTimestamp(strtotime($bird['birth']));
			$date = $birthdate->diff($now)->format("%a");
			if($date > 7) {
				$date = floor($date / 7) . ' weeks';
			}else{
				$date .= ' days';
			}
			echo '<input type="checkbox" name="bird__' . $bird['id'] . '" id="bird__' . $bird['id'] . '" class="bird"/><label class="card garden bird" for="bird__' . $bird['id'] . '"><svg class="garden__icon" role="presentation"><use xlink:href="#framework_svg_chicken" /></svg><h3 class="heading--label garden__heading">' . $bird['breed'] . '</h3><span class="garden__date">'. $date .'</span></label>';
		}
		echo $add_button;
		/* <button class="button button--blue" id="move_bird" disabled>Move Bird(s)</button><button class="button button--gray button--red" id="delete_bird" disabled>Delete Bird(s)</button> */
		echo '</div><aside class="flex__box--20 aside--right"><select data-update="false" data-house="'. $house_id .'" id="bird_options" aria-label="Select an option"><option selected disabled value="">Select an Option</option><option id="move_bird" value="move_bird">Move Bird(s)</option><option id="delete_bird" value=delete_bird"">Delete Bird(s)</option><option id="harvest_bird" value="harvest_bird">Harvest Bird(s)</option><option id="log_activity" value="log_activity" data-house="'. $house_id .'">Add Feed or Products</option><option id="log_eggs" value="log_eggs">Log Egg Production</option></select><h4 class="heading--label">House Stats</h4><ul class="stats"><li><span class="stats__value">' . round(total_eggs($house_id), 1) . '</span><span class="stats__label">Total Eggs</span></li><li><span class="stats__value">$' . round(total_cost($house_id), 2) . '</span><span class="stats__label">Total Costs</span></li></ul></aside></div>';
	}
	
	
	
?>



</section>   
<?php
	$page->add_scripts(array('/core/layout/scripts/poultry.php'));
	$page->footer();
?>