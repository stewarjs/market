var urlParams = new URLSearchParams(window.location.search);

if(urlParams.has('term')) {
	var search_term = urlParams.get('term');
	searchThis(search_term);
}

$( "#add_note" ).on('click', function() {
			
	var def = $(this)[0].id;
	$.modal({title: 'Add Note', parentID: def, content: '<form id="note_form" action="index.php" method="post"  enctype="multipart/form-data"><label for="title">Title</label><input type="text" name="title" id="title" required="true" /><label for="note">Note</label><textarea id="note" name="note" required="true"></textarea><label class="attach_file" for="file"><svg class="icon" role="presentation"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#framework_svg_attachment"></use></svg> <span>Attach a file or image</span></label><input type="file" id="file_upload" name="file" size="25" data-multiple-caption="{count} files selected" /></form>', footer: '<div class="button-group--directional align--right"><button type="reset" class="button button--gray modal__close">Close</button><button form="note_form" class="button button--blue">Add</button></div>'});


});

function searchThis(query) {
	var regex = new RegExp(query, "i");
	  $('.note').each(function() {
		if (($(this).children('.note__header').text().search(regex) !== -1)) {
			$(this).children('.note__header').html(selectMatch($(this).children('.note__header').text(), query));
			($(this).hasClass('no_match') ? $(this).removeClass('no_match') : false);
		}else if(($(this).children('.note__content').text().search(regex) !== -1)) {
			$(this).children('.note__content').html(selectMatch($(this).children('.note__content').text(), query));
			($(this).hasClass('no_match') ? $(this).removeClass('no_match') : false);
		}else{
			$(this).addClass('no_match');
		}
	  });
}

function selectMatch(haystack, needle) {
    var reg = new RegExp(needle, 'gi'),
    		occurrance = haystack.search(reg),
    		selection = haystack.substr(occurrance - 100, 100);
    return selection.replace(new RegExp('(^|)(' + needle + ')(|$)','ig'), '$1<span class="highlight">$2</span>$3');
}