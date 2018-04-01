$( "#add_note" ).on('click', function() {
			
	var def = $(this)[0].id;
	$.modal({title: 'Add Note', parentID: def, content: '<form id="note_form" action="index.php" method="post"  enctype="multipart/form-data"><label for="title">Title</label><input type="text" name="title" id="title" required="true" /><label for="note">Note</label><textarea id="note" name="note" required="true"></textarea><label class="attach_file" for="file"><svg class="icon" role="presentation"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#framework_svg_attachment"></use></svg> <span>Attach a file or image</span></label><input type="file" id="file_upload" name="file" size="25" data-multiple-caption="{count} files selected" /></form>', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button form="note_form" class="button button--blue">Add</button></div>'});


});