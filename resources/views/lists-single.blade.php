{{--
  Template Name: Lists Single
--}}

@extends('layouts.app')

@php
  //List of global variables
  

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
  $currentCSAWeek = $currentWeek - 28;

  if ($currentCSAWeek <= 0) {
    $currentCSAWeek = 1;
  }

  if($currentCSAWeek&1){
    $displayBiwk = true;
  }
  else{
    $displayBiwk = false;
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


  // Get location, set by ACF in page
  $product = get_field('product');
  $product_title = $product->post_title;
  $location_term = get_field('location');
  $school_location = get_field('school_location');	
  $winter_location = get_field('select_location_winter');

  if( $location_term ): 				
    $location_name = $location_term->name;
    $weekly = $location_term->slug;
    $location_slug = $location_term->slug;
  elseif ( $school_location ): 				
    $location_name = $school_location;
    $weekly = '';
  elseif ( $winter_location ): 		
    $location_name = $winter_location;      		
  else:
  endif; 

  // Counters
  $seasonal_count = 0;
  $seasonal_count_bigger = 0;
  $seasonal_count_smaller = 0;	
  $biwk_order_count = 0; 
  $biwk_count = 0;
  $week_in_season = 0;
  $winter_count = 0;
  $winter_count_bigger = 0;
  $winter_count_smaller = 0;	

  // 15 week query
  // (all orders with a location of X and a product of Y. Product and Location is set via ACF on a Page.

  global $wpdb;
  
  $order_items = 'wp_woocommerce_order_items';
  $order_meta = 'wp_woocommerce_order_itemmeta';
  $order_data = $wpdb->prefix . 'posts';
  $customer_meta = $wpdb->prefix . 'postmeta';


////********** Query the orders! 
/// might need to tweak for winter csa. later.

$args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'limit' => -1,
    'status' => 'processing'
);
$product_id_fullseason = '5958';
$product_id_biwk = '87354';
$product_id_delivery= '102902';
$product_id_winter = '5484';

if ($product->ID == $product_id_delivery) {
  $delivery_list = true;
}
else {
  $delivery_list = false;
}

//first get all the order ids
$query = new WC_Order_Query( $args );
$order_ids = $query->get_orders();

$filtered_order_ids_biwk = array();
$filtered_order_ids_fullseason = array();
$filtered_order_ids_winter = array();
$filtered_order_ids_delivery_fullseason = array();
$filtered_order_ids_delivery_biwk = array();


foreach ($order_ids as $order_id) {
  $order = wc_get_order($order_id);
  $order_items = $order->get_items();
  $name = $order->get_billing_first_name();

  //iterate through an order's items
  foreach ($order_items as $item) {
    $filtered_location = $item->get_meta('pa_pickup-location'); //biweekly and weekly use global attributes
    $delivery_frequency = $item->get_meta('frequency');

    //if one item has the product id with appropriate pickup location, add it to the array and exit the loop
    if ($item->get_product_id() == $product_id_biwk && $filtered_location == $location_slug) {
      array_push($filtered_order_ids_biwk, $order_id);
      // break;
    }
    if ($item->get_product_id() == $product_id_fullseason && $filtered_location == $location_slug) {
      array_push($filtered_order_ids_fullseason, $order_id);
      // break;
    }
    if ($item->get_product_id() == $product_id_winter && $filtered_location == $location_slug) {
      array_push($filtered_order_ids_winter, $order_id);
      // break;
    }
    if ($displayBiwk) {
      if ($item->get_product_id() == $product_id_delivery) {
        array_push($filtered_order_ids_delivery_fullseason, $order_id);
      }      
    }
    else {
      if ($item->get_product_id() == $product_id_delivery && $delivery_frequency == "Every Week (14 weeks)") {
        array_push($filtered_order_ids_delivery_fullseason, $order_id);
      }
    }
  }
}

