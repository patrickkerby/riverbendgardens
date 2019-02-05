<?php
/*
Template Name: Lists - Weekly
*/
?>

<?php 
if(is_page_template('page-lists-weekly.php')) {
 get_header('lists');
}
else {
 get_header();
}
	//Define variables for ACF fields
	$product = get_field('product');
	$product_title = $product->post_title;
	$product_id = $product->ID;
	$location_term = get_field('location');	
	$location_slug = $location_term->slug;
?>
<?php if( $location_term ): 		
	
	$location = $location_term->slug;
	else:
	$location = '%';
	
 endif; ?>

<div class="post-content">


<?php while ( have_posts() ) : ?>

	<?php the_post(); ?>
		<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h4><?php the_title(); ?> - <?php echo $product_title; ?></h4>
		<div class="post">
			<?php the_content(); ?>
		</div>
<?php endwhile; ?>
		<?php
		global $wpdb;
		
		$order_items = 'wp_woocommerce_order_items';
		$order_meta = 'wp_woocommerce_order_itemmeta';
		$customer_data = $wpdb->prefix . 'postmeta';
		
		$sql = ( "
		
			SELECT 
				Q1.order_id AS order_id,
				Q1b.meta_value AS serialized_composite, 
				Q2.meta_value AS size_value, 
				Q2b.meta_value AS location_value,
				Q3.meta_value AS customer_first_name, 
				Q4.meta_value AS customer_last_name, 
				Q5.meta_value AS paid_date, 
				Q5.post_id AS post_id
			FROM
				(	SELECT order_id, $order_meta.meta_key, $order_meta.meta_value
					FROM $order_items, $order_meta
					WHERE $order_items.order_item_id = $order_meta.order_item_id
					AND $order_meta.meta_key = '_product_id'
					AND $order_meta.meta_value = '$product_id'
				)	Q1
			INNER JOIN	
				(	SELECT order_id, $order_meta.meta_key, $order_meta.meta_value
					FROM $order_items, $order_meta
					WHERE $order_items.order_item_id = $order_meta.order_item_id
					AND $order_meta.meta_key = '_composite_data'
					GROUP BY order_id
				)	Q1b
			ON Q1.order_id = Q1b.order_id	
			INNER JOIN
				(	SELECT order_id, meta_key, meta_value 
					FROM $order_items, $order_meta
					WHERE $order_items.order_item_id = $order_meta.order_item_id
					AND $order_meta.meta_key IN ('size')
					GROUP BY order_id				
				)	Q2
			ON Q1.order_id = Q2.order_id
			INNER JOIN
				(	SELECT order_id, $order_meta.meta_key, $order_meta.meta_value 
					FROM $order_items, $order_meta
					WHERE $order_items.order_item_id = $order_meta.order_item_id
					AND $order_meta.meta_key = 'pa_pickup-location'
					GROUP BY order_id				
				)	Q2b
			ON Q1.order_id = Q2b.order_id
			INNER JOIN
				(	SELECT meta_key, meta_value, post_id
					FROM $customer_data
					WHERE meta_key IN ('_billing_first_name')
				)	Q3
			ON Q1.order_id = Q3.post_id	
			INNER JOIN
				(	SELECT meta_key, meta_value, post_id
					FROM $customer_data
					WHERE meta_key IN ('_billing_last_name')
				)	Q4
			ON Q1.order_id = Q4.post_id	
			INNER JOIN
				(	SELECT post_id, meta_key, meta_value
					FROM $customer_data
					WHERE meta_key IN ('_paid_date')					
				)	Q5
			ON Q1.order_id = Q5.post_id				
			ORDER BY order_id
			LIMIT 800
			");
			$results = $wpdb->get_results($sql);
					
				   
		if ($results) {
		  echo '<table class="table footable" data-sorting="true" data-filtering="true">
		  			<thead>
		  				<tr>
		  					<th data-type="number" data-breakpoints="xs">Order ID</th>
		  					<th data-type="date" data-format-string="MMMM Do YYYY" data-breakpoints="xs sm md lg">Order Date</th>
		  					<th>Customer Name</th>
		  					<th>Location</th>
		  					<th data-breakpoints="xs">Size</th>
		  					<th>Weeks</th>
		  				</tr>	
		  			</thead>
		  			<tbody>';
		  foreach ($results as $row) { ?>

		<?php 
			$composite_array = unserialize($row->serialized_composite);
		?>

		    <tr>
			    <td><?php echo $row->order_id;?></td>
			    <td><?php echo $row->paid_date;?></td>
			    <td><?php echo $row->customer_first_name;?> <?php echo $row->customer_last_name;?></td>
			    <td><?php echo $row->location_value;?></td>
			    <td><?php echo $row->size_value;?></td>
			    <td>
				        
					<?php
						$count = 1;
						$weeks = array();
						foreach($composite_array as $comp) {
							if ($comp['attributes']) {
								$weeks[] = $count;
							}
							$count++;
						}
						
						echo implode(', ', $weeks);
						
	//					echo '<code>'; 
 	//					print_r($composite_array);
 	//					print_r($product_id);
 	//					echo '</code>';
					?>
							
			    </td>
		    </tr>
		        <?php } }
		  ?> </tbody>
		</table>
	</article>
</div>		
		
<script>(function($) {
    $('table').footable();
})(jQuery);
</script>
