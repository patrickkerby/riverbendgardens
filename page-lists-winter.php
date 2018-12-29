<?php
/*
Template Name: Lists Count - Winter
*/

// ------------------------- Begin Page Layout -------------------------    

require_once('list_functions.php');

if(is_page_template('page-lists-winter.php')) {
	get_header('lists');
}
else {
	get_header();
}

global $wpdb, $woocommerce;

$order_items = 'wp_woocommerce_order_items';
$order_meta = 'wp_woocommerce_order_itemmeta';
$customer_data = $wpdb->prefix . 'postmeta';

$order_data = $wpdb->prefix . 'posts';

$winter_orders = new WC_Product(5484);						

$winter_locations = get_post_meta($winter_orders->id, '_product_attributes', true);						
$winter_locations = explode(' | ', $winter_locations['location']['value']);
// Remove apostrophes from location name, so the SQL doesn't choke
$remove[] = "'";
$winter_locations = str_replace( $remove, "''", $winter_locations );

$sql_str = '';
?>

<div class="post-content">
	<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2>Winter Packing Lists</h2>
		<p>All locations receive 1 extra bigger bag except schools and office locations.</p>		
		<p>Bonton should actually be: B-3 S-16</p>
		<p>ECS should be: B-3 S-11</p>
		<table class="table" data-sorting="true" data-filtering="true">
			<thead>
				<tr>
					<th>Location</th>
					<th>Bigger</th>
					<th>Smaller</th>
					<th>Total</th>
				</tr>	
			</thead>
			<tbody>
				<?php									
				
					foreach ($winter_locations as $location) {						
						$sql_str = ( "
							SELECT COUNT(Q2.bigger_count) AS bigger_count, COUNT(Q3.smaller_count) AS smaller_count, COUNT(Q1.order_id) AS total_count
							FROM		
								(	SELECT order_id, $order_items.order_item_id AS order_item_id, $order_meta.meta_key, $order_meta.meta_value AS location_value
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND $order_meta.meta_value = '$location'
									AND $order_items.order_item_name LIKE 'Winter CSA%'
								) Q1
							LEFT JOIN
								(	SELECT order_id, $order_items.order_item_id, $order_meta.meta_key, $order_meta.meta_value AS bigger_count
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND meta_key IN ('size')
									AND $order_meta.meta_value LIKE 'bigger'
								)	Q2
							ON Q1.order_id = Q2.order_id
							LEFT JOIN
								(	SELECT order_id, $order_items.order_item_id, $order_meta.meta_key, $order_meta.meta_value AS smaller_count
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND meta_key IN ('size')
									AND $order_meta.meta_value LIKE 'smaller'
								)	Q3
							ON Q1.order_id = Q3.order_id
							RIGHT JOIN
							(	SELECT id, post_status
								FROM $order_data
								WHERE $order_data.post_status = 'wc-processing'
							)	Q4
							ON Q1.order_id = Q4.id
							ORDER BY location_value			 
						");
						
						$count_results = $wpdb->get_results($sql_str);
						
						$row = $count_results[0];
						
						$bigger_count += $row->bigger_count;
						$smaller_count += $row->smaller_count;
												
						?>
						<tr>
							<td><strong><?php echo "$location"; ?></strong></td>
							<td><?php echo($row->bigger_count); ?></td>
							<td><?php echo($row->smaller_count); ?></td>
							<td><?php echo($row->total_count); ?></td>
						</tr>					
					<?php } ?>

						<tr>
							<td><strong>Farm Pickup</strong></td>
							<td>1</td>
							<td>0</td>
							<td>1</td>
						</tr>

						<tr>
							<td><h4><strong>Totals</strong></h4></td>
							<td>Bigger: <?php echo( $bigger_count ); ?></td>
							<td>Smaller: <?php echo( $smaller_count ); ?></td>
							<td>Total: <?php echo( $bigger_count + $smaller_count ); ?></td>
						</tr>	
			</tbody>		
		</table>



		<div class="count_box week week<?php echo $week_in_season ?>">
			<ul>
				<li><strong>Bigger:</strong> <?php echo( $bigger_count + 1 ); ?></li>
				<li><strong>Smaller:</strong> <?php echo($smaller_count ); ?> </li>
				<li><strong>Extras:</strong> 7</li>
				<li><strong>Total:</strong> <?php echo( $bigger_count + $smaller_count + 7 ); ?></li>
			</ul>
		</div>	
	</article>
</div>		
<script>(function($) { $('table').footable(); })(jQuery);</script>