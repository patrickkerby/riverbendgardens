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
$partners_description = get_field('partners_description');

//Product Sizing and Pricing
$csa_items_bigger = get_field('csa_items_bigger');
$csa_description_bigger = get_field('bigger_csa_description');
$price_weekly_bigger = get_field('price_per_week_bigger');
$price_season_bigger = get_field('full_season_price_bigger');
$price_season_bigger_perweek = get_field('full_season_per_week_cost_bigger');
$csa_items_smaller = get_field('csa_items_smaller');
$csa_description_smaller = get_field('smaller_csa_description');
$price_weekly_smaller = get_field('price_per_week_smaller');
$price_season_smaller = get_field('full_season_price_smaller');
$price_season_smaller_perweek = get_field('full_season_per_week_cost_smaller');

//Product Purchase Pages
$product_page_weekly = get_field('weekly_product_bigger');
$product_page_season = get_field('season_product_bigger');
//@TODO figure out how to get the size attribute set, then make variables for bigger and smaller


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
		<h5>Season Length: <span>{{ $season_length }} Weeks</span></h5>
		<h5 data-toggle="tooltip" title="Tooltip on top">Season Start: <span>{{ $first_week }}</span></h5>
		<h5>Available in: <span>Two sizes</span></h5>
		<h5>Pickup day: <span>Thursdays</span></h5>
		<h5>Pickup Locations: <span>{{ $locations_count }} YEG & Area</span></h5>
	</section>
	<section class="intro row justify-content-center">
		<div class="col-md-9">
		<h2>{{ $product_intro	}}</h2>
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
			<div id="collapsePublic" class="collapse show" data-parent="#locations">
				<h5>Public Pickup Locations</h5>
				<ul>
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
			</div>
			<div id="collapseSchool" class="collapse collapseSchool" data-parent="#locations">
					<h5>School Fundraiser Pickup Locations</h5>
					<ul>
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
			</div>
			<div id="collapseEmployee" class="collapse collapseEmployee" data-parent="#locations">
					<h5>Employee-only Pickup Locations</h5>
					<ul>
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
									<a href="">Sign up for Full Season at {{ $name }}</a>
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
		</div>
	</section>
	<section id="carouselExampleIndicators" class="carousel slide row no-gutters" data-ride="carousel">
		<h5>How does it work?</h5>	
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
		</ol>
		<div class="carousel-inner col-md-6">
			<div class="carousel-item active">	
			<h2>So how does this work? <br>What makes it so great?</h2>
			</div>
			
			@php if( have_rows('csa_steps') ):
				while ( have_rows('csa_steps') ) : the_row(); 
				$csa_step = get_sub_field('csa_step'); 
			@endphp
			<div class="carousel-item">	
				<p>{{ $csa_step }}</p>
			</div>
			@php endwhile;
				else :
					// no rows found
				endif;
			@endphp
		</div>
	</section>

	<section class="row sizes">
		<h2 class="col-12">Available in two sizes:</h2>
		<div class="col-md-6">
			<div class="ghost">
				<h3>Smaller Bounty</h3>
				<h4>{{ $csa_items_smaller }} items of peak-season produce</h4>
				@php the_field('smaller_csa_description'); @endphp
				<div class="row pricing">
					<div class="col-md-6">
						<div>
							<h5>Week-to-week</h5>
							<p><span>${{ $price_weekly_smaller }}</span> per week</p>
							<a href="{{ $product_page_weekly }}" class="button">Purchase</a> 						
						</div>
					</div>
					<div class="col-md-6">
						<div>
							<h5>Full Season</h5>
							<p><span>${{ $price_season_smaller }}</span> ${{ $price_season_smaller_perweek }} per week</p>
							<a href="{{ $product_page_season }}" class="button">Purchase</a> 
						</div>
					</div>
				</div>
			</div>
		</div>	
		<div class="col-md-6">	
			<div class="ghost">
				<h3>Bigger Bounty</h3>
				<h4>{{ $csa_items_bigger }} items of peak-season produce</h4>
				@php the_field('bigger_csa_description'); @endphp
				<div class="row pricing">
					<div class="col-md-6">
						<div>
							<h5>Week-to-week</h5>
							<p><span>${{ $price_weekly_bigger }}</span> per week</p>
							<a href="{{ $product_page_weekly }}" class="button">Purchase</a> 						
						</div>
					</div>
					<div class="col-md-6">
						<div>
							<h5>Full Season</h5>
							<p><span>${{ $price_season_bigger }}</span> ${{ $price_season_bigger_perweek }} per week</p>
							<a href="{{ $product_page_season }}" class="button">Purchase</a> 
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row season_expectations justify-content-center">
				<div class="col-md-8">@php the_field('season_expectations'); @endphp</div>
		</div>
	</section>	
	<section class="row photos no-gutters">

			@php 

			$images = get_field('gallery');
			
			if( $images ): @endphp
					<div class="row gallery">
							@php foreach( $images as $image ): @endphp
									<div class="col-md-3 col-sm-6">
											<a href="@php echo $image['url']; @endphp" target="_blank">
													 <img src="@php echo $image['sizes']['thumbnail']; @endphp" alt="@php echo $image['alt']; @endphp" />
											</a>
									</div>
							@php endforeach; @endphp
					</div>
			@php endif;		
			@endphp

	</section>
@endwhile
@endsection