{{--
  Template Name: Lists Index
--}}

@extends('layouts.app')

{{-- @include('partials.list-functions') --}}
@php
//List of global variables
global $wpdb, $woocommerce;


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
  $currentCSAWeek = $currentWeek - 27;

  if ($currentCSAWeek === 0) {
    $currentCSAWeek = 1;
  }
  if($currentCSAWeek&1){
    $displayBiwk = true;
  }
  else{
    $displayBiwk = false;
  }

  if ( isset($_POST['week_selection']))  {
    $week_in_season = $_POST['week_selection'];
  }
  else {
    $week_in_season = 'week' . $currentCSAWeek;
  }

  $even_weeks = array("week2","week4","week6","week8","week10","week12","week14");
  $half_summer_weeks = array("week8","week9","week10","week11","week12","week13","week14");

  if (in_array($week_in_season, $even_weeks)) {
    $displayBiwk = false;
  }
  else {
    $displayBiwk = true;
  }

if (in_array($week_in_season, $half_summer_weeks)) {
    $displayHalfsummer = true;
  }
  else {
    $displayHalfsummer = false;
  }

  var_dump($week_in_season);

  $year = "CSA 2024 - 14 week";
  $late_season = "Late Season CSA";

  $bigger_count = 0;
  $smaller_count = 0;  

  $bigger_count_total = 0;
  $smaller_count_total = 0;
  $smaller_crates_total = 0;
  $bigger_crates_total = 0;
  $extras_count_total = 0;

////********** Query the orders! 
  $args = array(
      'orderby' => 'date',
      'order' => 'DESC',
      'limit' => 2000,
      'return' => 'ids',
      'type' => 'shop_order',
      'status' => array('wc-completed', 'wc-processing', 'wc-on-hold'),
      'date_created' => '2025-01-01...2025-07-31'
  );

  $product_id_15wk = '5958';
  $product_id_biwk = '87354';
  $product_id_lateseason = '5484';
  $product_id_fullyear = '103898';
  $product_id_halfsummer = '103905';

//first get all the order ids
  $query = new WC_Order_Query( $args );
  $order_ids = $query->get_orders();

  $filtered_order_ids_biwk = array();
  $filtered_order_ids_15wk = array();

@endphp

