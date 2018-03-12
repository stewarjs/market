<?php

require_once('../core/layout/engine.php');

$page = new page();

$page->title('Products');

$page->header();


?>

<section>
<div class="page__header">     	
	<h2 class="heading--small">Products</h2>
	<!-- Year Selection -->
</div>
<h3 class="heading--label">Products purchased this year</h3>
<div class="flex">
	<div class="flex__box--70">
		<table>
			<tr>
				<th>Product</th>
				<th>Type</th>
				<th>Last Purchase</th>
				<th>Purchases</th>
				<th>Amount</th>
				<th>Avg. Unit Price</th>
				<th>Total Cost</th>
			</tr>	
			<tr>
				<td>Garden-tone</td>
				<td>Fertilizer</td>
				<td>March 1, 2018</td>
				<td>1</td>
				<td>2 cubic feet</td>
				<td>$5.00 / cubic-foot</td>
				<td>$10.00</td>
			</tr>
		</table>
	</div>
	<aside class="flex__box--20 aside--right">
	<button class="button button--blue" id="add_product">Log New Purchase</button>
	<h4 class="heading--label">Stats</h4>
	<ul class="stats">
		<li><span class="stats__value">$10.00</span><span class="stats__label">Expenses to date</span></li>	
		<li><span class="stats__value">1</span><span class="stats__label">Expenses logged</span></li>
	</ul>
	</aside>
	
</div>
</section>
    
<?php $page->footer(); ?>