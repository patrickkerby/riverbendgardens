{{--
  Template Name: Delivery List
--}}

@extends('layouts.app')

{{-- @include('partials.list-functions') --}}
@php
//List of global variables
global $wpdb, $woocommerce;

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

// Get current week of the year, check if it's even or odd. Biweekly only delivers on odd weeks.
  $currentWeek = date('W');
  $currentCSAWeek = $currentWeek - 27;

  if ($currentCSAWeek == 0) {
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

  if (in_array($week_in_season, $even_weeks)) {
    $displayBiwk = false;
  }
  else {
    $displayBiwk = true;
  }

  $bigger_count = 0;
  $smaller_count = 0;  

  $weekly_count_bigger = 0;
  $weekly_count_smaller = 0;

  $bigger_count_total = 0;
  $smaller_count_total = 0;
  $smaller_crates_total = 0;
  $bigger_crates_total = 0;

//** Query the orders! 
  $args = array(
      'orderby' => 'date',
      'order' => 'DESC',
      'limit' => -1,
      'status' => array('wc-processing', 'wc-on-hold'),
      'date_created' => '2025-01-01...2025-07-31',
  );

  $product_id_15wk = '5958';
  $product_id_biwk = '87354';

  //first get all the order ids
  $query = new WC_Order_Query( $args );
  $orders = $query->get_orders();

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
          <p>Clear = Bigger  /  White = Smaller.<br /> These numbers <em>include</em> extras.</p>
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
              @foreach ($select_locations as $item)
                @php                
                  $biweekly_total_count = 0;
                  $fullseason_smaller_count = 0;
                  $fullseason_bigger_count = 0;                  
                  
                  $location = $item['location']->slug;
                  $location_name = $item['location']->name;

                  $extras = $item['extras'];

                  if ($extras == true) {
										$extras = 1;
									}
                  else {
                    $extras = 0;
                  }        
                        
                  foreach ($orders as $order) {
                    
                    $order_items = $order->get_items();

                    foreach ($order_items as $order_item) {
                      $filtered_location = $order_item->get_meta('pa_pickup-location');
                      $filtered_size = $order_item->get_meta('size');
                      $filtered_quantity = $order_item->get_quantity();

                      if ($order_item->get_product_id() == $product_id_biwk && $filtered_location == $location) {
                        $biweekly_total_count += $filtered_quantity;
                      }
                      elseif ($order_item->get_product_id() == $product_id_15wk && $filtered_location == $location && $filtered_size == 'Bigger') {
                        $fullseason_bigger_count += $filtered_quantity;                        
                      }
                      elseif ($order_item->get_product_id() == $product_id_15wk && $filtered_location == $location && $filtered_size == 'Smaller') {
                        $fullseason_smaller_count += $filtered_quantity;
                      }
                    }
                  }
                  
                  if ($displayBiwk == true) {
                    $bigger_count = $fullseason_bigger_count + $biweekly_total_count + $extras;
                  }
                  else {
                    $bigger_count = $fullseason_bigger_count + $extras;
                  }

                  $smaller_count = $fullseason_smaller_count;
                  $bigger_crates = $bigger_count/2;
                  $smaller_crates = $smaller_count/2; 
                @endphp

                <tr>
                  <td>{{ $item['delivery_time'] }}</td>
                  <td><strong>{{ $item['location']->name }} </strong></td>
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
                @endphp
              @endforeach
              @foreach ($custom_location as $custom)
                @php
                  if (!$custom['bigger_count']) {
                    $bigger_size = 0;
                    $bigger_crates = 0;
                  }
                  else {
                    $bigger_crates = $custom['bigger_count']/2;
                    $bigger_size = $custom['bigger_count'];
                  }
                  
                  if (!$custom['smaller_count']) {
                    $smaller_crates = 0;
                    $smaller_size = 0;
                  }
                  else {
                    $smaller_crates = $custom['smaller_count']/2;
                    $smaller_size = $custom['smaller_count'];
                  }
                  
                @endphp
                <tr>
                  <td>{{ $custom['delivery_time'] }}</td>
                  <td><strong>{{ $custom['location'] }} </strong></td>
                  <td>{{ $bigger_size }}</td>
                  <td>{{ $bigger_crates }}</td>
                  <td>{{ $smaller_size }}</td>
                  <td>{{ $smaller_crates }}</td>
                </tr>
                @php
                  $bigger_count_total += $bigger_size;
                  $smaller_count_total += $smaller_size;
                  $bigger_crates_total += $bigger_crates;  
                  $smaller_crates_total += $smaller_crates;
                @endphp
              @endforeach


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
      {{-- @endforeach --}}
    </article>
  </div>
@endsection