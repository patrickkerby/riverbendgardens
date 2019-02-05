<?php
/*
Template Name: CSA - Home Delivery
*/
?>

<?php get_header(); ?>
<section id="shop-banner"></section>
	<nav id="csa-nav">
		<ul>
			<li class="first"><a href="/csa">How it works</a></li>
			<li class="second"><a href="/csa/about">What is a CSA?</a></li>
			<li class="third"><a href="/csa/faq">FAQ</a></li>
			<li class="fourth active"><a href="/csa/riverbend">Why Riverbend <span>Gardens?</span></a></li>
			<li class="fifth"><a href="/csa/winter-csa">Winter CSA</a></li>
		</ul>
	</nav>
	<div class="cbp-af-header">
	    <div class="cbp-af-inner">
		    <div class="wrapper">
		        <h1><span>I know about it already, </span>sign me up!</h1>
		        <nav>
	            	<a href="/csa/location-15wk/">Full Season <span>(15 weeks)</span></a>
					<a href="/csa/location-wk/" class="wk">Week-to-Week</a>
		        </nav>
	        </div>
	    </div>
	</div>
<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<div class="full-section part1">
		<div class="wrapper">
			<?php get_template_part( '_post', 'title' ); ?>
			<p>We love to give you a weekly excuse to visit our partner locations but we also understand that life can be busy. If you struggle to make it to your pick up location before close or have limitations on your transportation or mobility, getting your veggies dropped off at your door could mean a world a difference. We want our veggies to be as accessible as possible for you and so we’re happy to partner this year with The Organic Box to bring the goodness of Riverbend to your door.</p>
		</div>
		</div>
	</div>
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
				<?php the_content(); ?>
			</div>
		</article>
	</div>
	<div class="full-section part7">
			<h4>Looking for more details?</h4>
	<div class="outerContainer">
		<div class="innerContainer">
			<a href="/csa">How it works</a>
		</div>
	</div>
	<div class="outerContainer">
		<div class="innerContainer">
			<a href="/csa/faq">Frequently Asked Questions</a>
		</div>
	</div>
	<div class="outerContainer">
		<div class="innerContainer">
			<a href="/csa/about">What is a CSA?</a>
		</div>
	</div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
