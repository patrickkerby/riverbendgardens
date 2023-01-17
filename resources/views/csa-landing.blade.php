{{--
  Template Name: CSA Landing Page
--}}
@extends('layouts.app')

@php
$csa_type = get_field('csa_type');
$pagebreak = get_field('pagebreak_image');
$mapimage = get_field('map_image');
$season_length = get_field('season_length', 'option');
$locations_count = get_field('locations_count', 'option');
$pickup_dates = get_field('pickup_dates', 'options');
$first_week = get_field('first_pickup_day', 'options');
$season_length_late_season = get_field('season_length_late_season', 'option');
$locations_count_late_season = get_field('locations_count_late_season', 'option');
$pickup_dates_late_season = get_field('pickup_dates_late_season', 'options');
$first_week_late_season = get_field('first_pickup_day_late_season', 'options');
$product_intro = get_field('product_intro');
$partners_description = get_field('partners_description');

//Product Sizing and Pricing
$csa_items_bigger = get_field('csa_items_bigger');
$csa_description_bigger = get_field('bigger_csa_description');
$price_season_bigger = get_field('full_season_price_bigger');
$csa_items_smaller = get_field('csa_items_smaller');
$csa_description_smaller = get_field('smaller_csa_description');
$include_weeklies = get_field('include_weeklies');
$price_season_smaller = get_field('full_season_price_smaller');

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
				@if( have_rows('cta_primary') )
					@foreach ($cta_primary as $item)
						<a href="{{ $item->button_url }}">{{ $item->button_label }}</a>
					@endforeach
				@endif
			</div>
		</div>
	
@if ($csa_type === 'regular')		
	<section class="season_details">
		<h5>Season Length: <span>{{ $season_length }} Weeks</span></h5>
		<h5>Season Start: <span>{{ $first_week }}</span></h5>
		<h5>Available in: <span>Two sizes</span></h5>
		<h5>Pickup day: <span>Thursdays</span></h5>
		<h5>Pickup Locations: <span>{{ $locations_count }} YEG & Area</span></h5>
	</section>
@else
<section class="season_details">
	<h5>Season Length: <span>{{ $season_length_late_season }} Weeks</span></h5>
	<h5>Season Start: <span>{{ $first_week_late_season }}</span></h5>
	<h5>Available in: <span>Two sizes</span></h5>
	<h5>Pickup day: <span>Thursdays</span></h5>
	<h5>Pickup Locations: <span>{{ $locations_count_late_season }} YEG & Area</span></h5>
