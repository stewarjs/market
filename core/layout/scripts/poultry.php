<?php
require_once('../../api/poultry.php');
require_once('../../api/products.php');
$houses = get_houses();
$house_list = '<select id="house_list" data-width="100%"><option value="" selected disabled>Select a House</option>';
$count = 1;
foreach($houses->result as $house) {
	$house_list .= '<option value="' . $house['id'] . '">' . $house['name'] . '</option>';
}
$house_list .=  '</select>';

$poultry_products = get_products(array('Feed', 'Bedding'));

$feed_list = '<select id="feed_list" data-width="100%"><option value="" selected disabled>Select a Product</option>';
$count = 1;
foreach($poultry_products->result as $feed) {
	$feed_list .= '<option data-metric="' . $feed['metric'] . '" value="' . $feed['id'] . '">' . $feed['name'] . '</option>';
}
$feed_list .=  '</select>';
header('Content-Type: application/javascript');
?>
if(document.getElementById('bird_options')) {
	$('#bird_options').DropDown();
	function $error_modal(def) {
		$.modal({title: 'Error', parentID: def, content: '<p>You must select one or more birds before you can take this action</p>', footer: '<div class="button-group align--right"><button type="reset" class="button button--gray modal__close">Close</button></div>'});
	}
}
$( "#add_house" ).on('click', function() {
			
	var def = $(this)[0].id;
	$.modal({title: 'Add New House', parentID: def, content: '<label for="name">Enter Name House</label><input type="text" name="house" id="house" />', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_house" class="button button--blue">Add</button></div>'});

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

$( "#delete_house" ).on('click', function() {
			
	var def = $(this)[0].id;
	$.modal({title: 'Delete House', parentID: def, content: '<p>This action will permanently remove this house and any birds associated with it.</p><p>Are you sure you want to permanently delete this house?</p>', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">No</button><button id="delete_this_house" class="button button--gray button--red">Yes</button></div>'});

	$('#delete_this_house').on('click', function() {
		$.ajax({
			method: "POST",
			url: "/core/api/poultry.php",
			data: { deleteHouse: true, house: $("#delete_house").attr('data-house') }
		})
		.done(function() {
			window.location = '/poultry/';
		})
		.fail(function(msg) {
			console.log(msg);
		});
	});

});
$( "#add_bird" ).on('click', function() {
			
	var def = $(this)[0].id,
		houseID = $(this).attr('data-house');
	$.modal({title: 'Add New Bird', parentID: def, content: '<label for="breed">Enter Breed</label><input type="text" name="breed" id="breed" /><label for="birth">Enter Birthdate</label><input type="date" name="birth" id="birth" /><label for="cost">Enter Purchase Price</label><input type="number" step="0.01" name="cost" id="cost" /><input type="hidden" name="house" id="house" value="' + houseID + '" />', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_bird" class="button button--blue">Add</button></div>'});

	$('#submit_bird').on('click', function() {
		$.ajax({
			method: "POST",
			url: "/core/api/poultry.php",
			data: { addBird: true, breed: document.getElementById('breed').value, birth: document.getElementById('birth').value, house: document.getElementById('house').value }
		})
		.done(function() {
			window.location.reload(true);
		});
	});

});

$( 'li[data-value="move_bird"]' ).on('click', function() {
	if(document.querySelectorAll('.bird:checked').length < 1) {
		$error_modal('bird_options__custom-select');
		return false;
	}	
	var def = 'bird_options__custom-select';
	$.modal({title: 'Move Birds', parentID: def, content: '<label for="house_list">Where do you want to move them to?</label><?php echo $house_list; ?>', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_move" class="button button--blue">Move</button></div>'});

	$('#house_list').DropDown();

	$('#submit_move').on('click', function() {
		/*$.ajax({
			method: "POST",
			url: "/core/api/poultry.php",
			data: { addHouse: true, house: document.getElementById('house').value }
		})
		.done(function() {
			window.location.reload(true);
		});*/
	});

});

$( 'li[data-value="log_activity"]' ).on('click', function() {
			
	var def = 'bird_options__custom-select',
		house_id = document.getElementById(def).getAttribute('data-house');
	$.modal({title: 'Poultry Activity', parentID: def, content: '<input type="hidden" name="house_list" id="house_list" value="' + house_id + '" /><label for="feed_list">Which product are you using?</label><?php echo $feed_list; ?><label for="amount" id="metric_amount">How much?</label><input type="number" step="0.01" name="amount" id="amount" />', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_activity" class="button button--blue">Add Activity</button></div>'});
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
	$.modal({title: 'Log Eggs', parentID: def, content: '<label for="amount">How many eggs were collected?</label><input type="number" name="amount" id="amount" /><input type="hidden" name="house" id="house" value="' + house_id + '" />', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_eggs" class="button button--blue">Log Eggs</button></div>'});

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