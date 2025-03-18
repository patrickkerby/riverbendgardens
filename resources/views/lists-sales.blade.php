{{--
  Template Name: Lists - Overall Report
--}}

@extends('layouts.app')

{{-- @include('partials.list-functions') --}}
@php
//List of global variables
global $wpdb, $woocommerce;



////********** Query the orders! 
  $args = array(
      'orderby' => 'date',
      'order' => 'DESC',
      'limit' => 2000,
      'status' => 'completed',
      'date_created' => '2024-01-01...2025-12-31',
  );

    $product_id_15wk = '5958';
    $product_id_biwk = '87354';
    $product_id_weekly = '59432';
    $product_id_delivery = '102902';
	

//first get all the order ids
  $query = new WC_Order_Query( $args );
  $order_ids = $query->get_orders();

  $filtered_order_ids_biwk = array();
  $filtered_order_ids_15wk = array();
  $filtered_order_ids_delivery = array();

@endphp

@section('content')

  <div class="post-content">

    <article id="page-@php the_ID(); @endphp" @php post_class(); @endphp>

        @php
            foreach ($order_ids as $order_id) {
                $order = wc_get_order($order_id);
                $order_items = $order->get_items();

                foreach ($order_items as $order_item) {
                    if ($order_item->get_product_id() == $product_id_biwk) {
                            array_push($filtered_order_ids_biwk, $order_id);
                    }
                    if ($order_item->get_product_id() == $product_id_15wk) {
                            array_push($filtered_order_ids_15wk, $order_id);
                    }
                    if ($order_item->get_product_id() == $product_id_delivery) {
                            array_push($filtered_order_ids_delivery, $order_id);
                    }
                }
            }

        @endphp

<table class="table footable">
    <thead>
      <tr>
        <th scope="col">Product</th>
        <th data-type="number" scope="col">Count</th>
      </tr>	
    </thead>
    <tbody>
        <tr>
            <td>Bi-weekly:</td>
            <td>{{ count($filtered_order_ids_biwk) }}</td>
        </tr>
        <tr>
            <td>15-week:</td>
            <td>{{ count($filtered_order_ids_15wk) }}</td>
        </tr>
        <tr>
            <td>Delivery:</td>
            <td>{{ count($filtered_order_ids_delivery) }}</td>
        </tr>
    </tbody>
</table>

    </article>
  </div>
@endsection