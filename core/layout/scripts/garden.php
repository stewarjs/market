<?php
require_once('../../api/garden.php');
require_once('../../api/products.php');
$beds = get_beds();
$bed_list = '<select id="house_list" data-width="100%"><option value="" selected disabled>Select a House</option>';
$count = 1;
foreach($beds as $bed) {
	$bed_list .= '<option value="' . $bed['id'] . '">' . $bed['name'] . '</option>';
}
$bed_list .=  '</select>';

header('Content-Type: application/javascript');
?>
if(document.getElementById('bird_options')) {
	$('#bird_options').DropDown();
	function $error_modal(def) {
		$.modal({title: 'Error', parentID: def, content: '<p>You must select one or more birds before you can take this action</p>', footer: '<div class="button-group align--right"><button type="reset" class="button button--gray modal__close">Close</button></div>'});
	}
}
$( "#add_bed" ).on('click', function() {
			
	var def = $(this)[0].id;
	$.modal({title: 'Add New Bed', parentID: def, content: '<label for="bed">Enter Bed Name</label><input type="text" name="bed" id="bed" />', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_bed" class="button button--blue">Add</button></div>'});

	$('#submit_bed').on('click', function() {
		$.ajax({
			method: "POST",
			url: "/core/api/garden.php",
			data: { addBed: true, bed: document.getElementById('bed').value }
		})
		.done(function() {
			window.location.reload(true);
		});
	});

});

$( "#delete_bed" ).on('click', function() {
			
	var def = $(this)[0].id;
	$.modal({title: 'Delete Bed', parentID: def, content: '<p>This action will permanently remove this garden bed and any plants associated with it.</p><p>Are you sure you want to permanently delete this garden bed?</p>', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">No</button><button id="delete_this_bed" class="button button--gray button--red">Yes</button></div>'});

	$('#delete_this_bed').on('click', function() {
		$.ajax({
			method: "POST",
			url: "/core/api/garden.php",
			data: { deleteBed: true, house: $("#delete_bed").attr('data-bed') }
		})
		.done(function() {
			window.location = '/garden/';
		})
		.fail(function(msg) {
			console.log(msg);
		});
	});

});


$( "#add_plant" ).on('click', function() {
			
	var def = $(this)[0].id,
		bedID = $(this).attr('data-bed');
	$.modal({title: 'Add New Plant', parentID: def, content: '<label for="name">Enter Plant Type</label><input type="text" name="name" id="name" /><label for="variety">Enter Variety</label><input type="text" name="variety" id="variety" /><label for="plant_date">Enter Planting Date</label><input type="date" name="plant_date" id="plant_date" /><label for="number_to_plant">Enter Number of Plantings</label><input type="number" name="number_to_plant" id="number_to_plant" /><label for="days_to_maturity">Enter Days in Ground</label><input type="number" name="days_to_maturity" id="days_to_maturity" /><input type="hidden" name="bed" id="bed" value="' + bedID + '" />', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_plant" class="button button--blue">Add</button></div>'});

	$('#submit_plant').on('click', function() {
		$.ajax({
			method: "POST",
			url: "/core/api/garden.php",
			data: { addPlant: true, name: document.getElementById('name').value, variety: document.getElementById('variety').value, number: document.getElementById('number_to_plant').value, plant_date: document.getElementById('plant_date').value, days_to_maturity: document.getElementById('days_to_maturity').value, bed: document.getElementById('bed').value }
		})
		.done(function(msg) {
			window.location.reload(true);
		});
	});

});

/*
$( 'li[data-value="move_bird"]' ).on('click', function() {
	if(document.querySelectorAll('.bird:checked').length < 1) {
		$error_modal('bird_options__custom-select');
		return false;
	}	
	var def = 'bird_options__custom-select';
	$.modal({title: 'Move Birds', parentID: def, content: '<label for="house_list">Where do you want to move them to?</label><?php echo $house_list; ?>', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_move" class="button button--blue">Move</button></div>'});

	$('#house_list').DropDown();

	$('#submit_move').on('click', function() {

	});

});

$('#egg_timeline').on('click', function(event) {
	
	var def = $(this)[0].id,
		houseID = $(this).attr('data-house');
	$.modal({title: 'Total Eggs', parentID: def, loadContent: 'egg_timeline.php?house_id=' + houseID, footer: '<div class="button-group align--right"><button type="reset" class="button button--gray modal__close">Close</button></div>'});
	event.preventDefault();
});

$( 'li[data-value="log_activity"]' ).on('click', function() {
			
	var def = 'bird_options__custom-select',
		house_id = document.getElementById(def).getAttribute('data-house');
	$.modal({title: 'Poultry Activity', parentID: def, content: '<input type="hidden" name="house_list" id="house_list" value="' + house_id + '" /><label for="feed_list">Which product are you using?</label><?php echo $feed_list; ?><label for="amount" id="metric_amount">How much?</label><input type="number" step="0.01" name="amount" id="amount" />', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_activity" class="button button--blue">Add</button></div>'});
	$('#feed_list').DropDown();
	$('#feed_list').on('change', function() {
		$('#metric_amount').html('How much (in ' + $('#feed_list option:selected')[0].getAttribute('data-metric') + ')?');
	});
	$('#submit_activity').on('click', function() {
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

$( 'li[data-value="log_eggs"]' ).on('click', function() {
	var def = 'bird_options__custom-select',
		house_id = document.getElementById(def).getAttribute('data-house');
	$.modal({title: 'Log Eggs', parentID: def, content: '<label for="amount">How many eggs were collected?</label><input type="number" name="amount" id="amount" /><input type="hidden" name="house" id="house" value="' + house_id + '" />', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_eggs" class="button button--blue">Log</button></div>'});

	$('#house_list').DropDown();

	$('#submit_eggs').on('click', function() {
		$.ajax({
			method: "POST",
			url: "/core/api/poultry.php",
			data: { addEggs: true, house: document.getElementById('house').value, amount: document.getElementById('amount').value}
		})
		.done(function() {
			window.location.reload(true);
		});
	});

});
*/