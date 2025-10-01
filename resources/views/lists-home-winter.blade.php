{{--
  Template Name: Lists - Late Season Index
--}}

@extends('layouts.app')

{{-- @include('partials.list-functions') --}}
@php
//List of global variables
global $wpdb, $woocommerce;


// ------------------------- Get pickup dates for current year, set in Global Options -------------------------    
// TODO: see if these dates can be provided on composite product item _rather_ than global options.

  $year = "CSA 2025 - 14 week";
  $late_season = "Late Season CSA";

  $bigger_count = 0;
  $smaller_count = 0;  

  $bigger_count_total = 0;
  $smaller_count_total = 0;
  $smaller_crates_total = 0;
  $bigger_crates_total = 0;
  $extras_count_total = 0;
  $product_id_lateseason = '5484';
  $product_id_fullyear = '103898';
  $filtered_order_ids_lateseason = array();

////********** Query the orders! 
  $args = array(
      'orderby' => 'date',
      'order' => 'DESC',
      'limit' => 800,
      'return' => 'ids',
      'type' => 'shop_order',
      'status' => array('wc-processing', 'wc-on-hold'),
      'date_created' => '2025-01-01...2025-12-31'
    );
  

//first get all the order ids
  $query = new WC_Order_Query( $args );
  $order_ids = $query->get_orders();

//then loop through each order id, get the order, loop through the items in the order, and if the item is the product we want, get its meta data
$location_counts = [];
$bigger_count_total = 0;
$smaller_count_total = 0;

foreach ($order_ids as $order_id) {
    $order = wc_get_order($order_id);
    foreach ($order->get_items() as $item) {
        if ($item->get_product_id() != $product_id_lateseason) continue;

        $location = $item->get_meta('location');
        $size = $item->get_meta('size');
        $quantity = $item->get_quantity();

        if (!isset($location_counts[$location])) {
            $location_counts[$location] = ['Bigger' => 0, 'Smaller' => 0];
        }
        if ($size === 'Bigger') {
            $location_counts[$location]['Bigger'] += $quantity;
            $bigger_count_total += $quantity;
        } elseif ($size === 'Smaller') {
            $location_counts[$location]['Smaller'] += $quantity;
            $smaller_count_total += $quantity;
        }
    }
}
$total_count = $bigger_count_total + $smaller_count_total;

@endphp





@section('content')

  <div class="post-content">

    <article id="page-@php the_ID(); @endphp" @php post_class(); @endphp>      
        <section class="week {{ $week_in_season }}">  
          <h2>Late Season CSA Signups</h2>
          <p>Clear = Bigger  /  White = Smaller.</p>

			<table class="table footable">
				<thead>
					<tr>
						<th>Location</th>
						<th>Bigger</th>
						<th>Smaller</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($location_counts as $location_name => $counts)
						<tr>
							<td><strong>{{ $location_name }}</strong></td>
							<td>{{ $counts['Bigger'] }}</td>
							<td>{{ $counts['Smaller'] }}</td>
							<td>{{ $counts['Bigger'] + $counts['Smaller'] }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td><strong>Totals</strong></td>
						<td><strong>{{ $bigger_count_total }}</strong></td>
						<td><strong>{{ $smaller_count_total }}</strong></td>
						<td><strong>{{ $total_count }}</strong></td>
					</tr>
				</tfoot>
			</table>
          	
		</section>
		<div class="count_box week">
			<h4>This week's totals:</h4>
			<ul>
				<li><strong>Bigger:</strong> {{ $bigger_count_total}}</li>
				<li><strong>Smaller:</strong> {{ $smaller_count_total }}</li>
				<li><strong>Total:</strong> {{ $total_count }}</li>
			</ul>
		</div>
      {{-- @endforeach --}}
    </article>
  </div>
@endsection