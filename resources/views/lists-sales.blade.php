{{--
  Template Name: Lists - Overall Report
--}}

@extends('layouts.app')

@php
  $product_id_15wk = csa_product_id('fullseason');
  $product_id_biwk = csa_product_id('biwk');
  $product_id_delivery = csa_product_id('delivery');

  $orders = csa_get_orders_for_products(
    [$product_id_15wk, $product_id_biwk, $product_id_delivery],
    csa_order_date_range('summer'),
    ['completed']
  );

  $biwk_count = 0;
  $fullseason_count = 0;
  $delivery_count = 0;

  foreach ($orders as $order) {
    foreach ($order->get_items() as $order_item) {
      $product_id = $order_item->get_product_id();
      if ($product_id == $product_id_biwk) {
        $biwk_count++;
      } elseif ($product_id == $product_id_15wk) {
        $fullseason_count++;
      } elseif ($product_id == $product_id_delivery) {
        $delivery_count++;
      }
    }
  }
@endphp

@section('content')

  <div class="post-content">

    <article id="page-@php the_ID(); @endphp" @php post_class(); @endphp>

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
            <td>{{ $biwk_count }}</td>
        </tr>
        <tr>
            <td>15-week:</td>
            <td>{{ $fullseason_count }}</td>
        </tr>
        <tr>
            <td>Delivery:</td>
            <td>{{ $delivery_count }}</td>
        </tr>
    </tbody>
</table>

    </article>
  </div>
@endsection
