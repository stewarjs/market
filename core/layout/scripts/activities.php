<?php
require_once('../../api/poultry.php');

$houses = get_houses();
$house_list = '<select id="house_list" data-width="100%"><option value="" selected disabled>Select a House</option>';
$count = 1;
foreach($houses->result as $house) {
	$house_list .= '<option value="' . $house['id'] . '">' . $house['name'] . '</option>';
}
$house_list .=  '</select>';

header('Content-Type: application/javascript');
?>
$( ".card--selection" ).on('click', function() {
			
	var def = $(this)[0].id,
		activity;

	// Switch the activity based upon selection

	$.modal({title: 'Add Activity', parentID: def, content: activity, footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_house" class="button button--blue">Add</button></div>'});

	$('#submit_house').on('click', function() {
		$.ajax({
			method: "POST",
			url: "/core/api/poultry.php",
			data: { addHouse: true, house: document.getElementById('house').value }
		})
		.done(function() {
			window.location.reload(true);
		});
	});

});