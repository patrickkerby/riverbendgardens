{{--
  Template Name: Lists Index
--}}

@extends('layouts.app')

{{-- @include('partials.list-functions') --}}

@php



//List of global variables
$pickup_weeks = get_post_meta(59432, '_bto_data', true); // This gets all the composite weeks by component ID! This is special.


function weekCheck($prevWeek, $nextWeek) {
    // Check current date, set select value to selected if current date is between week x and y.
    // Function arguments are supplied by ACF in Ymd format

    $currentDate = date('Ymd');
    $currentDate=date('Ymd', strtotime($currentDate));;

    $weeklyDateBegin = date('Ymd', strtotime("$prevWeek"));
    $weeklyDateEnd = date('Ymd', strtotime("$nextWeek"));

    if (($currentDate > $weeklyDateBegin) && ($currentDate <= $weeklyDateEnd))
    {
    echo "selected";
    }
    else
    {
    //nothin
    }
}

// ------------------------- Get pickup dates for current year, set in Global Options -------------------------    
// TODO: see if these dates can be provided on composite product item _rather_ than global options.

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


// Get current week of the year, check if it's even or odd. Biweekly only delivers on odd weeks.
$currentWeek = date('W');

if($currentWeek&1){
	$displayBiwk = true;
}
elseif($currentWeek = 26) {
	$displayBiwk = true;
}
	else{
	$displayBiwk = false;
}
@endphp

@section('content')
{{-- In order for this year selector to work, the "processing" status in the SQL needs to be removed. --}}
<form action="" method="post" target="_self">
	<label for="year">Year:</label>
	<select id="year" name="year">
		<option value="CSA 2020 - 15 week">2020</option>
		<option value="CSA 2019 - 15 week">2019</option>
		<option value="CSA 2018 - 15 week">2018</option>
		<option value="CSA 2017 - 15 week">2017</option>
		<option value="CSA 2016 - 15 week">2016</option>
		<option value="CSA 2015 - 15 week">2015</option>
	</select>
	<input type="submit" value="Go">
</form>

@php
	$year = "CSA 2020 - 15 week";

	if ( isset( $_POST['year'] ) ) { 
		$year = $_POST['year'];							
	} 
	else {
		$year = "CSA 2020 - 15 week";
	}

@endphp

<script type="text/javascript">
	( function($) {
		$(document).ready(function(){
			$("select").change(function(){
					$(this).find("option:selected").each(function(){
							var optionValue = $(this).attr("value");
							if(optionValue){
									$(".week").not("." + optionValue).hide();
									$("." + optionValue).show();
							} else{
									$(".week").hide();
							}
					});
			}).change();

			$('.table').footable();

		});
	} ) ( jQuery );
</script>

