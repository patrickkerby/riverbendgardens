{{--
  Template Name: Delivery List - Late Season
--}}

@extends('layouts.app')

{{-- @include('partials.list-functions') --}}

@php

//List of global variables

$year = "CSA 2019 - 15 week";
$school = "School CSA";
$late_season = "Late Season CSA"

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
 

    <section class="week week1">
      <h2>Late-Season Delivery List</h2>
      <p>Clear = Bigger  /  White = Smaller.<br /> These numbers <em>include</em> extras.</p>
			<table class="table footable">
				<thead>
          <tr>
            <th>Delivery Time</th>
						<th scope="col">Location</th>
            <th data-type="number" scope="col">Clear Bags</th>
            <th data-type="number" scope="col">White Bags</th>
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
            
            $product_season = wc_get_product( 5958 );
            $late_season_product = wc_get_product( 5484 );						

            $bigger_count = 0;
            $smaller_count = 0;          

            $bigger_count_total = 0;
            $smaller_count_total = 0;            
        
        
            // get delivery route locations
    
            if( have_rows('select_locations') ):
              while( have_rows('select_locations') ): the_row(); 

                // vars
                $route_location = get_sub_field('location');
                $custom_location_name = get_sub_field('custom_location_name');
                $delivery_time = get_sub_field('delivery_time');
                $extras = get_sub_field('extras');
                

                if($route_location):
                  $delivery_location = $route_location->name;                  
                elseif($custom_location_name): 
                  $delivery_location = get_sub_field('custom_location_name');
                endif;

                if($extras):
                  $extras = '1';
                else:
                  $extras = '0';
                endif;
                
                
                $location_esc = addslashes($delivery_location);

                $sql_str = '';
                $sql_str = ( "
                  SELECT COUNT(Q2.bigger_count) AS bigger_count, COUNT(Q3.smaller_count) AS smaller_count, COUNT(Q1.order_id) AS total_count
                  FROM		
                    (	SELECT order_id, $order_items.order_item_id AS order_item_id, $order_meta.meta_key, $order_meta.meta_value AS location_value
                      FROM $order_items, $order_meta
                      WHERE $order_items.order_item_id = $order_meta.order_item_id
                      AND $order_meta.meta_value = '$location_esc'
                      AND ($order_items.order_item_name LIKE '$late_season%')
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
			
                $bigger_count = $row->bigger_count;
                $smaller_count = $row->smaller_count;

                $bigger_count = $bigger_count+$extras;
                  
                @endphp
                <tr>
                  <td>{{ $delivery_time }}</td>
                  <td><strong>{{ $delivery_location }}</strong></td>
                  <td>{{ $bigger_count }}</td>                  
                  <td>{{ $smaller_count }}</td>                  
                </tr>
              
            @php
              $bigger_count_total += $bigger_count;
              $smaller_count_total += $smaller_count;              
            endwhile;              
          endif;													
        @endphp																								
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