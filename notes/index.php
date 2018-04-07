<?php

require_once('../core/layout/engine.php');
require_once('../core/api/database.php');

$db = new database();
$page = new page();

$page->title('Notes');
$page->header();

class note {
	
	public function create($title, $date, $content, $attachment = false) {
		
		$note = '<div class="note">' .
				'<h3 class="note__header">'. $title .'</h3>' .	
				'<time datetime="' . date("c", strtotime($date)) . '" class="note__date">'. date("M j, Y", strtotime($date)) .'</time>' .
				'<div class="note__content">'.
				'<p>'. $content .'</p></div>';
				if($attachment !== false) {
					$note .= '<div class="note__attachment"><a href="'. $attachment . '" target="_blank"><svg class="icon icon--small" role="presentation"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#framework_svg_attachment"></use></svg> ' . basename($attachment) . '</a></div>';
				}
				$note .= '<div class="note__footer">'.
				'<button class="button button--gray note__button--edit">Edit</button>'.
				'<button class="button button--gray button--red">Delete</button>'.
				'</div></div>';
		return $note;
	}
	
	public function search($haystack, $needle) {
		if (strlen($haystack) < 1 || strlen($needle) < 1) {
			return $haystack;
		}
		preg_match_all("/$needle+/i", $haystack, $matches);
		if (is_array($matches[0]) && count($matches[0]) >= 1) {
			foreach ($matches[0] as $match) {
				$haystack = str_replace($match, '<span class="highlight">'.$match.'</span>', $haystack);
			}
		}
		return $haystack;
	}
	
	
}

if(!empty($_POST)) {
	$title = $_POST['title'];
	$note = $_POST['note'];
	
	if($_FILES['file']['name']) {
		if(!$_FILES['file']['error']) {
			$new_file_name = strtolower($_FILES['file']['name']);
			$file_location = $_SERVER['DOCUMENT_ROOT'] . 'notes/files/'.$new_file_name;
			move_uploaded_file($_FILES['file']['tmp_name'], $file_location);
			
			$return = $db->runSQL('INSERT INTO notes (title, date, content, file_path) VALUES ("' . $title . '", "' . date('Y-m-d') . '", "' . $note . '", "'. '/notes/files/'.$new_file_name . '");');
		} else {
			$message = 'Your upload triggered the following error:  '.$_FILES['file']['error'];
		}
	}else{
	
		$return = $db->runSQL('INSERT INTO notes (title, date, content, file_path) VALUES ("' . $title . '", "' . date('Y-m-d') . '", "' . $note . '", "");');
	}
	
}

?>

<section>
<div class="page__header">     	
	<h2 class="heading--small">Notes</h2>
	<form id="note_search" action="index.php" method="get">
		<input class="search" type="search" name="term" id="term" placeholder="e.g. seedlings" aria-label="Enter search term" />
		<button type="submit" class="button button--gray search__button" id="search_button" aria-label="Search">
			<svg class="icon" role="presentation"><use xlink:href="#framework_svg_search-ico" /></svg>
		</button>
	</form>
</div>
<button id="add_note" class="button button--blue">Add Note</button>
	
<?php
	$note = new note();
	$list = $db->runSQL('SELECT * FROM notes ORDER BY date DESC');
	
	if(isset($_GET['term'])) {
		$term = $_GET['term'];
		$results = [];
		foreach($list as $item) {
			if(!empty($item['file_path'])) {
				$var =  $note->create($note->search($item['title'], $term), $item['date'], $note->search($item['content'], $term), $item['file_path']);
				if(stripos($var, $term) !== false) {
					array_push($results, $var);
				}
			}else{
				$var = $note->create($note->search($item['title'], $term), $item['date'], $note->search($item['content'], $term));
				if(stripos($var, $term) !== false) {
					array_push($results, $var);
				}
			}
		}
		if(!empty($results)) {
			echo implode(',', $results);
		} else {
			echo '<p>No notes matched your search term.</p>';
		}
	}else{
		foreach($list as $item) {
			if(!empty($item['file_path'])) {
				echo $note->create($item['title'], $item['date'], $item['content'], $item['file_path']);
			}else{
				echo $note->create($item['title'], $item['date'], $item['content']);
			}
		}
	}
	
	
	
?>
</section>   
<?php
	$page->add_scripts(array('/core/layout/scripts/notes.js'));
	$page->footer();
?>