</section>
@endif
	<section class="intro row justify-content-center">
		<div class="col-md-9">
		<h2>{{ $product_intro	}}</h2>
		</div>
	</section>
	<section id="map" class="map row no-gutters">
		<div class="partners-description col-md-4 d-none d-sm-block">
			{!! $partners_description !!}
		</div>
	</section>
	<section class="locations row no-gutters">
		@include('partials.locations-csa-landing')
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
			@if( have_rows('csa_steps') )
				@foreach ($csa_steps as $item)			
					<div class="carousel-item">	
						<p>{{ $item->csa_step }}</p>
					</div>
				@endforeach
			@endif
		</div>
	</section>
	<section class="row sizes">
		@if ($csa_type === 'regular')
			<h2 class="col-12">Available for full season or bi-weekly:</h2>
		@else
			<h2 class="col-12">Available in two sizes:</h2>
		@endif
		
		@if ($csa_type === 'regular')		
			{{-- Pricing: Bi-weekly --}}
			@if ($csa_items_biweekly)
			<div class="col-md-4 d-flex flex-wrap">
				<div class="ghost">
					<h3>Bi-weekly Bounty</h3>
					<h4>{{ $csa_items_biweekly }}</h4>			
					{!! $biweekly_csa_description !!}
					<div class="row pricing">
						<div class="col-md-12">
							<div>
								<h5>Bi-weekly (7 weeks)</h5>
								<p><span>${{ $full_season_price_biweekly }}</span></p>
								<a href="{{ $season_product_biweekly }}" class="button">Purchase</a> 
							</div>
						</div>
					</div>
				</div>
			</div>	
			@endif
		@endif

		{{-- Pricing: Smaller --}}
		@if ($csa_type === 'regular')
			<div class="col-md-4 d-flex flex-wrap">	
		@else
			<div class="col-md-6 d-flex flex-wrap">	
		@endif
			<div class="ghost">
				<h3>Smaller Bounty</h3>
				@if ($csa_type === 'regular')
					<h4>{{ $csa_items_smaller }}</h4>
				@else
					<h4>Great for small households!</h4>
				@endif				
				{!! $smaller_csa_description !!}
				<div class="row pricing">
				@if ( $include_weeklies )	
					<div class="col-md-6">
						<div>
							<h5>Week-to-week</h5>
							<p><span>${{ $price_per_week_smaller }}</span></p>
							<a href="{{ $product_page_weekly }}" class="button">Purchase</a> 						
						</div>
					</div>
					<div class="col-md-6">
						<div>
							@if ($csa_type === 'regular')
								<h5>Full Season (14 Weeks)</h5>
							@endif
							<p><span>${{ $price_season_smaller }}</span></p>
							<a href="{{ $product_page_season }}" class="button">Purchase</a> 
						</div>
					</div>
					@else
					<div class="col-md-12">
						<div>
							@if ($csa_type === 'regular')
								<h5>Full Season (14 Weeks)</h5>
							@endif
							<p><span>${{ $price_season_smaller }}</span></p>								
							<a href="{{ $product_page_season }}" class="button">Purchase</a> 
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>	

		{{-- Pricing: Bigger --}}
		@if ($csa_type === 'regular')
			<div class="col-md-4 d-flex flex-wrap">	
		@else
			<div class="col-md-6 d-flex flex-wrap">	
		@endif

			<div class="ghost">
				<h3>Bigger Bounty</h3>
				@if ($csa_type === 'regular')
					<h4>{{ $csa_items_bigger }}</h4>
				@else
					<h4>Great for veggie-focussed households.</h4>
				@endif
				{!! $bigger_csa_description !!}
				<div class="row pricing">
				@if ( $include_weeklies )	
				<div class="col-md-6">
					<div>
						<h5>Week-to-week</h5>
						<p><span>${{ $price_per_week_bigger }}</span></p>
						<a href="{{ $product_page_weekly }}" class="button">Purchase</a> 						
					</div>
				</div>
					<div class="col-md-6">
						<div>
							@if ($csa_type === 'regular')
								<h5>Full Season (14 Weeks)</h5>
							@endif
							<p><span>${{ $price_season_bigger }}</span></p>
							<a href="{{ $product_page_season }}" class="button">Purchase</a> 
						</div>
					</div>
				@else
					<div class="col-md-12">
						<div>
							@if ($csa_type === 'regular')
								<h5>Full Season (14 Weeks)</h5>
							@endif
							<p><span>${{ $price_season_bigger }}</span></p>
							<a href="{{ $product_page_season }}" class="button">Purchase</a> 
						</div>
					</div>
				@endif
				</div>
			</div>
		</div>
		@if ( $include_weeklies )	
		{{-- Pricing: Weekly --}}
		<div class="col-md-12 weekly">
			<div class="ghost">
				<a class="row" href="{{ $product_page_weekly }}">
					<h3 class="col-md-3">Week-to-week</h3>
					<p class="col-md-9">Not around all summer? Want to choose which weeks of the season to pickup? <br /><span>Our Week-To-Week option is for you.</span> (Sold out for 2020)</p>
				</a>
			</div>
		</div>
		@endif

		{{-- Pricing: Weekly --}}
		<div class="row season_expectations justify-content-center">
			<div class="col-md-9">{!! $season_expectations !!}</div>
		</div>
	</section>	

	{{-- Photo Gallery --}}
	<section class="row photos no-gutters">			
		@if( $gallery )
			<div class="row gallery">
				@foreach( $gallery as $item )
					<div class="col-md-3 col-sm-4 col-xs-6">
						<a href="{{ $item->url }}" target="_blank">
							<img src="{{ $item->sizes->thumbnail }}" alt="{{ $item->alt }}" />
						</a>
					</div>
				@endforeach
			</div>
		@endif

	</section>
@endwhile
@endsection
