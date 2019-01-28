{{--
  Template Name: CSA Landing Page
--}}
@extends('layouts.app')

@php
$pagebreak = get_field('pagebreak_image');
$mapimage = get_field('map_image');
$season_length = get_field('season_length', 'option');
$locations_count = get_field('locations_count', 'option');
$pickup_dates = get_field('pickup_dates', 'options');
$first_week = get_field('first_pickup_day', 'options');
$product_intro = get_field('product_intro');

@endphp
  
  @section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-page')
		
		<div class="cta_primary cbp-af-header">
			<div class="cbp-af-inner">	
				@php if( have_rows('cta_primary') ):
					while( have_rows('cta_primary') ) : the_row();
						$button_label = get_sub_field('button_label');
						$button_url = get_sub_field('button_url'); @endphp			
				
						<a href="{{ $button_url }}">{{ $button_label }}</a>
					
					@php endwhile;
				endif; @endphp
			</div>
		</div>
		
	<section class="season_details">
		<h3>Season Length: <span>{{ $season_length }} Weeks</span></h3>
		<h3 data-toggle="tooltip" title="Tooltip on top">Season Start: <span>{{ $first_week }}</span></h3>
		<h3>Available in: <span>Two sizes</span></h3>
		<h3>Pickup day: <span>Thursdays</span></h3>
		<h3>Pickup Locations: <span>{{ $locations_count }} YEG & Area</span></h3>
	</section>
	<section class="intro row justify-content-center">
		<div class="col-md-9">
		<h2>{{ $product_intro	 }}</h2>
		</div>
	</section>
	<section id="map" class="map row no-gutters">
		<div class="partners-description col-md-4">
				@php the_field('partners_description'); @endphp
		</div>
	</section>
	<section class="locations row">
		<div class="side-nav col-sm-3">
			<h4>Locations</h4>
			<button data-toggle="collapse" class="btn btn-link show" data-target="#collapsePublic" role="button" aria-expanded="true" aria-controls="collapsePublic">Public Pickups</button>
			<button data-toggle="collapse" class="btn btn-link collapsed" data-target="#collapseSchool" role="button" aria-expanded="false" aria-controls="collapseSchool">School Fundraiser Pickups</button>
			<button data-toggle="collapse" class="btn btn-link collapsed" data-target="#collapseEmployee" role="button" aria-expanded="false" aria-controls="collapseEmployee">Employee-only Pickups</button>
		</div>
		<div class="location-cards col-sm-9" id="locations">
			<ul id="collapsePublic" class="collapse show" data-parent="#locations">
				@php
					if( have_rows('location_details', 'options') ):
					$count = 0;	
					// loop through data
					while ( have_rows('location_details', 'options') ) : the_row();
						if( get_sub_field('pickup_type') == 'public' ):
							
							$name = get_sub_field('name'); 
							$description = get_sub_field('description'); 
							
							// trigger for modal
							 echo '<li><a href="#" data-toggle="modal" data-target="#pickupModal-'.$count.'">'.$name.'</a></li>';
					
							// modal
							echo '<div class="modal fade" id="pickupModal-'.$count.'" tabindex="-1" role="dialog" aria-hidden="true">';
						@endphp

						<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h3>{{$name}}</h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<p>{{$description}}</p>
									</div>										
								</div>
							</div>
						</div>
					@php endif;
						// increase count
						$count++;
					endwhile;
					else :
						// no rows found
					endif;
					@endphp
			</ul>
			<ul id="collapseSchool" class="collapse collapseSchool" data-parent="#locations">
					@php
					if( have_rows('location_details', 'options') ):
					$count = 0;	
					// loop through data
					while ( have_rows('location_details', 'options') ) : the_row();
						if( get_sub_field('pickup_type') == 'school' ):
							
							$name = get_sub_field('name'); 
							$description = get_sub_field('description'); 
							
							// trigger for modal
							 echo '<li><a href="#" data-toggle="modal" data-target="#pickupModal-'.$count.'">'.$name.'</a></li>';
					
							// modal
							echo '<div class="modal fade" id="pickupModal-'.$count.'" tabindex="-1" role="dialog" aria-hidden="true">';
						@endphp

						<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h3>{{$name}}</h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<p>{{$description}}</p>
									</div>										
								</div>
							</div>
						</div>
					@php endif;
						// increase count
						$count++;
					endwhile;
					else :
						// no rows found
					endif;
					@endphp
			</ul>
			<ul id="collapseEmployee" class="collapse collapseEmployee" data-parent="#locations">
					@php
					if( have_rows('location_details', 'options') ):
					$count = 0;	
					// loop through data
					while ( have_rows('location_details', 'options') ) : the_row();
						if( get_sub_field('pickup_type') == 'employee' ):
							
							$name = get_sub_field('name'); 
							$description = get_sub_field('description'); 
							
							// trigger for modal
							 echo '<li><a href="#" data-toggle="modal" data-target="#pickupModal-'.$count.'">'.$name.'</a></li>';
					
							// modal
							echo '<div class="modal fade" id="pickupModal-'.$count.'" tabindex="-1" role="dialog" aria-hidden="true">';
						@endphp

						<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h3>{{$name}}</h3>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<p>{{$description}}</p>
									</div>										
								</div>
							</div>
						</div>
					@php endif;
						// increase count
						$count++;
					endwhile;
					else :
						// no rows found
					endif;
					@endphp
			</ul>				
		</div>
	</section>
	<div class="full-section part4">
		<h3>Two Sizes:</h3>
		<div class="bigger">
			<h4><strong>Bigger</strong> <span class="bignum"><?php the_field('csa_items_bigger'); ?></span> <span class="line1">items of peak-season Produce </span></h4>
			<?php the_field('bigger_csa_description'); ?>
		</div>
		<div class="smaller">
			<h4><strong>Smaller</strong> <span class="bignum"><?php the_field('csa_items_bigger'); ?></span> <span class="line1">items of peak-season Produce</span></h4>
			<?php the_field('smaller_csa_description'); ?>
		</div>
		<div id="slider">
			<p><?php the_field('season_expectations'); ?></p>
		</div>
	</div>
	<div class="full-section part5">
		<div class="wrapper">
			<h2>Price &amp; Value</h2>
			<div class="price"><span class="title smaller">Smaller</span>
				<span class="title bigger">Bigger</span>
				<hr />
				<h3>Full Season (15 weeks)</h3>
				<h4><span class="dolla">$</span><?php the_field('full_season_price_smaller'); ?> <span><?php the_field('full_season_per_week_cost_smaller'); ?> / week</span></h4>
				<h4><span class="dolla">$</span><?php the_field('full_season_price_bigger'); ?> <span><?php the_field('full_season_per_week_cost_bigger'); ?> / week</span></h4>
				<hr />
				<h3>Week to Week</h3>
				<h4><span class="dolla"><?php the_field('price_per_week_smaller'); ?></span> <span>per week</span></h4>
				<h4><span class="dolla"><?php the_field('price_per_week_bigger'); ?></span> <span>per week</h4>
			</div>
			<div class="info">
				<?php the_field('pricing_details'); ?>
			</div>
		</div>
	</div>
	<div class="full-section part2">
			<div class="wrapper">
				<ul>
					<?php if( have_rows('csa_steps') ):
							while ( have_rows('csa_steps') ) : the_row();
					?>
					<li><?php the_sub_field('csa_step'); ?></li>
					<?php    endwhile;
					else :
							// no rows found
					endif; ?>
				</ul>
			</div>
		</div>
	<div id="signup" class="full-section part6">

</div>
	<div class="full-section part7">
			<h4>Looking for more details?</h4>
	<div class="outerContainer">
		<div class="innerContainer">
			<a href="/faq">Frequently Asked Questions</a>
		</div>
	</div>
	<div class="outerContainer">
		<div class="innerContainer">
			<a href="/about">What is a CSA?</a>
		</div>
	</div>
	<div class="outerContainer">
		<div class="innerContainer">
			<a href="/riverbend">Why Riverbend Gardens?</a>
		</div>
	</div>
</div>

@endwhile
@endsection