<div class="post-content">
	<article>
		<section>
			<h2>Packing Lists - {{ $year }}</h2>
			<p>All locations receive 2 extra bigger bags except Schools and office locations</p>
			<p>** give ACME 1 more smaller than is displayed</p>
			<table class="table footable" data-sorting="true">
				<thead>
					<tr>
						<th scope="col">Location</th>
						<th data-type="number" scope="col">Bigger</th>
						<th data-type="number" scope="col">Smaller</th>
						<th data-type="number" scope="col">Total (15wk)</th>
					</tr>	 
				</thead>
				<tbody>
					@php
					
						global $wpdb, $woocommerce;
					
						$order_items = 'wp_woocommerce_order_items';
						$order_meta = 'wp_woocommerce_order_itemmeta';
						$order_data = $wpdb->prefix . 'posts';
						$customer_data = $wpdb->prefix . 'postmeta';
						$order_data = $wpdb->prefix . 'posts';
            $product_season = wc_get_product( 5958 );
						$weekly_orders = wc_get_product(5982);	
						$bi_weekly_orders = wc_get_product(87354);						

						$locations = get_post_meta($product_season->get_id(), '_product_attributes', true);						
						$locations = explode(' | ', $locations['location']['value']);

						$weekly_locations_names = wc_get_product_terms( $weekly_orders->get_id(), 'pa_pickup-location');
						$weekly_locations = wc_get_product_terms( $weekly_orders->get_id(), 'pa_pickup-location', array( 'fields' => 'slugs' ));

						$biweekly_locations_names = wc_get_product_terms( $bi_weekly_orders->get_id(), 'pa_pickup-location');
						$biweekly_locations = wc_get_product_terms( $bi_weekly_orders->get_id(), 'pa_pickup-location', array( 'fields' => 'slugs' ));
										
						$bigger_count = 0;
						$smaller_count = 0; 
						$total_biwk_sum = 0;
												
						$sql_str = '';
						$sql_str_biwk = '';

						@endphp
						@foreach($locations as $location)
							@php
							$sql_str = ( "
								SELECT COUNT(Q2.bigger_count) AS bigger_count, COUNT(Q3.smaller_count) AS smaller_count, COUNT(Q1.order_id) AS total_count
								FROM		
									(	SELECT order_id, $order_items.order_item_id AS order_item_id, $order_meta.meta_key, $order_meta.meta_value AS location_value
										FROM $order_items, $order_meta
										WHERE $order_items.order_item_id = $order_meta.order_item_id
										AND $order_meta.meta_value = '$location'
										AND $order_items.order_item_name LIKE '$year%'
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
								INNER JOIN
									(	SELECT DISTINCT $order_data.ID AS ID, $order_data.post_status AS post_status
										FROM $order_data
										WHERE $order_data.post_status = 'wc-processing'
									)	Q4
								ON Q1.order_id = Q4.ID
								
								ORDER BY location_value			 
							");
							
							$count_results = $wpdb->get_results($sql_str);
													
							$row = $count_results[0];
							
							$bigger_count += $row->bigger_count;
							$smaller_count += $row->smaller_count;
							$total_15wk_count = $smaller_count + $bigger_count;
													
							@endphp
							<tr>
								<td><strong>{{ $location }}</strong></td>
								<td data-sort-value="{{ $row->bigger_count }}">{{ $row->bigger_count }}</td>
								<td data-sort-value="{{ $row->smaller_count }}">{{ $row->smaller_count }}</td>
								<td data-sort-value="{{ $row->total_count }}">{{ $row->total_count }}</td>
							</tr>					
						@endforeach							
						</tbody>
						<tfoot>
							<tr>
								<th scope="row"><strong>Totals</strong></th>
								<td>Bigger: {{ $bigger_count }}</td>
								<td>Smaller: {{ $smaller_count }}</td>
								<td>Total: {{ $total_15wk_count }}</td>
							</tr>
						</tfoot>						
				</table>
		</section>
		@if ($displayBiwk)  
		<section>
			<h2>Bi-weekly</h2>
		
			<table class="table footable" data-sorting="true">
				<thead>
					<tr>
						<th scope="col">Location</th>
						<th data-type="number" scope="col">Total Bigger </th>
					</tr>	 
				</thead>
				<tbody>
				@foreach ($biweekly_locations as $bi_wk_location)
					@php
						$sql_str_biwk = ( "
							SELECT COUNT(Q1.order_id) AS total_count
							FROM		
								(	SELECT order_id, $order_items.order_item_id AS order_item_id, $order_meta.meta_key, $order_meta.meta_value AS location_value
									FROM $order_items, $order_meta
									WHERE $order_items.order_item_id = $order_meta.order_item_id
									AND $order_meta.meta_value = '$bi_wk_location'
									AND $order_items.order_item_name LIKE 'Bi-Weekly CSA%'
								) Q1							
							INNER JOIN
								(	SELECT DISTINCT $order_data.ID AS ID, $order_data.post_status AS post_status
									FROM $order_data
									WHERE $order_data.post_status = 'wc-processing'
								)	Q4
							ON Q1.order_id = Q4.ID
							
							ORDER BY location_value			 
						");
						
						$bi_wk_count_results = $wpdb->get_results($sql_str_biwk);
												
						$biwk_row = $bi_wk_count_results[0];											
						$biwk_total_count = $biwk_row->total_count;

						$total_biwk_sum += $biwk_row->total_count;

					@endphp
						
						<tr>
							<td><strong>{{ $bi_wk_location }}</strong></td>
							<td data-sort-value="{{ $biwk_total_count }}">{{ $biwk_total_count }}</td>
						</tr>		
						
					@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th scope="row"><strong>Totals</strong></th>
								<td>Total Bigger: {{ $total_biwk_sum }}</td>
							</tr>
						</tfoot>						
				</table>
		</section>
		@endif

		<section id="week-select">
			<select>
				<option>Choose Week</option>
				<option value="week1" @php weekCheck("January 1", $week2_row['week']); @endphp>Week One</option>
				<option value="week2" @php weekCheck($week1_row['week'], $week3_row['week']); @endphp>Week Two</option>
				<option value="week3" @php weekCheck($week2_row['week'], $week3_row['week']); @endphp>Week Three</option>
				<option value="week4" @php weekCheck($week3_row['week'], $week4_row['week']); @endphp>Week Four</option>
				<option value="week5" @php weekCheck($week4_row['week'], $week5_row['week']); @endphp>Week Five</option>
				<option value="week6" @php weekCheck($week5_row['week'], $week6_row['week']); @endphp>Week Six</option>
				<option value="week7" @php weekCheck($week6_row['week'], $week7_row['week']); @endphp>Week Seven</option>
				<option value="week8" @php weekCheck($week7_row['week'], $week8_row['week']); @endphp>Week Eight</option>
				<option value="week9" @php weekCheck($week8_row['week'], $week9_row['week']); @endphp>Week Nine</option>
				<option value="week10" @php weekCheck($week9_row['week'], $week10_row['week']); @endphp>Week Ten</option>
				<option value="week11" @php weekCheck($week10_row['week'], $week11_row['week']); @endphp>Week Eleven</option>
				<option value="week12" @php weekCheck($week11_row['week'], $week12_row['week']); @endphp>Week Twelve</option>
				<option value="week13" @php weekCheck($week12_row['week'], $week13_row['week']); @endphp>Week Thirteen</option>
				<option value="week14" @php weekCheck($week13_row['week'], $week14_row['week']); @endphp>Week Fourteen</option>
				<option value="week15" @php weekCheck($week14_row['week'], $week15_row['week']); @endphp>Week Fifteen</option>
			</select>
		</section>

			@php 
			//Weekly count
			$week_in_season = 0;
			foreach ($pickup_weeks as $component_id => $component_data ) { 

			$week_in_season++ @endphp

			<section class="week week@php echo $week_in_season @endphp">

				<table class="table footable" data-sorting="true">
					<thead>
						<tr>
							<th colspan="3"><h2>@php echo $component_data['title']; @endphp</h2></th>
						</tr>
						<tr>
							<th>Location</th>
							<th>Bigger</th>
							<th>Smaller</th>
						</tr>
					</thead>
					<tbody>
				
						@php
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
				$weekly_results = $wpdb->get_results($sql_weekly); @endphp
							
				@php

				$weekly_count_bigger = 0;
				$weekly_count_smaller = 0;

				foreach ($weekly_locations as $weekly_location) { @endphp				
					
					@php 
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
					@endphp
					<tr>
						<td>@php echo $weekly_location; @endphp</td>
						<td>@php echo $weekly_location_count_bigger; @endphp</td>
						<td>@php echo $weekly_location_count_smaller; @endphp</td>
					</tr>
					@php					
				} @endphp
				</tbody>
					
				</tbody>
				<tfoot>
					<tr>
						<th scope="row"><strong>Total:</strong></th>
						<td>@php echo $weekly_count_bigger; @endphp</td>
						<td>@php echo $weekly_count_smaller; @endphp</td>
					</tr>
				</tfoot>
			</table>
			</section>
			<div class="count_box week week{{ $week_in_season }}">
				<h4>This week's totals:</h4>
				<ul>
					<li><strong>Bigger:</strong> @php echo( $weekly_count_bigger + $bigger_count + $total_biwk_sum ); @endphp</li>
					<li><strong>Smaller:</strong> @php echo( $weekly_count_smaller + $smaller_count ); @endphp </li>
					<li><strong>Extras:</strong>  28</li>
					<li><strong>Total:</strong> @php echo( $bigger_count + $smaller_count + $weekly_count_bigger + $weekly_count_smaller + $total_biwk_sum + 28 ); @endphp</li>
				</ul>
			</div>
			@php }
			@endphp	
		</section>
	</article>
</div>
@endsection