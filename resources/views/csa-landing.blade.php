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

if( have_rows('pickup_dates', 'option') ):
	while( have_rows('pickup_dates', 'option') ): the_row();
		$week = get_sub_field('week');
	endwhile;
endif;

$first_week = $week[0]

@endphp
  
  @section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-page')

	<section class="row">
		<h3>Season Length: <span>{{ $season_length }} Weeks</span></h3>
		<h3>Season Start: <span>{{ $first_week }}</span></h3>
		<h3>Available in: <span>Two sizes</span></h3>
		<h3>Pickup day: <span>Thursdays</span></h3>
		<h3>Pickup Locations: <span>{{ $locations_count }}</span></h3>
	
	</section>

	<div class="full-section part2">
		<div class="wrapper">
			<img class="alignnone size-full wp-image-4360" src="<?php echo $mapimage; ?>" alt="Riverbend Gardens CSA 2019" width="609" height="534" />
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
	<div class="full-section part3">
		<div class="wrapper">
			<!-- <h2>We Partner with <span class="line1">awesome</span><strong>local businesses</strong><span class="line2">who share our values and care about building Edmonton?s food economy.</span></h2> -->
			<?php the_field('partners_description'); ?>
			<div class="locations">
				<ul>
					<?php if( have_rows('locations') ):
					    while ( have_rows('locations') ) : the_row();
					?>
					<li><a href="<?php the_sub_field('location_website'); ?>" target="_blank" ><?php the_sub_field('pickup_location'); ?></a></li>
					<?php endwhile;
					else :
					    // no rows found
					endif; ?>
				</ul>
			</div>
		</div>
		<div id="banner-green">
			<img class="aligncenter size-full wp-image-4087" src="<?php echo $pagebreak; ?>" alt="RBG Loves YEG!" />
		</div>
	</div>
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