if($delivery_list) {
  $filtered_order_ids = $filtered_order_ids_delivery_fullseason;
  $filtered_order_ids_biwk = $filtered_order_ids_delivery_biwk;
}
else {
  $filtered_order_ids = $filtered_order_ids_fullseason;
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
      
      @unless($winter_location)
        <h2>Week {{ $currentCSAWeek }}: {{ $weekXTitle }}</h2>
      @endunless
      <section class="{{ $currentCSAWeek }}">
        @if($winter_location)
          <strong>LATE SEASON SUBSCRIBERS GET 2 BAGS EACH</strong>
          <p>Smaller = 2 White  |  Bigger = 2 Clear</p>
        @endif
        @unless($winter_location)
          <p>BIGGER bounties are in CLEAR BAGS<br /> SMALLER bounties are in WHITE BAGS</p>
        @endunless
        <table class="table footable" data-sorting="true" data-filtering="true" data-sorted="true" data-direction="ASC">
          <thead>
            <tr>
              @if ($delivery_list)
                <th data-sorted="true">#</th>
              @endif
              <th>Customer Name</th>
              @if  ($delivery_list)
                <th class="address">Address</th>
              @endif
              <th>Size</th>
              <th data-breakpoints="xs sm">Qty</th>
              <th data-breakpoints="xs sm" width="30%">Purchase Note</th>
            </tr>
          </thead>
          <tbody>

            @unless($winter_location)

              @foreach ($filtered_order_ids as $details)
                @php 
                  $first_name = $details->get_billing_first_name();
                  $last_name = $details->get_billing_last_name();                
                  $customer_note = $details->get_customer_note();
                  $address = $details->get_shipping_address_1();
                  $city = $details->get_shipping_city();
                  $phone = $details->get_billing_phone();
                  $phone = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phone);

                  $order_of_display = $details->get_meta('order_of_display');
                  
                  foreach ($details->get_items() as $item_id => $item) {
                    $quantity = $item->get_quantity();
                    $size = $item->get_meta( 'size', true );
                  }

                $seasonal_count++;	
                
                if ($size == 'Bigger') {
                  $seasonal_count_bigger += $quantity;
                  $size = "Bigger (Clear Bag)";
                }
                
                if ($size == 'Smaller') {
                  $seasonal_count_smaller += $quantity;              
                  $size = "Smaller (White Bag)";
                }
                
                $display_order = sprintf("%'.02d\n", $order_of_display);
                @endphp

                  <tr>
                    @if ($delivery_list)                      
                      <td>{{ $display_order }}</td>
                    @endif
                    <td class="name">                     
                      {{ $first_name }} {{ $last_name }}
                      @if ($delivery_list)
                        <br><span style="font-size: 15px;">{{ $phone }}</span>
                      @endif
                    </td>
                    @if($delivery_list)
                      <td class="address"><a style="font-size:18px;" target="_blank" href="https://maps.google.com?saddr=Current+Location&daddr={{ $address }} {{ $city }}">{{ $address }}, {{ $city }}</a></td>
                    @endif
                    <td>{{ $size }}</td>
                    <td>{{ $quantity }}</td>
                    <td>{{ $customer_note }}</td>
                  </tr>                
              @endforeach
              @if ($delivery_list)                
                <tr>
                  <td>00</td>
                  <td class="name">Town Square Brewing <br>
                    <span style="font-size: 15px;">(780) 244-0212</span>
                  </td>
                  <td class="address"><a style="font-size:18px;" target="_blank" href="https://maps.google.com?saddr=Current+Location&daddr={{ $address }} {{ $city }}">{{ $address }}, {{ $city }}</a></td>
                  @if ($displayBiwk)
                    <td>16 Bigger | 12 Smaller</td>
                    @php
                      $seasonal_count_bigger += 16; 
                      $seasonal_count_smaller += 12;     
                    @endphp
                  @else
                    <td>11 Bigger | 12 Smaller</td>
                    @php
                      $seasonal_count_bigger += 12;
                      $seasonal_count_smaller += 12;
                    @endphp
                  @endif
                  <td></td>
                  <td></td>
                </tr>  
              @endif
            @endunless

            @if($winter_location)
              @foreach ($filtered_order_ids_winter as $details)		
                @php 
                  $first_name = $details->get_billing_first_name();
                  $last_name = $details->get_billing_last_name();                
                  $customer_note = $details->get_customer_note();
                  $address = $details->get_shipping_address_1();
                  $city = $details->get_shipping_city();

                  foreach ($details->get_items() as $item_id => $item) {
                    $quantity = $item->get_quantity();
                    $size = $item->get_meta( 'size', true );
                  }

                $winter_count++;	

                if ($size == 'Bigger') {
                  $winter_count_bigger += $quantity;
                  $size = "2 CLEAR bags";
                }

                if ($size == 'Smaller') {
                  $winter_count_smaller += $quantity; 
                  $size = "2 WHITE bags";             
                }
                @endphp
                <tr>
                  <td class="name">
                    {{ $first_name }} {{ $last_name }}
                  </td>
                  @if($delivery_list)
                      <td class="address">{{ $address }}, {{ $city }}</td>
                    @endif
                  <td>{{ $size }}</td>
                  <td>{{ $quantity }}</td>
                  <td>{{ $customer_note }}</td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
         
      @unless($winter_location || $delivery_list)
        @if ($displayBiwk)  
        <section class="bi-weekly">
          <h3>Bi-weekly Orders</h3>
          <table class="table footable" data-sorting="true" data-sorted="true" data-direction="ASC">
            <thead>
              <tr>
                <th data-sorted="true">Customer Name</th>
                @if($delivery_list)
                      <th class="address">Address</td>
                    @endif
                <th>Size</th>
                <th data-breakpoints="xs sm">Qty</th>
                <th data-breakpoints="xs sm" width="30%">Purchase Note</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($filtered_order_ids_biwk as $details)
                @php
                // $biwk_order_count++;

                  $first_name = $details->get_billing_first_name();
                  $last_name = $details->get_billing_last_name();                
                  $customer_note = $details->get_customer_note();
                  $address = $details->get_shipping_address_1();
                  $city = $details->get_shipping_city();

                  foreach ($details->get_items() as $item_id => $item) {
                    $biwk_quantity = $item->get_quantity();                                   
                  }

                  $biwk_count += $biwk_quantity;
                  $biwk_order_count += $biwk_quantity;

                @endphp
                <tr>                  
                  <td class="name">
                    {{ $first_name }} {{ $last_name }}
                  </td>
                  @if($delivery_list)
                      <td class="address">{{ $address }}, {{ $city }}</td>
                    @endif
                  <td>Bigger</td>
                  <td>{{ $biwk_quantity }}</td>
                  <td>{{ $customer_note }}</td>
                </tr>
              @endforeach	
            </tbody>
          </table>
        </section>
      @endif
      @endunless

      @unless ($winter_location)        
          <section class="count_box">
            @php
              $total_bigger = $seasonal_count_bigger + $biwk_count;
              $total_smaller = $seasonal_count_smaller;
              $total = $total_bigger + $total_smaller;
            @endphp
            <h4>Week {{ $currentCSAWeek }} Totals:</h4>
            <ul>
              <li><strong>Total:</strong> {{ $total }}</li>
              <li><strong>Bigger:</strong> {{ $total_bigger }}</li>
              <li><strong>Smaller:</strong> {{ $total_smaller }}</li>
            </ul>
          </section> 
      @endunless

      @if($winter_location)
        <section class="count_box week2">
          @php
            $total_bigger = $winter_count_bigger;
            $total_smaller = $winter_count_smaller;              
            $total = $total_bigger + $total_smaller;
          @endphp
          <h4>Totals:</h4>
          <ul>
            <li><strong>Total:</strong> {{ $total }}</li>
            <li><strong>Bigger:</strong> {{ $total_bigger }}</li>
            <li><strong>Smaller:</strong> {{ $total_smaller }}</li>
          </ul>
        </section> 
      @endif
   
      </section>
    </article>
  </div>
@endsection
