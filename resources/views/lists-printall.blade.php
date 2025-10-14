{{--
  Template Name: Lists Print All
--}}

@extends('layouts.app')

@php
  //List of global variables
  
  // Check if this is a Winter CSA list (set via ACF on the page)
  $winter_csa_mode = get_field('winter_csa_mode');

  // Location name normalization for Winter CSA (consolidates variants)
  function normalizeLocationName($location) {
    $location_map = [
      'Catch of the Week!' => 'Catch of the Week',
      'Confetti Sweets (Sherwood Park)' => 'Confetti Sweets',
      "D'arcy's Meat Market (St Albert Location)" => "D'Arcy's Meats (St Albert)",
      "D'arcy's Meat Market (Whitemud Crossing Location)" => "D'Arcy's Meats (Whitemud Crossing)",
      'Remedy (109th St)' => 'Remedy (109St Location)',
      'Remedy (Terwillegar)' => 'Remedy (Terwillegar Location)',
      'Ribeye Butcher Shop (Manning Center)' => 'Ribeye Butcher Shop (Manning Location)',
      'Ribeye Butcher Shop (St Albert Erin Ridge)' => 'Ribeye Butcher Shop (St Albert)',
      'Jasper Ave Location (TBD)' => 'Obj3cts (Jasper Ave)',
      'Home Delivery (Edmonton & Sherwood Park only)' => 'Delivery',
      'Highlands Area Pick Up' => 'Candid Coffee Roasters',
    ];
    
    return $location_map[$location] ?? $location;
  }

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

  // Get current week of the year, check if it's even or odd. Biweekly only delivers on odd weeks.
  $currentWeek = date('W');
  $currentCSAWeek = $currentWeek - 27;

  if ($currentCSAWeek <= 0) {
    $currentCSAWeek = 1;
  }

  if($currentCSAWeek&1){
    $displayBiwk = true;
  }
  else{
    $displayBiwk = false;
  }

  if ($currentCSAWeek > 7) {
    $displayHalfsummer = true;
  }
  else {
    $displayHalfsummer = false;
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

  // convert current week count to match with row indexes above
  $currentCSAWeekIndexed = $currentCSAWeek - 1;
  $weekX_row = $rows[$currentCSAWeekIndexed];
  $weekX = 'Week ' .$currentCSAWeek.': ' . $weekX_row['week'];

  $weekXTitle = date('F d, Y', strtotime($weekX_row['week']));
	
if($currentCSAWeek > 14) {
  $late_season = true;
 }
 else {
  $late_season = false;
 }

  // 15 week query
  // (all orders with a location of X and a product of Y. Product and Location is set via ACF on a Page.

  global $wpdb;
  
  $order_items = 'wp_woocommerce_order_items';
  $order_meta = 'wp_woocommerce_order_itemmeta';
  $order_data = $wpdb->prefix . 'posts';
  $customer_meta = $wpdb->prefix . 'postmeta';

  $product_id_15wk = '5958';
  $product_id_biwk = '87354';
  $product_id_delivery= '102902';
  $product_id_winter = '5484';
  $product_id_halfsummer = '103905';

  $has_biwk = false;

  $active_locations = array();

  // Adjust date range based on list type
  // $date_range = $winter_csa_mode ? '2024-10-01...2025-04-30' : '2025-01-01...2025-09-31';
  $date_range = '2025-01-01...2025-10-31';
  
  $args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'limit' => -1,
    'status' => array('wc-processing', 'wc-on-hold'),
    'date_created' => $date_range,
  );
  $query = new WC_Order_Query( $args );
  $orders = $query->get_orders();

//Build base struture of all order data we need

foreach ($orders as $order) {

  // $order = wc_get_order($order_id);
  $first_name = $order->get_billing_first_name();
  $last_name = $order->get_billing_last_name();                
  $customer_note = $order->get_customer_note();
  $order_id = $order->get_id();
  $alternate_pickup_names = $order->get_meta('Pickup Name(s)');
  
  $orders_formatted[$order_id] = array(
    'first_name' => $first_name,
    'last_name' => $last_name,
    'customer_note' => $customer_note,
    'alternate_pickup_names' => $alternate_pickup_names
  );

  //iterate through an order's items
  foreach ($order->get_items() as $item_id => $item) {
    $product_id = $item->get_product_id();
    $product_name = $item->get_name();
    $quantity = $item->get_quantity();
    $size = $item->get_meta( 'size', true );
    $location = "";
    $location_slug = $item->get_meta('pa_pickup-location');
    $location_name_winter = $item->get_meta('location');
    $location_object = get_term_by( 'slug', $location_slug, 'pa_pickup-location' );
    
    if($location_object) {
      $location = $location_object->name;
      $extras_setting = get_field('extras', $location_object);
    }
    elseif($location_name_winter) {
      $location = normalizeLocationName($location_name_winter);
      $location_slug = $location;
      $extras_setting = 1;
    }

    if($product_id == $product_id_biwk) {
      $size = 'Bigger';
    }
    
    if($product_id == $product_id_delivery) {
      $location = 'Delivery';
    }
  
    $active_locations[] = $location;
    $active_locations = array_unique($active_locations);
    sort($active_locations);


    // Skip adding this item if product_id is 103898
    if ($product_id == 103898) {
      continue;
    }
    
    // Filter based on winter mode
    if ($winter_csa_mode) {
      // In winter mode, only include winter CSA products
      if ($product_id != $product_id_winter) {
        continue;
      }
    } else {
      // In regular mode, exclude winter CSA products
      if ($product_id == $product_id_winter) {
        continue;
      }
    }

    // Initialize 'items' as an array if not already set
    if (!isset($orders_formatted[$order_id]['items'])) {
      $orders_formatted[$order_id]['items'] = [];
    }

    $orders_formatted[$order_id]['items'] = array(
      'product_id' => $product_id,  
      'name' => $product_name,
      'quantity' => $quantity,
      'size' => $size,
      'location' => $location,
      'location_slug' => $location_slug,
      'term_id' => $location_object->term_id ?? null,
    );
  }
}

