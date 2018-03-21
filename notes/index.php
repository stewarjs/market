<?php

require_once('../core/layout/engine.php');

$page = new page();

$page->title('Notes');
$page->header();


?>

<section>
<div class="page__header">     	
	<h2 class="heading--small">Notes</h2>
	<div>
		<input class="search" type="search" name="search" id="search" placeholder="e.g. seedlings" />
		<button class="button button--gray search__button" aria-label="Search">
			<svg class="icon" role="presentation"><use xlink:href="#framework_svg_search-ico" /></svg>
		</button>
	</div>
</div>
<button class="button button--blue">Add Note</button>
	
<div class="note">
<h3 class="note__header">Spring 2018</h3>	
<p class="note__date">March 7, 2018</p>
<div class="note__content">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ac lectus id diam tempus semper non eu orci. Nunc quis ligula molestie, porttitor sapien at, luctus orci. Vivamus eu nibh vulputate, elementum lectus in, venenatis quam. Aenean sapien erat, blandit et bibendum quis, vestibulum non ante. Etiam tempor consequat est sed dapibus. Praesent nec nisi felis. Ut venenatis, neque et vestibulum hendrerit, felis metus ornare magna, non tincidunt odio eros eget ante.</p>
</div>
<div class="note__footer">
<button class="button button--gray note__button--edit">Edit</button>
<button class="button button--gray button--red">Delete</button>
</div>
	
</div>
</section>   
<?php
	$page->footer();
?>