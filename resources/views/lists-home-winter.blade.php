{{--
  Template Name: Lists - Late Season Index
--}}

@extends('layouts.app')

{{-- @include('partials.list-functions') --}}

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
@endphp

@section('content')


@php
	$year = "Late Season CSA";

	if ( isset( $_POST['year'] ) ) { 
		$year = $_POST['year'];							
	} 
	else {
		$year = "Late Season CSA";
	}

@endphp

<script type="text/javascript">
	( function($) {
		$(document).ready(function(){
			$("select").change(function(){
					$(this).find("option:selected").each(function(){
							var optionValue = $(this).attr("value");
							if(optionValue){
									$(".week").not("." + optionValue).hide();
									$("." + optionValue).show();
							} else{
									$(".week").hide();
							}
					});
			}).change();

			$('.table').footable();

		});
	} ) ( jQuery );
</script>

<div class="post-content">
	<article id="page-@php the_ID(); @endphp" @php post_class(); @endphp>
		<section>
			<h2>Packing Lists - {{ $year }}</h2>			
		
			<table class="table footable" data-sorting="true">
				<thead>
					<tr>
						<th scope="col">Location</th>
						<th data-type="number" scope="col">Bigger</th>
						<th data-type="number" scope="col">Smaller</th>
						<th data-type="number" scope="col">Total (15wk)</th>
					</tr>	 
				</thead>
				<tbody>
					@php
					
						global $wpdb, $woocommerce;
					
						$order_items = 'wp_woocommerce_order_items';
						$order_meta = 'wp_woocommerce_order_itemmeta';
						$order_data = $wpdb->prefix . 'posts';
						$customer_data = $wpdb->prefix . 'postmeta';
						$order_data = $wpdb->prefix . 'posts';

            $late_season = wc_get_product( 5484 );

						$winter_locations = get_post_meta($late_season->get_id(), '_product_attributes', true);						
						$winter_locations = explode(' | ', $winter_locations['location']['value']);



						$bigger_count = 0;
            $smaller_count = 0; 

						$sql_str = '';

						foreach ($winter_locations as $location) {

              $location_esc = addslashes($location);

							$sql_str = ( "
								SELECT COUNT(Q2.bigger_count) AS bigger_count, COUNT(Q3.smaller_count) AS smaller_count, COUNT(Q1.order_id) AS total_count
								FROM		
									(	SELECT order_id, $order_items.order_item_id AS order_item_id, $order_meta.meta_key, $order_meta.meta_value AS location_value
										FROM $order_items, $order_meta
										WHERE $order_items.order_item_id = $order_meta.order_item_id
										AND $order_meta.meta_value = '$location_esc'
										AND $order_items.order_item_name LIKE '$year%'
									) Q1
								LEFT JOIN
									(	SELECT order_id, $order_items.order_item_id, $order_meta.meta_key, $order_meta.meta_value AS bigger_count
										FROM $order_items, $order_meta
										WHERE $order_items.order_item_id = $order_meta.order_item_id
										AND meta_key IN ('size')
										AND $order_meta.meta_value = 'bigger'
									)	Q2
								ON Q1.order_id = Q2.order_id
								LEFT JOIN
									(	SELECT order_id, $order_items.order_item_id, $order_meta.meta_key, $order_meta.meta_value AS smaller_count
										FROM $order_items, $order_meta
										WHERE $order_items.order_item_id = $order_meta.order_item_id
										AND meta_key IN ('size')
										AND $order_meta.meta_value = 'smaller'
									)	Q3
								ON Q1.order_id = Q3.order_id
								INNER JOIN
									(	SELECT DISTINCT $order_data.ID AS ID, $order_data.post_status AS post_status
										FROM $order_data
										WHERE $order_data.post_status = 'wc-processing'
									)	Q4
								ON Q1.order_id = Q4.ID
								
								ORDER BY location_value			 
							");
							
							$count_results = $wpdb->get_results($sql_str);
													
							$row = $count_results[0];
							
							$bigger_count += $row->bigger_count;
							$smaller_count += $row->smaller_count;

                //intentions: count how many orders have a qty of 2. if qty is 2 AND size is bigger, increase bigger count by 1. likewise for smaller. qty of 3 likely doesn't ever happen, but could code for it just in case.
                //why i think it won't work: this query is looping through each location, and doing a count of records. I might need to add additional selectors to actually show size data to compare with. 
                

							@endphp
							<tr>
								<td><strong>@php echo "$location"; @endphp</strong></td>
								<td data-sort-value="@php echo($row->bigger_count); @endphp">@php echo($row->bigger_count); @endphp</td>
								<td data-sort-value="@php echo($row->smaller_count); @endphp">@php echo($row->smaller_count); @endphp</td>
								<td data-sort-value="@php echo($row->total_count); @endphp">@php echo($row->total_count); @endphp</td>
							</tr>					
						@php } @endphp						
						</tbody>
						<tfoot>
							<tr>
								<th scope="row"><strong>Totals</strong></th>
								<td>Bigger: @php echo( $bigger_count ); @endphp</td>
								<td>Smaller: @php echo( $smaller_count ); @endphp</td>
								<td>Total: @php echo( $bigger_count + $smaller_count ); @endphp</td>
							</tr>
						</tfoot>						
				</table>

			</section>
			<div class="count_box week1">
				<h4>This week's totals:</h4>
				<ul>
					<li><strong>Bigger:</strong> @php echo( $bigger_count ); @endphp</li>
					<li><strong>Smaller:</strong> @php echo( $smaller_count ); @endphp </li>
					<li><strong>Extras:</strong> 7 </li>
					<li><strong>Total:</strong> @php echo( $bigger_count + $smaller_count + 7 ); @endphp</li>
				</ul>
			</div>
			
		</section>
	</article>
</div>
@endsection