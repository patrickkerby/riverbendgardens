<?php
/*
Template Name: Lists - Winter
*/

// ------------------------- Begin Page Layout -------------------------    

require_once('list_functions.php');

if(is_page_template('page-lists-weeklywinter.php')) {
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
	$winter_location = get_field('select_location_winter');	

	if( $location_term ): 				
		$season = $location_term->name;
		$weekly = $location_term->slug;
	elseif ( $school_location ): 				
		$season = $school_location;
		$weekly = '';
	elseif ( $winter_location ): 				
		$season = $winter_location;
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
				AND $order_items.order_item_name LIKE 'Winter CSA%'
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
var_dump($season);
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


<section class="count_box week week<?php echo $week_in_season ?>">
	<?php
		$total_bigger = $seasonal_count_bigger;
		$total_smaller = $seasonal_count_smaller;
		$total = $total_bigger + $total_smaller;
		?>
	<ul>
		<li><strong><?php echo $component_data['title']; ?> Total:</strong> <?php echo $total; ?></li>
		<li><strong>Bigger:</strong> <?php echo $total_bigger; ?></li>
		<li><strong>Smaller:</strong> <?php echo $total_smaller; ?></li>
	</ul>

</section>
	
</article>
</div>
<script>
	(function ($) {
		$('table').footable();
	})(jQuery);
</script>