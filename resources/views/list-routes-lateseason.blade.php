{{--
  Template Name: Delivery List - Late Season
--}}

@extends('layouts.app')

@php
  function parseLateSeasonDeliveryTime($time) {
    $parsed = strtotime('today ' . trim((string) $time));
    return $parsed !== false ? $parsed : 0;
  }

  $orders = csa_get_orders_for_products([csa_product_id('winter')], csa_order_date_range('winter'));
  $counts = csa_winter_counts_by_location(csa_winter_line_items($orders));
  $select_locations = $select_locations ?? [];
  $route_rows = [];

  foreach ($select_locations as $item) {
    $location_name = csa_acf_location_name($item);
    if ($location_name === '') {
      continue;
    }

    $canonical = csa_normalize_location($location_name);
    $extras = !empty($item['extras']) ? 1 : 0;
    $bigger_count = ($counts[$canonical]['Bigger'] ?? 0) + $extras;
    $smaller_count = $counts[$canonical]['Smaller'] ?? 0;

    $route_rows[] = [
      'delivery_time' => $item['delivery_time'] ?? '',
      'delivery_time_sort' => parseLateSeasonDeliveryTime($item['delivery_time'] ?? ''),
      'location_name' => $location_name,
      'bigger_count' => $bigger_count,
      'smaller_count' => $smaller_count,
    ];
  }

  usort($route_rows, function ($a, $b) {
    return ($a['delivery_time_sort'] ?? 0) <=> ($b['delivery_time_sort'] ?? 0);
  });

  $bigger_count_total = 0;
  $smaller_count_total = 0;
  foreach ($route_rows as $row) {
    $bigger_count_total += $row['bigger_count'];
    $smaller_count_total += $row['smaller_count'];
  }
@endphp

@section('content')

<div class="post-content">
  <article id="page-@php the_ID(); @endphp" @php post_class(); @endphp>
    <section class="week">
      <h2>Late-Season Delivery List</h2>
      <p>Clear = Bigger  /  White = Smaller.<br />
      Late Season subscribers get 2 bags each. These numbers <em>include</em> extras.</p>
			<table class="table footable">
				<thead>
          <tr>
            <th>Delivery Time</th>
						<th scope="col">Location</th>
            <th data-type="number" scope="col">Clear Bag Crates</th>
            <th data-type="number" scope="col">White Bag Crates</th>
					</tr>
				</thead>
				<tbody>
          @forelse ($route_rows as $row)
            <tr>
              <td>{{ $row['delivery_time'] }}</td>
              <td><strong>{{ $row['location_name'] }}</strong></td>
              <td>{{ $row['bigger_count'] }}</td>
              <td>{{ $row['smaller_count'] }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4">No late-season route locations found. Check the location repeater on this page.</td>
            </tr>
          @endforelse
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" scope="row"><strong>Totals</strong></td>
            <td><strong>{{ $bigger_count_total }}</strong></td>
            <td><strong>{{ $smaller_count_total }}</strong></td>
          </tr>
        </tfoot>
      </table>
    </section>
	</article>
</div>
@endsection
