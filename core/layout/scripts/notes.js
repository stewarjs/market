$( "#add_note" ).on('click', function() {
			
	var def = $(this)[0].id;
	$.modal({title: 'Add Note', parentID: def, content: '<form id="note_form" action="index.php" method="post"><label for="title">Title</label><input type="text" name="title" id="title" required="true" /><label for="note">Note</label><textarea id="note" name="note" required="true"></textarea></form>', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button form="note_form" class="button button--blue">Add Note</button></div>'});

});