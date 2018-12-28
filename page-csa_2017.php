<?php
/*
Template Name: CSA 2017
*/
?>

<?php get_header(); ?>
<section id="shop-banner"></section>
	<nav id="csa-nav">
		<ul>
			<li class="first active"><a href="#">How it works</a></li>
			<li class="second"><a href="/about">What is a CSA?</a></li>
			<li class="third"><a href="/faq">FAQ</a></li>
			<li class="fourth last"><a href="/riverbend">Why Riverbend <span>Gardens?</span></a></li>
			<li class="fifth"><a href="/locations">Pick Up Locations</a></li>		</ul>
	</nav>
<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<div class="post-content">
		<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			// Show the featured image and its caption and description if they are available.
			if ( ! post_password_required() && '' !== $featured_image_id = get_post_thumbnail_id() ) :
				$attachment = get_post( $featured_image_id );
				?>
			<div class="page-header">
				<?php echo wp_get_attachment_image( $attachment->ID, 'basis-featured-page' ); ?>
				<?php if ( $attachment->post_content ) : ?>
				<div class="page-header-description">
					<?php echo wpautop( basis_allowed_tags( $attachment->post_content ) ); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<div class="entry basis-list">
				<?php get_template_part( '_post', 'title' ); ?>
				<?php the_content(); ?>
			</div>
		</article>
	</div>
	<div class="cbp-af-header">
	    <div class="cbp-af-inner">
		    <div class="wrapper">
		        <h1><span>I know about it already, </span>sign me up!</h1>
		        <nav>
	            	<a href="/product/csa15week/">Full Season <span>(15 weeks)</span></a>
              <a href="/product/weekly/" class="wk">Week-to-Week</a>
		        </nav>
	        </div>
	    </div>
	</div>
	
	<div class="full-section part1">
		<div class="wrapper">
			<h1><span class="bignum">15</span> <span class="vert">weeks</span><span class="line1">of the freshest</span> <span class="line2">veggies</span><span class="line3">grown right here in Edmonton</span></h1>
			<div class="line4"><p>CSA season starts <?php the_field('start_date'); ?><strong>&bull;</strong> Pickup day is every Thursday!</p></div>
		</div>
	</div>
	<div class="full-section part2">
		<div class="wrapper">
			<img class="alignnone size-full wp-image-4360" src="https://riverbendcsa.ca/wp-content/uploads/2015/01/map-20151.png" alt="Riverbend Gardens CSA 2015" width="609" height="534" />
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
					<li><?php the_sub_field('pickup_location'); ?></li>
					<?php    endwhile;
					else :
					    // no rows found
					endif; ?>
				</ul>
			</div>
		</div>
	<div id="banner-green">
		<img class="aligncenter size-full wp-image-4087" src="https://riverbendcsa.ca/wp-content/uploads/2015/01/rbgplusyeg.png" alt="RBG Loves YEG!" />
	</div>	
	<div class="full-section part4">
		<h3>Two Sizes:</h3>
		<div class="wrapper">
			<div class="half bigger">
				<h4><strong>Bigger</strong> <span class="bignum"><?php the_field('csa_items_bigger'); ?></span> <span class="line1">items of peak-season Produce </span></h4>
				<?php the_field('bigger_csa_description'); ?>
			</div>
			<div class="half smaller">
				<h4><strong>Smaller</strong> <span class="bignum"><?php the_field('csa_items_bigger'); ?></span> <span class="line1">items of peak-season Produce</span></h4>
				<?php the_field('smaller_csa_description'); ?>
			</div>
			<div id="slider">
				<p><?php the_field('season_expectations'); ?></p>
			</div>
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
<?php endwhile; ?>
<?php get_footer(); ?>