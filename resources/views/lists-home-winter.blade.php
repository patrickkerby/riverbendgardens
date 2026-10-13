{{--
  Template Name: Lists - Late Season Index
--}}

@extends('layouts.app')

@php
  $winter_id = csa_product_id('winter');
  $orders = csa_get_orders_for_products([$winter_id], csa_order_date_range('winter'));
  $line_items = csa_winter_line_items($orders);
  $counts = csa_winter_counts_by_location($line_items);

  $acf_locations = $select_locations_index ?? [];
  if (empty($acf_locations) && !empty($select_locations)) {
    $acf_locations = $select_locations;
  }

  $location_rows = csa_winter_index_rows($counts, $acf_locations);

  $bigger_count_total = 0;
  $smaller_count_total = 0;
  $extras_count_total = 0;
  foreach ($location_rows as $row) {
    $bigger_count_total += $row['bigger'];
    $smaller_count_total += $row['smaller'];
    $extras_count_total += $row['extras'];
  }
  $total_count = $bigger_count_total + $smaller_count_total + $extras_count_total;
@endphp

@section('content')

  <div class="post-content">

    <article id="page-@php the_ID(); @endphp" @php post_class(); @endphp>
        <section class="week">
          <h2>Late Season CSA Signups</h2>
          <p>Clear = Bigger  /  White = Smaller.<br>
          Late Season subscribers get 2 bags each (Bigger = 2 clear, Smaller = 2 white).</p>

			<table class="table footable">
				<thead>
					<tr>
						<th>Location</th>
						<th>Bigger</th>
						<th>Smaller</th>
            <th>Extras</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($location_rows as $row)
						<tr>
							<td><strong>{{ $row['name'] }}</strong></td>
							<td>{{ $row['bigger'] }}</td>
							<td>{{ $row['smaller'] }}</td>
              <td>{{ $row['extras'] }}</td>
							<td>{{ $row['total'] }}</td>
						</tr>
					@empty
            <tr>
              <td colspan="5">No processing Late Season orders found for {{ date('Y') }}.</td>
            </tr>
					@endforelse
				</tbody>
				<tfoot>
					<tr>
						<td><strong>Totals</strong></td>
						<td><strong>{{ $bigger_count_total }}</strong></td>
						<td><strong>{{ $smaller_count_total }}</strong></td>
						<td><strong>{{ $extras_count_total }}</strong></td>
            <td><strong>{{ $total_count }}</strong></td>
					</tr>
				</tfoot>
			</table>

		</section>
		<div class="count_box week">
			<h4>This week's totals:</h4>
			<ul>
				<li><strong>Bigger:</strong> {{ $bigger_count_total }}</li>
				<li><strong>Smaller:</strong> {{ $smaller_count_total }}</li>
        <li><strong>Extras:</strong> {{ $extras_count_total }}</li>
				<li><strong>Total:</strong> {{ $total_count }}</li>
			</ul>
		</div>
    </article>
  </div>
@endsection
