{{--
  Template Name: Delivery List
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

$year = "CSA 2019 - 15 week";
$school = "School CSA";
$late_season = "Late Season CSA"

@endphp

@section('content')

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
  <article id="page-@php the_ID(); @endphp" @php post_class(); @endphp>
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
  $week_in_season = 0;
  foreach ($pickup_weeks as $component_id => $component_data ) { 
    $week_in_season++;   
@endphp
    <section class="week week@php echo $week_in_season @endphp">
      <h2>@php echo $component_data['title']; @endphp</h2>
      <p>Clear = Bigger  /  White = Smaller.<br /> These numbers <em>include</em> weeklys and extras.</p>
		
			<table class="table footable">
				<thead>
          <tr>
            <th>Delivery Time</th>
						<th scope="col">Location</th>
            <th data-type="number" scope="col">Clear Bags</th>
            <th data-type="number" scope="col">Clear Crates</th>
            <th data-type="number" scope="col">White Bags</th>
            <th data-type="number" scope="col">White Crates</th>
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
						$school_season = wc_get_product(19589);						
            $weekly_orders = wc_get_product(5982);	

            // Delete maybe? ----------
                $school_locations = get_post_meta($school_season->get_id(), '_product_attributes', true);						
                $weekly_locations_names = wc_get_product_terms( $weekly_orders->get_id(), 'pa_pickup-location');
                // $weekly_locations = wc_get_product_terms( $weekly_orders->get_id(), 'pa_pickup-location', array( 'fields' => 'slugs' ));                
            // -----------------

            $bigger_count = 0;
            $smaller_count = 0;  

            $weekly_count_bigger = 0;
            $weekly_count_smaller = 0;
            
            $bigger_count_total = 0;
            $smaller_count_total = 0;
            $smaller_crates_total = 0;
            $bigger_crates_total = 0;
        
        
            // get delivery route locations
    
            if( have_rows('select_locations') ):
              while( have_rows('select_locations') ): the_row(); 

                // vars
                $route_location = get_sub_field('location');
                $custom_location_name = get_sub_field('custom_location_name');
                $delivery_time = get_sub_field('delivery_time');
                $extras = get_sub_field('extras');
                $weekly_count = 0;
                $weekly_location_count_bigger = 0;
                $weekly_location_count_smaller = 0;	

                if($route_location):
                  $delivery_location = $route_location->name;
                  $weekly_location = $route_location->slug;
                elseif($custom_location_name): 
                  $delivery_location = get_sub_field('custom_location_name');
                endif;

                // if($extras):
                //   $extras = '2';
                // else:
                //   $extras = '0';
                // endif;
                
                $sql_str = '';
                $sql_str = ( "
                  SELECT COUNT(Q2.bigger_count) AS bigger_count, COUNT(Q3.smaller_count) AS smaller_count, COUNT(Q1.order_id) AS total_count
                  FROM		
                    (	SELECT order_id, $order_items.order_item_id AS order_item_id, $order_meta.meta_key, $order_meta.meta_value AS location_value
                      FROM $order_items, $order_meta
                      WHERE $order_items.order_item_id = $order_meta.order_item_id
                      AND $order_meta.meta_value = '$delivery_location'
                      AND ($order_items.order_item_name LIKE '$year%' OR $order_items.order_item_name LIKE '$school')
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

					//Weekly
                // get weekly numbers
                    
                    $sql_weekly = '';
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
                    $weekly_results = $wpdb->get_results($sql_weekly); 

                    $weekly_count_bigger = 0;
                    $weekly_count_smaller = 0;

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
                  

                  $bigger_count = $row->bigger_count+$weekly_location_count_bigger;
                  $smaller_count = $row->smaller_count+$weekly_location_count_smaller;

                  $bigger_crates = $bigger_count/2;
                  $smaller_crates = $smaller_count/2; 

                @endphp
                <tr>
                  <td>{{ $delivery_time }}</td>
                  <td><strong>{{ $delivery_location }}</strong></td>
                  <td>{{ $bigger_count }}</td>
                  <td>{{ $bigger_crates }}</td>
                  <td>{{ $smaller_count }}</td>
                  <td>{{ $smaller_crates }}</td>
                </tr>
              
              @php

              $bigger_count_total += $bigger_count;
              $smaller_count_total += $smaller_count;
              $bigger_crates_total += $bigger_crates;  
              $smaller_crates_total += $smaller_crates;
              
            endwhile;
              
            endif;													
							@endphp																	
							
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2" scope="row"><strong>Totals</strong></td>
                <td><strong>{{ $bigger_count_total }}</strong></td>
                <td><strong>{{ $bigger_crates_total }}</strong></td>
                <td><strong>{{ $smaller_count_total }}</strong></td>
								<td><strong>{{ $smaller_crates_total }}</strong></td>
							</tr>
						</tfoot>						
        </table>		
      </section>

@php } @endphp
	</article>
</div>
@endsection