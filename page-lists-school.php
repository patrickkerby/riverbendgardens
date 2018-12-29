<?php
/*
Template Name: Lists - School
*/
?>

<?php 
// ------------------------- Begin Page Layout -------------------------    

	if(is_page_template('page-lists-school.php')) {
		get_header('lists');
	}
	else {
		get_header();
	}

// ------------------------- Get location, set by ACF in page -------------------------

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

// ------------------------- Get pickup dates for current year, set in Global Options -------------------------    

$rows = get_field('pickup_dates','options' );

$week1_row = $rows[0];
$week1 = 'Week 1: ' . $week1_row['week'];

$week2_row = $rows[1];
$week2 = 'Week 2: ' . $week2_row['week'];

$week3_row = $rows[2];
$week3 = 'Week 3: ' . $week3_row['week'];

$week4_row = $rows[3];
$week4 = 'Week 4: ' . $week4_row['week'];

$week5_row = $rows[4];
$week5 = 'Week 5: ' . $week5_row['week'];

$week6_row = $rows[5];
$week6 = 'Week 6: ' . $week6_row['week'];

$week7_row = $rows[6];
$week7 = 'Week 7: ' . $week7_row['week'];

$week8_row = $rows[7];
$week8 = 'Week 8: ' . $week8_row['week'];

$week9_row = $rows[8];
$week9 = 'Week 9: ' . $week9_row['week'];

$week10_row = $rows[9];
$week10 = 'Week 10: ' . $week10_row['week'];

$week11_row = $rows[10];
$week11 = 'Week 11: ' . $week11_row['week'];

$week12_row = $rows[11];
$week12 = 'Week 12: ' . $week12_row['week'];

$week13_row = $rows[12];
$week13 = 'Week 13: ' . $week13_row['week'];

$week14_row = $rows[13];
$week14 = 'Week 14: ' . $week14_row['week'];

$week15_row = $rows[14];
$week15 = 'Week 15: ' . $week15_row['week'];  

// ------------------------- 15 week query -------------------------    
// (all orders with a location of X and a product of Y. Product and Location is set via ACF on a Page.

	global $wpdb;
	
	$order_items = 'wp_woocommerce_order_items';
	$order_meta = 'wp_woocommerce_order_itemmeta';
	
	$sql_season = ( "
		SELECT order_id, $order_items.order_item_id AS location_id, $order_meta.meta_key, $order_meta.meta_value
		FROM $order_items, $order_meta
		WHERE $order_items.order_item_id = $order_meta.order_item_id
		AND BINARY $order_meta.meta_value = '$season'
		AND $order_items.order_item_name LIKE '$product_title%'
	");

	$season_results = $wpdb->get_results($sql_season);

	// Create a list of IDs for full season orders. We use this later as a post__in argument to limit wp_query restuls
	foreach ($season_results as $key => $value) {
	    $season_array[] = $value->order_id;
	}

	// ------------------------- Weekly query -------------------------    
	// (all orders with a composite data location of X. Product and Location is set via ACF on same page 15 week.

	if( $location_term ): 
		$sql_weekly = ( "
			
			SELECT Q1.order_id, Q1.location_id, Q1.meta_key, Q1.meta_value, Q2.composite_data
			FROM
				(
					SELECT order_id, $order_items.order_item_id AS location_id, $order_meta.meta_key AS meta_key, $order_meta.meta_value AS meta_value
					FROM $order_items, $order_meta
					WHERE $order_items.order_item_id = $order_meta.order_item_id
					AND $order_meta.meta_value = '$weekly' 
				)	Q1
			LEFT JOIN
				(
					SELECT order_id, $order_items.order_item_id, $order_meta.meta_key, $order_meta.meta_value AS composite_data
					FROM $order_items, $order_meta
					WHERE $order_items.order_item_id = $order_meta.order_item_id
					AND BINARY meta_key IN ('_composite_data')
				)	Q2
			ON Q1.order_id = Q2.order_id		
		");

		$weekly_results = $wpdb->get_results($sql_weekly);

		// Create a list of IDs for weekly orders. We use this later as a post__in argument to limit wp_query results
		foreach ($weekly_results as $key => $value) {
		    $weekly_array[] = $value->order_id;
		}	
	else:
	endif; 

// ------------------------- 15 week season loop -------------------------    
	global $woocommerce;
		
	$args = array(
		'post_type'	=> 'shop_order',
		'posts_per_page' => -1,
		'post_status' => 'wc-processing',
		'post__in' => $season_array
	);

	$loop = new WP_Query( $args ); 
	$total_order_count_AMM = $loop->post_count;

?>

<div class="post-content">

	<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

	<h2><?php the_title(); ?> </h2>
	<p>Order count:<strong><?php echo $loop->post_count; ?></strong></p>
	<table class="table" data-sorting="true" data-filtering="true">
		<thead>
			<tr>
				<th data-breakpoints="xs sm md lg" data-type="number">Order ID</th>
				<th data-type="date" data-format-string="MMMM Do YYYY" data-breakpoints="xs sm md lg">Order Date</th>
				<th>Customer Name</th>
				<th>Location</th>
				<th>Size</th>
				<th>Length</th>
				<th>Qty</th>
				<th data-breakpoints="xs sm md lg" width="50%">Purchase Note</th>
			</tr>
		</thead>
		<tbody>
		<?php while ( $loop->have_posts() ) : $loop->the_post();
			$order_id = get_the_id();
			$order_meta = get_post_meta($order_id);
			$first_name = $order_meta['_billing_first_name'][0];
			$last_name = $order_meta['_billing_last_name'][0];
			$order = new WC_Order($order_id);
			$order_items = $order->get_items();
			foreach ($order->get_items('line_item') as $item) {}
		?>
			<tr>
				<td><?php echo $order_id; ?></td>
				<td><?php echo $order->order_date; ?></td>
				<td>
					<?php echo $first_name; ?>
					<?php echo $last_name; ?>
					<?php 
			    	if( $order->customer_note ): 				
						echo '<span>*</span>';
					endif; 
					?>
				</td>
				<td><?php echo $item['location']; ?></td>
				<td><?php echo $item['size']; ?></td>
				<td><?php echo $item['length']; ?></td>
				<td><?php echo $item['qty']; ?></td>
				<td><?php echo $order->customer_note; ?></td>
			</tr>
			<?php endwhile; ?>
		</tbody>
	</table>

	</article>
</div>
<script>
	(function ($) {
		$('table').footable();
	})(jQuery);
</script>