@section('content')

  <div class="post-content">

    <article id="page-@php the_ID(); @endphp" @php post_class(); @endphp>
      <section id="week-select" class="row">
        <form method="post" class="acf-form col-sm-4 offset-sm-8">
          <select name="week_selection" id="week_selection">
            <option>Change Week</option>
            <option value="week1">Week One</option>
            <option value="week2">Week Two</option>
            <option value="week3">Week Three</option>
            <option value="week4">Week Four</option>
            <option value="week5">Week Five</option>
            <option value="week6">Week Six</option>
            <option value="week7">Week Seven</option>
            <option value="week8">Week Eight</option>
            <option value="week9">Week Nine</option>
            <option value="week10">Week Ten</option>
            <option value="week11">Week Eleven</option>
            <option value="week12">Week Twelve</option>
            <option value="week13">Week Thirteen</option>
            <option value="week14">Week Fourteen</option>
            <option value="week15">Week Fifteen</option>
          </select>
          <input type="submit" class="acf-button button button-primary button-large" value="Update">
        </form>
      </section>
            
        <section class="week {{ $week_in_season }}">  
          <h2> 
            @switch($week_in_season)
              @case("week1")                  
                @php $weekDate = date('F d, Y', strtotime($week1_row['week'])); @endphp
                Week 1: {{ $weekDate }}
                @break

              @case("week2")
                @php $weekDate = date('F d, Y', strtotime($week2_row['week'])); @endphp
                Week 2: {{ $weekDate }}
                @break

                @case("week3")
                @php $weekDate = date('F d, Y', strtotime($week3_row['week'])); @endphp
                Week 3: {{ $weekDate }}
                @break

                @case("week4")
                @php $weekDate = date('F d, Y', strtotime($week4_row['week'])); @endphp
                Week 4: {{ $weekDate }}
                @break

                @case("week5")
                @php $weekDate = date('F d, Y', strtotime($week5_row['week'])); @endphp
                Week 5: {{ $weekDate }}
                @break

                @case("week6")
                @php $weekDate = date('F d, Y', strtotime($week6_row['week'])); @endphp
                Week 6: {{ $weekDate }}
                @break

                @case("week7")
                @php $weekDate = date('F d, Y', strtotime($week7_row['week'])); @endphp
                Week 7: {{ $weekDate }}
                @break

                @case("week8")
                @php $weekDate = date('F d, Y', strtotime($week8_row['week'])); @endphp
                Week 8: {{ $weekDate }}
                @break

                @case("week9")
                @php $weekDate = date('F d, Y', strtotime($week9_row['week'])); @endphp
                Week 9: {{ $weekDate }}
                @break

                @case("week10")
                @php $weekDate = date('F d, Y', strtotime($week10_row['week'])); @endphp
                Week 10: {{ $weekDate }}
                @break

                @case("week11")
                @php $weekDate = date('F d, Y', strtotime($week11_row['week'])); @endphp
                Week 11: {{ $weekDate }}
                @break

                @case("week12")
                @php $weekDate = date('F d, Y', strtotime($week12_row['week'])); @endphp
                Week 12: {{ $weekDate }}
                @break

                @case("week13")
                @php $weekDate = date('F d, Y', strtotime($week13_row['week'])); @endphp
                Week 13: {{ $weekDate }}
                @break

                @case("week14")
                @php $weekDate = date('F d, Y', strtotime($week14_row['week'])); @endphp
                Week 14: {{ $weekDate }}
                @break

                @case("week15")
                @php $weekDate = date('F d, Y', strtotime($week15_row['week'])); @endphp
                Week 15: {{ $weekDate }}
                @break

              @default
                @php $weekDate = date('F d, Y', strtotime($week1_row['week'])); @endphp
                Week 1: {{ $weekDate }}
            @endswitch
          </h2>
          <p>Clear = Bigger  /  White = Smaller.</p>
          <table class="table footable">
            <thead>
              <tr>
                <th scope="col">Location</th>
                <th data-type="number" scope="col" class="bigger_col">Bigger<br>Full</th>
                <th data-type="number" scope="col" class="bigger_col">Bigger<br>BIWK</th>
                <th data-type="number" scope="col" class="bigger_col">Bigger<br>08-10</th>
								<th data-type="number" scope="col" class="bigger_col">Bigger<br>Extra</th>
                <th data-type="number" scope="col" class="bigger_col">Smaller<br>Full</th>
                <th data-type="number" scope="col" class="bigger_col">Smaller<br>08-10</th>
								<th data-type="number" scope="col">Bigger<br> (total)</th>
								<th data-type="number" scope="col">Smaller<br> (Total)</th>
                <th data-type="number" scope="col">Total</th>
              </tr>	
            </thead>
            <tbody>
            @php
                
            @endphp
							@foreach ($select_locations_index as $item)
                @php

                  $biweekly_count = 0;
                  $full_summer_smaller_count = 0;
                  $full_summer_bigger_count = 0;
                  $fullyear_count = 0;
                  $half_summer_bigger_count = 0;
                  $half_summer_smaller_count = 0;

                  $location = $item['location']->slug;
									$location_name = $item['location']->name;
									
									$extras = $item['extras'];
									
                  if ($extras === true) {
										$extras = 1;
									}
                  else {
                    $extras = 0;
									}
              
                  foreach ($order_ids as $order_id) {
                    $order = wc_get_order($order_id);
                    $order_items = $order->get_items();

                    foreach ($order_items as $order_item) {
                      $filtered_location = $order_item->get_meta('pa_pickup-location'); //biweekly uses global attributes                      
                      $filtered_size = $order_item->get_meta('size'); //15 wk uses custom attributes
                      $filtered_quantity = $order_item->get_quantity();
                      $bundle_mode = $order_item->get_meta( '_bundle_group_mode', true);

                      if ($order_item->get_product_id() == $product_id_biwk && $filtered_location == $location && $displayBiwk) {
                        $biweekly_count += $filtered_quantity;
                      }
                      elseif ($order_item->get_product_id() == $product_id_15wk && $filtered_location == $location && $filtered_size === 'Bigger' && $bundle_mode !== 'parent') {
                        $full_summer_bigger_count += $filtered_quantity;
                      }
                      elseif ($order_item->get_product_id() == $product_id_15wk && $filtered_location == $location && $filtered_size === 'Smaller' && $bundle_mode !== 'parent') {
                        $full_summer_smaller_count += $filtered_quantity;
                      }
                      elseif ($order_item->get_product_id() == $product_id_halfsummer && $filtered_location == $location && $filtered_size === 'Bigger' && $bundle_mode !== 'parent' && $displayHalfsummer) {
                        $half_summer_bigger_count += $filtered_quantity;
                      }
                      elseif ($order_item->get_product_id() == $product_id_halfsummer && $filtered_location == $location && $filtered_size === 'Smaller' && $bundle_mode !== 'parent' && $displayHalfsummer) {
                        $half_summer_smaller_count += $filtered_quantity;
                      }
                      else {
                        //do nothing                        
                      }

                      if ($bundle_mode == 'parent') {
                        $bundled_order = $order_item->get_meta( '_stamp', true);
                        
                        foreach($bundled_order as $key => $value) {
                          if ($value['attributes']['attribute_pa_pickup-location']) {
                            $summer_item_location = $value['attributes']['attribute_pa_pickup-location'];
                          }
                          elseif ($value['attributes']['attribute_location']) {
                            $winter_item_location = $value['attributes']['attribute_location'];
                          }
                          else {
                            //do nothing
                          }                                                    
                        }

                        if ($bundle_mode == 'parent' && $summer_item_location == $location) {
                          $full_year_bigger_count += $filtered_quantity;
                          $fullyear_count++;
                        }
                      }
                      else {
                        //do nothing
                      }
                    }
                  }
                  $total_bigger_count = $full_summer_bigger_count + $biweekly_count + $extras + $half_summer_bigger_count;
                  $total_smaller_count = $full_summer_smaller_count + $half_summer_smaller_count;
									$total_location_count = $total_bigger_count + $total_smaller_count;
                @endphp

                <tr>
                  <td><strong data-toggle="tooltip" data-placement="top" title="{{ $fullyear_count }} full-year purchases">{!! $item['location']->name !!}</strong></td>
                  <td class="bigger_col">{{ $full_summer_bigger_count }}</td>
                  <td class="bigger_col">{{ $biweekly_count }}</td>
                  <td class="bigger_col">{{ $half_summer_bigger_count }}</td>
									<td class="bigger_col">{{ $extras }}</td>
                  <td class="bigger_col">{{ $full_summer_smaller_count }}</td>
                  <td class="bigger_col">{{ $half_summer_smaller_count }}</td>
									<td>{{ $total_bigger_count }}</td>
                  <td>{{ $total_smaller_count }}</td>
                  <td>{{ $total_location_count }}</td>
                </tr>

                @php
									$bigger_count_total += $full_summer_bigger_count;
                  $smaller_count_total += $full_summer_smaller_count;
                  $half_summer_bigger_total += $half_summer_bigger_count;
                  $half_summer_smaller_total += $half_summer_smaller_count;
									$extras_count_total += $extras;
                  $total_biweekly += $biweekly_count;
                  $fullyear_total += $fullyear_count;

									$total_bigger = $bigger_count_total + $extras_count_total + $total_biweekly + $half_summer_bigger_total;
                  $total_smaller = $smaller_count_total + $half_summer_smaller_total;
									$total_count = $total_bigger + $smaller_count_total;
                @endphp
							@endforeach
              <tr>
                <td><strong>Pickup on Farm </strong></td>
                <td class="bigger_col">0</td>
                <td class="bigger_col">0</td>
                <td class="bigger_col">0</td>
                <td class="bigger_col">0</td>
                <td class="bigger_col">1</td>
                <td class="bigger_col">0</td>
                <td>0</td>
                <td>1</td>
                <td>1</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td scope="row"><strong>Totals</strong></td>
                <td class="bigger_col"><strong>{{ $bigger_count_total}}</strong></td>
                <td class="bigger_col"><strong>{{ $total_biweekly }}</strong></td>
                <td class="bigger_col"><strong>{{ $half_summer_bigger_total}}</strong></td>
								<td class="bigger_col"><strong>{{ $extras_count_total }}</strong></td>
                <td class="bigger_col"><strong>{{ $smaller_count_total + 1 }}</strong></td>
                <td class="bigger_col"><strong>{{ $half_summer_smaller_total}}</strong></td>
                <td>{{ $total_bigger }}</td>
								<td><strong>{{ $total_smaller + 1 }}</strong></td>
                <td><strong>{{ $total_count }}</strong></td>
              </tr>
            </tfoot>						
          </table>		
				</section>
				<div class="count_box week">
					<h4>This week's totals:</h4>
					<ul>
						<li><strong>Bigger:</strong> {{ $total_bigger}}</li>
						<li><strong>Smaller:</strong> {{ $total_smaller + 1 }}</li>
						<li><strong>Total:</strong> {{ $total_count }}</li>
					</ul>
				</div>
      {{-- @endforeach --}}
    </article>
  </div>
@endsection