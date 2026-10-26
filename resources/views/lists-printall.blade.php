{{--
  Template Name: Lists Print All
--}}

@extends('layouts.app')

@php
  //List of global variables
  
  // Check if this is a Winter CSA list (set via ACF on the page)
  $winter_csa_mode = get_field('winter_csa_mode');

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

  $product_id_15wk = csa_product_id('fullseason');
  $product_id_biwk = csa_product_id('biwk');
  $product_id_delivery= csa_product_id('delivery');
  $product_id_winter = csa_product_id('winter');
  $product_id_halfsummer = csa_product_id('halfsummer');

  $has_biwk = false;

  $active_locations = array();

  if ($winter_csa_mode) {
    $orders = csa_get_orders_for_products([$product_id_winter], csa_order_date_range('winter'));
  } else {
    $orders = csa_get_orders_for_products(
      [$product_id_15wk, $product_id_biwk, $product_id_halfsummer, $product_id_delivery],
      csa_order_date_range('summer')
    );
  }

$orders_formatted = [];
$items_by_location = [];

foreach ($orders as $order) {
  $order_id = $order->get_id();
  $orders_formatted[$order_id] = [
    'first_name' => $order->get_billing_first_name(),
    'last_name' => $order->get_billing_last_name(),
    'customer_note' => $order->get_customer_note(),
    'alternate_pickup_names' => $order->get_meta('Pickup Name(s)'),
  ];

  foreach ($order->get_items() as $item) {
    $product_id = $item->get_product_id();
    if ($product_id == 103898) {
      continue;
    }
    if ($winter_csa_mode && $product_id != $product_id_winter) {
      continue;
    }
    if (!$winter_csa_mode && $product_id == $product_id_winter) {
      continue;
    }

    $size = $item->get_meta('size', true);
    if ($product_id == $product_id_biwk) {
      $size = 'Bigger';
    }

    if ($winter_csa_mode) {
      $location = csa_order_item_location($item);
      $location_slug = $location;
      $term_id = null;
    } else {
      $location_slug = csa_meta_string($item->get_meta('pa_pickup-location'));
      $term = csa_pickup_term_by_slug($location_slug);
      $location = $term ? $term->name : $location_slug;
      $term_id = $term ? $term->term_id : null;
    }

    if ($product_id == $product_id_delivery) {
      $location = 'Delivery';
    }

    if ($location === '' || $location === 'Delivery') {
      continue;
    }

    $row = [
      'product_id' => $product_id,
      'name' => $item->get_name(),
      'quantity' => $item->get_quantity(),
      'size' => $size,
      'location' => $location,
      'location_slug' => $location_slug,
      'term_id' => $term_id,
    ];

    $key = $winter_csa_mode ? $location : $location_slug;
    $items_by_location[$key][] = [
      'order_id' => $order_id,
      'item' => $row,
    ];
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
        if ($winter_csa_mode) {
          $acf_order = $printall_location_order ?? get_field('printall_location_order');
          $active_locations = csa_ordered_location_keys(
            $items_by_location,
            is_array($acf_order) ? $acf_order : []
          );
        } else {
          $active_locations = [
            'highlands-community-league',
            'catchoftheweek',
            'acme-meat-market',
            'remedy-109st-location',
            'confetti-sweets-sherwood-park',
            'ribeye-sherwood-park',
            'ribeye-manning',
            'remedy-terwillegar-location',
            'ribeye-windermere',
            'darcys-meats-whitemud-crossing',
            'bon-ton-bakery',
            'ribeye-terra-losa',
            'vine-arts-124-st',
            'darcys-meats-st-albert',
            'ribeye-st-albert',
            'town-square',
          ];
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
          
          if ($winter_csa_mode) {
            $extras = csa_winter_extras_for_location($location);
          } else {
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
          }
        @endphp
        @unless($location == 'Delivery')
          <section class="{{ $currentCSAWeek }}">  
            <div class="titleblock" style="break-after: avoid;">
              <h2>{!! $location_object->name !!}</h2>
              @if($winter_csa_mode)
                <h3>Late Season CSA</h3>
                <p><strong>Late Season CSA subscribers get 2 bags each</strong><br />
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
                  @foreach (($items_by_location[$location] ?? []) as $entry)
                    @php
                      $details = $orders_formatted[$entry['order_id']];
                      $item = $entry['item'];

                      if (!$winter_csa_mode && $item['product_id'] == $product_id_biwk) {
                        $has_biwk = true;
                        continue;
                      }

                      $include_row = $winter_csa_mode
                        ? ($item['product_id'] == $product_id_winter)
                        : ($item['product_id'] == $product_id_15wk || $item['product_id'] == $product_id_halfsummer);

                      if (!$include_row) {
                        continue;
                      }

                      if ($item['size'] == 'Bigger') {
                        $seasonal_count_bigger += $item['quantity'];
                        $size = $winter_csa_mode ? '2 CLEAR bags' : 'Bigger <span class="bagsize">Clear Bag</span>';
                      } elseif ($item['size'] == 'Smaller') {
                        $seasonal_count_smaller += $item['quantity'];
                        $size = $winter_csa_mode ? '2 WHITE bags' : 'Smaller <span class="bagsize">White Bag</span>';
                      } else {
                        $size = $item['size'];
                      }
                    @endphp
                    <tr>
                      <td class="name">
                        {{ $details['first_name'] }} {{ $details['last_name'] }}
                      </td>
                      <td>{!! $size !!}</td>
                      <td>{{ $item['quantity'] }}</td>
                      <td class="note">{{ $details['alternate_pickup_names'] }}</td>
                    </tr>
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

                    @foreach (($items_by_location[$location] ?? []) as $entry)
                      @php
                        $item = $entry['item'];
                      @endphp
                      @if($item['product_id'] == $product_id_biwk)
                        @php
                          $details = $orders_formatted[$entry['order_id']];
                          $biwk_count += $item['quantity'];
                        @endphp
                        <tr>
                          <td class="name">
                            {{ $details['first_name'] }} {{ $details['last_name'] }}
                          </td>
                          <td>Bigger <span class="bagsize">Clear Bag</span></td>
                          <td>{{ $item['quantity'] }}</td>
                          <td class="note">{{ $details['alternate_pickup_names'] }}</td>
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
