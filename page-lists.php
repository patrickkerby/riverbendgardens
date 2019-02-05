<?php
/*
Template Name: Lists
*/
?>

<?php 
// ------------------------- Begin Page Layout -------------------------    

require_once('list_functions.php');

if(is_page_template('page-lists.php')) {
		get_header('lists');
	}
	else {
		get_header();
	}

// Get location, set by ACF in page

	$product = get_field('product');
	$product_title = $product->post_title;
	$location_term = get_field('location');
	$school_location = get_field('school_location');	

	if( $location_term ): 				
		$season = $location_term->name;
		$weekly = $location_term->slug;
	elseif ( $school_location ): 				
		$season = $school_location;
		$weekly = '';
	else:
	endif; 

// Counters
	$seasonal_count = 0;
	$seasonal_count_bigger = 0;
	$seasonal_count_smaller = 0;	 

// 15 week query
// (all orders with a location of X and a product of Y. Product and Location is set via ACF on a Page.

	global $wpdb;
	
	$order_items = 'wp_woocommerce_order_items';
	$order_meta = 'wp_woocommerce_order_itemmeta';
	$order_data = $wpdb->prefix . 'posts';
	$customer_meta = $wpdb->prefix . 'postmeta';

	$sql_season = ( "
		SELECT Q1.order_id, Q4.first_name, Q5.last_name, Q1.location, Q3.size, Q6.qty, Q7.customer_note
		FROM 
			(
				SELECT $order_items.order_id AS order_id, $order_items.order_item_id AS location_id, $order_meta.meta_value AS location
				FROM $order_items, $order_meta
				WHERE $order_items.order_item_id = $order_meta.order_item_id
				AND BINARY $order_meta.meta_value = '$season'
				AND $order_items.order_item_name LIKE '$product_title%'
			) Q1
		INNER JOIN
			(	SELECT DISTINCT $order_data.ID AS ID, $order_data.post_status AS post_status
				FROM $order_data
				WHERE $order_data.post_status = 'wc-processing'
			)	Q2
		ON Q1.order_id = Q2.ID	
		INNER JOIN
			(
				SELECT $order_meta.order_item_id AS item_id, $order_meta.meta_value AS size
				FROM $order_meta
				WHERE $order_meta.meta_key IN ('size')
			)	Q3	
		ON Q1.location_id = Q3.item_id
		INNER JOIN
			(
				SELECT $customer_meta.post_id AS customer_id, $customer_meta.meta_value AS first_name
				FROM $customer_meta
				WHERE $customer_meta.meta_key IN ('_billing_first_name')
			)	Q4
		ON Q1.order_id = Q4.customer_id	
		INNER JOIN
		(
			SELECT $customer_meta.post_id AS customer_id, $customer_meta.meta_value AS last_name
			FROM $customer_meta
			WHERE $customer_meta.meta_key IN ('_billing_last_name')
		)	Q5	
		ON Q1.order_id = Q5.customer_id	
		INNER JOIN
		(
			SELECT $order_meta.order_item_id AS item_id, $order_meta.meta_value AS qty
			FROM $order_meta
			WHERE $order_meta.meta_key IN ('_qty')
		)	Q6	
		ON Q1.location_id = Q6.item_id
		LEFT JOIN
		(	SELECT DISTINCT $order_data.ID AS ID, $order_data.post_excerpt AS customer_note
			FROM $order_data
		)	Q7
		ON Q1.order_id = Q7.ID

	");

	$season_results = $wpdb->get_results($sql_season);


// Weekly query
// (all orders with a composite data location of X. Product and Location is set via ACF on same page 15 week.
	if( $location_term ): 
		$sql_weekly = ( "
			
			SELECT DISTINCT Q2.composite_item, Q5.first_name, Q6.last_name, Q1.meta_value AS location, Q4.size, Q1.order_id, Q7.customer_note
			FROM
				(
					SELECT DISTINCT $order_items.order_id AS order_id, $order_items.order_item_id AS location_id, $order_meta.meta_key AS meta_key, $order_meta.meta_value AS meta_value
					FROM $order_items, $order_meta
					WHERE $order_items.order_item_id = $order_meta.order_item_id
					AND $order_meta.meta_value = '$weekly' 
				)	Q1
			INNER JOIN
				(
					SELECT DISTINCT $order_items.order_id AS order_id, $order_meta.order_item_id AS item_id, $order_meta.meta_value AS composite_item
					FROM $order_items, $order_meta
					WHERE $order_items.order_item_id = $order_meta.order_item_id
					AND $order_meta.meta_key = '_composite_item'	
				)	Q2
			ON Q1.order_id = Q2.order_id
			INNER JOIN
				(	SELECT DISTINCT $order_data.ID AS ID, $order_data.post_status AS post_status
					FROM $order_data
					WHERE $order_data.post_status = 'wc-processing'
				)	Q3
			ON Q1.order_id = Q3.ID	
			INNER JOIN
				(
					SELECT $order_meta.order_item_id AS item_id, $order_meta.meta_value AS size
					FROM $order_meta
					WHERE $order_meta.meta_key IN ('size')
				)	Q4	
			ON Q2.item_id = Q4.item_id		
			INNER JOIN
				(
					SELECT $customer_meta.post_id AS customer_id, $customer_meta.meta_value AS first_name
					FROM $customer_meta
					WHERE $customer_meta.meta_key IN ('_billing_first_name')
				)	Q5	
			ON Q1.order_id = Q5.customer_id	
			INNER JOIN
			(
				SELECT $customer_meta.post_id AS customer_id, $customer_meta.meta_value AS last_name
				FROM $customer_meta
				WHERE $customer_meta.meta_key IN ('_billing_last_name')
			)	Q6	
		ON Q1.order_id = Q6.customer_id	
		LEFT JOIN
		(	SELECT DISTINCT $order_data.ID AS ID, $order_data.post_excerpt AS customer_note
			FROM $order_data
		)	Q7
		ON Q1.order_id = Q7.ID
	

		");

		$weekly_results = $wpdb->get_results($sql_weekly);

	else:
	endif; 
// 15 week season    
?>

<div class="post-content">

	<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h2><?php the_title(); ?></h2>
	<p>BIGGER bounties are in CLEAR BAGS<br />
	SMALLER bounties are in WHITE BAGS</p>
	<table class="table" data-sorting="true" data-filtering="true">
		<thead>
			<tr>
				<th data-breakpoints="xs sm md lg" data-type="number">Order ID</th>
				<th data-type="date" data-format-string="MMMM Do YYYY" data-breakpoints="xs sm md lg">Order Date</th>
				<th>Customer Name</th>
				<th>Size</th>
				<th data-breakpoints="xs sm">Qty</th>
				<th data-breakpoints="xs sm" width="50%">Purchase Note</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			foreach ($season_results as $seasonal_order) {		
				$size = $seasonal_order->size;
		
				$seasonal_count++;	
				
				if ($size == 'Bigger') {
					$seasonal_count_bigger++;
				}

				if ($size == 'Smaller') {
					$seasonal_count_smaller++;
				}				
				?>
				<tr>
					<td><?php echo $seasonal_order->order_id; ?></td>
					<td><?php echo $seasonal_order->order_date; ?></td>
					<td>
						<?php echo $seasonal_order->first_name; ?>
						<?php echo $seasonal_order->last_name; ?>
					</td>
					<td><?php echo $seasonal_order->size; ?></td>
					<td><?php echo $seasonal_order->qty; ?></td>
					<td><?php echo $seasonal_order->customer_note; ?></td>
				</tr>
			<?php } ?>	
		</tbody>
	</table>

	<section id="week-select">
		<select>
			<option>Choose Week</option>
			<option value="week1" <?php weekCheck("January 1", $week2_row['week']); ?>>Week One</option>
			<option value="week2" <?php weekCheck($week1_row['week'], $week2_row['week']); ?>>Week Two</option>
			<option value="week3" <?php weekCheck($week2_row['week'], $week3_row['week']); ?>>Week Three</option>
			<option value="week4" <?php weekCheck($week3_row['week'], $week4_row['week']); ?>>Week Four</option>
			<option value="week5" <?php weekCheck($week4_row['week'], $week5_row['week']); ?>>Week Five</option>
			<option value="week6" <?php weekCheck($week5_row['week'], $week6_row['week']); ?>>Week Six</option>
			<option value="week7" <?php weekCheck($week6_row['week'], $week7_row['week']); ?>>Week Seven</option>
			<option value="week8" <?php weekCheck($week7_row['week'], $week8_row['week']); ?>>Week Eight</option>
			<option value="week9" <?php weekCheck($week8_row['week'], $week9_row['week']); ?>>Week Nine</option>
			<option value="week10" <?php weekCheck($week9_row['week'], $week10_row['week']); ?>>Week Ten</option>
			<option value="week11" <?php weekCheck($week10_row['week'], $week11_row['week']); ?>>Week Eleven</option>
			<option value="week12" <?php weekCheck($week11_row['week'], $week12_row['week']); ?>>Week Twelve</option>
			<option value="week13" <?php weekCheck($week12_row['week'], $week13_row['week']); ?>>Week Thirteen</option>
			<option value="week14" <?php weekCheck($week13_row['week'], $week14_row['week']); ?>>Week Fourteen</option>
			<option value="week15" <?php weekCheck($week14_row['week'], $week15_row['week']); ?>>Week Fifteen</option>
		</select>
	</section>

<!-- Begin Weekly -->
	<?php 
	//Create an Array for each week title. Foreach array item, run loop, with array item (week title) as argument in function.
	// TODO: These should be combined with the above select as a multidimensional array. 
	// TODO: The composite product names should be spelled out in full, to match up with the ACF output.

	$week_in_season = 0;

	foreach ($pickup_weeks as $component_id => $component_data ) {
		$weekly_count = 0;
		$weekly_count_bigger = 0;
		$weekly_count_smaller = 0;
		$week_in_season++;
		?>
		<section class="week week<?php echo $week_in_season ?>">
			<table class="table footable" data-sorting="true">
				<thead>
					<tr>
						<th colspan="4"><h3>Week to week - <?php echo $component_data['title']; ?></h3></th>
					</tr>
					<tr>
						<th data-breakpoints="xs sm md lg" data-type="number">Order ID</th>
						<th data-type="date" data-format-string="MMMM Do YYYY" data-breakpoints="xs sm md lg">Order Date</th>
						<th>Customer Name</th>
						<th>Size</th>
						<th data-breakpoints="xs sm" width="50%">Purchase Note</th>
					</tr>
				</thead>
				<tbody>
					<?php				
				
					foreach ($weekly_results as $weeklyorder) {	
					
						$composite_id = $weeklyorder->composite_item;
						$size = $weeklyorder->size;

						if ($component_id == $composite_id) {	
							//Countin'
							$weekly_count++;	
							
							if ($size == 'Bigger') {
								$weekly_count_bigger++;
							}
							if ($size == 'Smaller') {
								$weekly_count_smaller++;
							}
							
					?>
							<tr>
								<td>
									<?php echo $weeklyorder->order_id; ?> 
								</td>
								<td>
									<?php //echo $order->order_date; ?>
								</td>
								<td>
									<?php echo $weeklyorder->first_name; ?>
									<?php echo $weeklyorder->last_name; ?>
									
									<?php
									if( $weeklyorder->customer_note ): 				
										echo '<span>*</span>';
									endif; 
									?>
								</td>
								<td>
									<?php echo $weeklyorder->size; ?>
								</td>
								<td>
									<?php echo $weeklyorder->customer_note; ?>					
								</td>
							</tr>								
						<?php } ?>
					<?php }?>		
				</tbody>
			</table>
		</section>
		<section class="count_box week week<?php echo $week_in_season ?>">
	<?php
		$total_bigger = $seasonal_count_bigger + $weekly_count_bigger;
		$total_smaller = $seasonal_count_smaller + $weekly_count_smaller;
		$total = $total_bigger + $total_smaller;
		?>
	<ul>
		<li><strong><?php echo $component_data['title']; ?> Total:</strong> <?php echo $total; ?></li>
		<li><strong>Bigger:</strong> <?php echo $total_bigger; ?></li>
		<li><strong>Smaller:</strong> <?php echo $total_smaller; ?></li>
	</ul>

</section>
	<?php
}?>
</article>
</div>
<script>
	(function ($) {
		$('table').footable();
	})(jQuery);
</script>