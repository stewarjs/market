$( "#log_rain" ).on('click', function() {
			
	var def = $(this)[0].id;
	$.modal({title: 'Log Rainfall', parentID: def, content: '<label for="date">Enter Date of Rainfall</label><input type="date" name="date" id="date" /><label for="amount">Enter Amount of Rainfall in Inches</label><input type="number" name="amount" id="amount" step="0.01" />', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button id="submit_log" class="button button--blue">Log</button></div>'});

	$('#submit_log').on('click', function() {
		$.ajax({
			method: "POST",
			url: "/core/api/rain.php",
			data: { add: true, date: document.getElementById('date').value, amount: document.getElementById('amount').value }
		})
		.done(function() {
			window.location.reload(true);
		});
	});

});