@endphp

@section('content')

<script type="text/javascript">
  ( function($) {
    $(document).ready(function(){    
      $('.table').footable();
    });
  } ) ( jQuery );
</script>

  <div class="post-content">
    <article id="page-@php the_ID(); @endphp" @php post_class(); @endphp>
    

      @php
        // Use dynamically built active_locations from the orders loop above
        // This handles both taxonomy slugs (regular CSA) and location names (winter CSA)
        
        // If in winter mode, we need to get unique location names from orders
        if ($winter_csa_mode) {
          $winter_locations = [];
          foreach ($orders_formatted as $order_data) {
            if (isset($order_data['items']['location']) && !empty($order_data['items']['location'])) {
              $winter_locations[] = $order_data['items']['location'];
            }
          }
          $active_locations = array_unique($winter_locations);
          sort($active_locations);
        } else {
          // Regular mode - use slugs
          $active_locations = [
            'highlands-community-league',
            'jasper-ave-location',
            'catchoftheweek',
            'remedy-109st-location',
            'acme-meat-market',
            'confetti-sweets-sherwood-park',
            'ribeye-sherwood-park',
            'darcys-meats-st-albert',
            'ribeye-st-albert',
            'ribeye-terra-losa',
            'bon-ton-bakery',
            'ribeye-windermere',
            'remedy-terwillegar-location',
            'darcys-meats-whitemud-crossing',
            'ribeye-manning',          
            'town-square',
          ];
          ksort($active_locations);
        }
      @endphp

      @foreach($active_locations as $location)
        @php        
          // Counters
          $seasonal_count = 0;
          $seasonal_count_bigger = 0;
          $seasonal_count_smaller = 0;	
          $biwk_count = 0;
          $week_in_season = 0;
          $winter_count = 0;
          $winter_count_bigger = 0;
          $winter_count_smaller = 0;
          $has_biwk = false;

          // In winter mode, $location is a name; in regular mode, it's a slug
          if ($winter_csa_mode) {
            $location_object = get_term_by( 'name', $location, 'pa_pickup-location' );
            // If no term found by name, create a fake object for display
            if (!$location_object) {
              $location_object = (object) ['name' => $location, 'term_id' => null];
            }
          } else {
            $location_object = get_term_by( 'slug', $location, 'pa_pickup-location' );
          }
          
          $extras_setting = is_object($location_object) ? get_field('extras', $location_object) : 1;
                 
          if($extras_setting == true) {
            $extras = 1;
          }
          else {
            $extras = 0;
          }
          if($late_season) {
            $extras = 1;
          }
        @endphp
        @unless($location == 'Delivery')
          <section class="{{ $currentCSAWeek }}">  
            <div class="titleblock" style="break-after: avoid;">
              <h2>{!! $location_object->name !!}</h2>
              @if($winter_csa_mode)
                <h3>Winter CSA</h3>
                <p><strong>Winter CSA subscribers get 2 bags each</strong><br />
                Smaller = 2 White Bags | Bigger = 2 Clear Bags</p>
              @else
                @unless($late_season)
                  <h3>Week {{ $currentCSAWeek }}: {{ $weekXTitle }}</h3>
                @endunless
              @endif              
              {{-- <p>BIGGER bounties are in CLEAR BAGS<br /> SMALLER bounties are in WHITE BAGS</p> --}}
            </div>

            <table style="break-inside: auto; break-before: avoid; break-after:avoid;" class="table footable" data-sorting="true" data-filtering="false" data-sorted="true" data-direction="ASC">
              <thead>
                <tr>
                  <th data-sorted="true">Customer Name</th>
                  <th>Size</th>
                  <th data-breakpoints="xs sm">Qty</th>
                  <th data-breakpoints="xs sm" width="30%">Additional Pickup Names</th>
                  {{-- <th data-breakpoints="xs sm" width="30%">Purchase Note</th> --}}
                </tr>
              </thead>
              <tbody>
                  @foreach ($orders_formatted as $details)

                    @php 
