<?php

require_once('../core/layout/engine.php');
require_once('../core/api/database.php');

$db = new database();
$page = new page();

$page->title('Notes');
$page->header();

if(!empty($_POST)) {
	$title = $_POST['title'];
	$note = $_POST['note'];
	
	$return = $db->runSQL('INSERT INTO notes (title, date, content) VALUES ("' . $title . '", "' . date('Y-m-d') . '", "' . $note . '");');
	
}

?>

<section>
<div class="page__header">     	
	<h2 class="heading--small">Notes</h2>
	<form id="note_search" action="index.php" method="post">
		<input class="search" type="search" name="search" id="search" placeholder="e.g. seedlings" aria-label="Enter search term" />
		<button type="submit" class="button button--gray search__button" id="search_button" aria-label="Search">
			<svg class="icon" role="presentation"><use xlink:href="#framework_svg_search-ico" /></svg>
		</button>
	</form>
</div>
<button id="add_note" class="button button--blue">Add Note</button>
	
<?php
	$notes = $db->runSQL('SELECT * FROM notes');
	foreach($notes as $note) {
		echo '<div class="note">' .
			'<h3 class="note__header">'. $note['title'] .'</h3>' .	
			'<p class="note__date">'. date("M j, Y", strtotime($note['date'])) .'</p>' .
			'<div class="note__content">'.
			'<p>'. $note['content'] .'</p>'.
			'</div>'.
			'<div class="note__footer">'.
			'<button class="button button--gray note__button--edit">Edit</button>'.
			'<button class="button button--gray button--red">Delete</button>'.
			'</div></div>';
	}
?>
</section>   
<?php
	$page->add_scripts(array('/core/layout/scripts/notes.js'));
	$page->footer();
?>