<?php
/*
Template Name: Lists Count
*/
?>

<?php 
	if(is_page_template('page-lists-home.php')) {
		get_header('lists');
	}
	else {
		get_header();
	}
	require_once('list_functions.php');
?>
 
<div class="post-content">
	<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2>Packing Lists</h2>
		<p>All locations receive 2 extra bigger bags except Schools and office locations</p>
		<table class="table" data-sorting="true" data-filtering="true">
			<thead>
				<tr>
					<th>Location</th>
					<th>Bigger</th>
					<th>Smaller</th>
					<th>Total (15wk)</th>
				</tr>	
			</thead>
			<tbody>
				<?php
				
					global $wpdb, $woocommerce;
				
					$order_items = 'wp_woocommerce_order_items';
					$order_meta = 'wp_woocommerce_order_itemmeta';
					$customer_data = $wpdb->prefix . 'postmeta';
					$order_data = $wpdb->prefix . 'posts';
					$product_season = new WC_Product(5958);
					$school_season = new WC_Product(19589);						
					$weekly_orders = new WC_Product(5982);						

					$locations = get_post_meta($product_season->id, '_product_attributes', true);						
					$school_locations = get_post_meta($school_season->id, '_product_attributes', true);						
					$weekly_locations_names = wc_get_product_terms( $weekly_orders->id, 'pa_pickup-location');

					$weekly_locations = wc_get_product_terms( $weekly_orders->id, 'pa_pickup-location', array( 'fields' => 'slugs' ));
					$locations = explode(' | ', $locations['location']['value']);
					$school_locations = explode(' | ', $school_locations['location']['value']);
						
					$sql_str = '';

					foreach ($locations as $location) {
						$sql_str = ( "
							SELECT COUNT(Q2.bigger_count) AS bigger_count, COUNT(Q3.smaller_count) AS smaller_count, COUNT(Q1.order_id) AS total_count
							FROM		
								(	SELECT order_id, $order_items.order_item_id AS order_item_id, $order_meta.meta_key, $order_meta.meta_value AS location_value
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND $order_meta.meta_value = '$location'
									AND $order_items.order_item_name LIKE 'CSA 2018 - 15 week%'
								) Q1
							LEFT JOIN
								(	SELECT order_id, $order_items.order_item_id, $order_meta.meta_key, $order_meta.meta_value AS bigger_count
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND meta_key IN ('size')
									AND $order_meta.meta_value = 'bigger'
								)	Q2
							ON Q1.order_id = Q2.order_id
							LEFT JOIN
								(	SELECT order_id, $order_items.order_item_id, $order_meta.meta_key, $order_meta.meta_value AS smaller_count
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND meta_key IN ('size')
									AND $order_meta.meta_value = 'smaller'
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
							<td>0</td>
							<td>1</td>
							<td>1</td>
						</tr>
						<tr>
							<td><h4><strong>Totals</strong></h4></td>
							<td>Bigger: <?php echo( $bigger_count ); ?></td>
							<td>Smaller: <?php echo( $smaller_count ); ?></td>
							<td>Total: <?php echo( $bigger_count + $smaller_count ); ?></td>
						</tr>	
					<tr>
							<td colspan="4" align="center"><strong>School CSA</strong></td>
						</tr>
					<?php foreach ($school_locations as $school_location) {

						$sql_str2 = ( "
							SELECT COUNT(Q2.bigger_count) AS bigger_count, COUNT(Q3.smaller_count) AS smaller_count, COUNT(Q1.order_id) AS total_count 
							FROM
								(	SELECT order_id, $order_items.order_item_id AS order_item_id, $order_meta.meta_key, $order_meta.meta_value AS location_value
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND $order_meta.meta_value = '$school_location'
									AND $order_items.order_item_name = 'School CSA'
								) Q1
							LEFT JOIN
								(	SELECT order_id, $order_items.order_item_id, $order_meta.meta_key, $order_meta.meta_value AS bigger_count
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND meta_key IN ('size')
									AND $order_meta.meta_value = 'bigger'
								)	Q2
							ON Q1.order_id = Q2.order_id
							LEFT JOIN
								(	SELECT order_id, $order_items.order_item_id, $order_meta.meta_key, $order_meta.meta_value AS smaller_count
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND meta_key IN ('size')
									AND $order_meta.meta_value = 'smaller'
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
						
						$school_count_results = $wpdb->get_results($sql_str2);					
						$school_row = $school_count_results[0];

						$school_count_bigger += $school_row->bigger_count;
						$school_count_smaller += $school_row->smaller_count;

						?>
						<tr>
							<td><strong><?php echo "$school_location"; ?></strong></td>
							<td><?php echo($school_row->bigger_count); ?></td>
							<td><?php echo($school_row->smaller_count); ?></td>
							<td><?php echo($school_row->total_count); ?></td>
						</tr>
				<?php } ?>	
				<tr>
					<td><h4><strong>School Totals</strong></h4></td>
					<td>Bigger: <?php echo( $school_count_bigger ); ?></td>
					<td>Smaller: <?php echo( $school_count_smaller ); ?></td>
					<td>Total: <?php echo( $school_count_bigger + $school_count_smaller ); ?></td>
				</tr>					 
			</tbody>		
		</table>

	<section id="week-select">
		<select>
			<option>Choose Week</option>
			<option value="week1" <?php weekCheck("January 1", $week2_row['week']); ?>>Week One</option>
			<option value="week2" <?php weekCheck($week1_row['week'], $week3_row['week']); ?>>Week Two</option>
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

		<?php 
		//Weekly count

		$week_in_season = 0;
		foreach ($pickup_weeks as $component_id => $component_data ) { 

		$week_in_season++ ?>

			<table class="table footable week week<?php echo $week_in_season; ?>">
				<thead>
					<tr>
						<th colspan="3"><h3><?php echo $component_data['title']; ?></h3></th>
					</tr>
					<tr>
						<th>Location</th>
						<th>Bigger</th>
						<th>Smaller</th>
					</tr>
				</thead>
				<tbody>
			<?php
			$sql_weekly = ( "
				
				SELECT DISTINCT Q2.composite_item, Q1.meta_value AS location, Q4.size, Q1.order_id
				FROM
					(
						SELECT $order_items.order_id AS order_id, $order_items.order_item_id AS location_id, $order_meta.meta_key AS meta_key, $order_meta.meta_value AS meta_value
						FROM $order_items, $order_meta
						WHERE $order_items.order_item_id = $order_meta.order_item_id
						AND $order_meta.meta_key IN ('pa_pickup-location') 
					)	Q1
				INNER JOIN
					(
						SELECT DISTINCT $order_items.order_id AS order_id, $order_meta.order_item_id AS item_id, $order_meta.meta_value AS composite_item
						FROM $order_items, $order_meta
						WHERE $order_items.order_item_id = $order_meta.order_item_id
						AND $order_meta.meta_key = '_composite_item'
						AND $order_meta.meta_value = '$component_id'
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

			");
			$weekly_results = $wpdb->get_results($sql_weekly); ?>
						
			<?php

			$weekly_count_bigger = 0;
			$weekly_count_smaller = 0;

			foreach ($weekly_locations as $weekly_location) { ?>				
				
				<?php 
				$weekly_count = 0;
				$weekly_location_count_bigger = 0;
				$weekly_location_count_smaller = 0;				
				
				foreach ($weekly_results as $weekly_result) {

					$weekly_result_location = $weekly_result->location;
					$weekly_result_component = $weekly_result->composite_item;

					$size = $weekly_result->size;

						if ($weekly_result_location == $weekly_location && $component_id == $weekly_result_component) { 

							//Countin'
							$weekly_count++;	
														
							if ($size == 'Bigger') {
								$weekly_count_bigger++;
								$weekly_location_count_bigger++;
							}
							elseif ($size == 'Smaller') {
								$weekly_count_smaller++;
								$weekly_location_count_smaller++;
							}
							else {
								//nothin
							}							
						}								
				}
				?>
				<tr>
					<td><?php echo $weekly_location; ?></td>
					<td><?php echo $weekly_location_count_bigger; ?></td>
					<td><?php echo $weekly_location_count_smaller; ?></td>
				</tr>
				<?php					
			} ?>
				<tr>
					<td><strong>Total:</strong></td>
					<td><?php echo $weekly_count_bigger; ?></td>
					<td><?php echo $weekly_count_smaller; ?></td>
				</tr>
			</tbody>
		</table>
		<div class="count_box week week<?php echo $week_in_season ?>">
			<ul>
				<li><strong>Bigger:</strong> <?php echo( $weekly_count_bigger + $school_count_bigger + $bigger_count ); ?></li>
				<li><strong>Smaller:</strong> <?php echo( $weekly_count_smaller + $school_count_smaller + $smaller_count ); ?> </li>
				<li><strong>Extras:</strong> 28</li>
				<li><strong>Total:</strong> <?php echo( $bigger_count + $smaller_count + $weekly_count_bigger + $weekly_count_smaller + $school_count_smaller + $school_count_bigger + 28 ); ?></li>
			</ul>
		</div>	
		<?php }
		?>	
	</article>
</div>		
<script>(function($) { $('table').footable(); })(jQuery);</script>