// print("<pre>".print_r($details,true)."</pre>");

                      if($details['items']['term_id'] == $location_object->term_id && $details['items']['product_id'] == $product_id_biwk) {
                        $has_biwk = true;
                      }
                    @endphp
                    
                    @if($winter_csa_mode)
                      {{-- Winter CSA Mode - compare by location name --}}
                      @if($details['items']['location'] == $location && $details['items']['product_id'] == $product_id_winter)
                        @php
                          if ($details['items']['size'] == 'Bigger') {
                            $seasonal_count_bigger += $details['items']['quantity'];
                            $size = "Bigger <span class=\"bagsize\">2 Clear Bags</span>";
                          }
                          
                          if ($details['items']['size'] == 'Smaller') {
                            $seasonal_count_smaller += $details['items']['quantity'];              
                            $size = "Smaller <span class=\"bagsize\">2 White Bags</span>";
                          }
                        @endphp
                        <tr>
                          <td class="name">
                            {{ $details['first_name'] }} {{ $details['last_name'] }}
                          </td>
                          <td>{!! $size !!}</td>
                          <td>{{ $details['items']['quantity'] }}</td>
                          <td class="note">{{ $details['alternate_pickup_names'] }}</td>
                          {{-- <td class="note">{{ $details['customer_note'] }}</td> --}}
                        </tr>
                      @endif
                    @else
                      {{-- Regular CSA Mode --}}
                      @if(
                        $details['items']['term_id'] == $location_object->term_id &&
                        (
                          $details['items']['product_id'] == $product_id_15wk ||
                          $details['items']['product_id'] == $product_id_halfsummer
                        )
                      )
                      
                        @php
                          if ($details['items']['size'] == 'Bigger') {
                            $seasonal_count_bigger += $details['items']['quantity'];
                            $size = "Bigger <span class=\"bagsize\">Clear Bag</span>";
                          }
                          
                          if ($details['items']['size'] == 'Smaller') {
                            $seasonal_count_smaller += $details['items']['quantity'];              
                            $size = "Smaller <span class=\"bagsize\">White Bag</span>";
                          }
                        @endphp
                        <tr>
                          <td class="name">
                            {{ $details['first_name'] }} {{ $details['last_name'] }}
                          </td>
                          <td>{!! $size !!}</td>
                          <td>{{ $details['items']['quantity'] }}</td>
                          <td class="note">{{ $details['alternate_pickup_names'] }}</td>
                          {{-- <td class="note">{{ $details['customer_note'] }}</td> --}}
                        </tr>
                      @endif
                    @endif
                  @endforeach
              </tbody>
            </table>
            @if(!$winter_csa_mode && $displayBiwk && $has_biwk)
              <h3>Bi-weekly orders</h3>
              <table class="table footable" data-sorting="true" data-filtering="false" data-sorted="true" data-direction="ASC">
                <thead>
                  <tr>
                    <th data-sorted="true">Customer Name</th>
                    <th>Size</th>
                    <th data-breakpoints="xs sm">Qty</th>
                    <th data-breakpoints="xs sm" width="30%">Additional Pickup Names</th>
                    {{-- <th data-breakpoints="xs sm" width="30%">Purchase Note</th> --}}
                  </tr>
                </thead>
                <tbody>

                    @foreach ($orders_formatted as $details)                    
                      @if($details['items']['term_id'] == $location_object->term_id && $details['items']['product_id'] == $product_id_biwk)
                        @php
                          $biwk_count += $details['items']['quantity'];
                        @endphp
                        <tr>
                          <td class="name">
                            {{ $details['first_name'] }} {{ $details['last_name'] }}
                          </td>
                          <td>Bigger <span class="bagsize">Clear Bag</span></td>
                          <td>{{ $details['items']['quantity'] }}</td>
                          <td class="note">{{ $details['alternate_pickup_names'] }}</td>
                          {{-- <td class="note">{{ $details['customer_note'] }}</td> --}}
                        </tr>
                      @endif
                    @endforeach
                </tbody>
              </table>
            @endif
            @php
              $total_bigger = $seasonal_count_bigger + $biwk_count;
              $total_smaller = $seasonal_count_smaller;              
              $total = $total_bigger + $total_smaller + $extras;
            @endphp
            <div class="totalsline">
              <p><strong>{!! $location !!}:</strong></p>
              <ul>
                <li><strong>Bigger:</strong> {{ $total_bigger }}</li>
                <li><strong>Smaller:</strong> {{ $total_smaller }}</li>
                <li><strong>Extras:</strong> {{ $extras }}</li>
                <li><strong>Total:</strong> {{ $total }}</li>
              </ul>
            </div>
              
          </section>
        @endunless
      @endforeach
    </article>
  </div>
@endsection
