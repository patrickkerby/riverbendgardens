<?php
/*
Template Name: Winter CSA
*/
?>

<?php get_header(); ?>
<section id="shop-banner"></section>
	<nav id="csa-nav">
		<ul>
			<li class="first"><a href="/csa">Summer CSA</a></li>
			<li class="second"><a href="/csa/about">What is a CSA?</a></li>
			<li class="third"><a href="/csa/faq">FAQ</a></li>
			<li class="fourth"><a href="/csa/riverbend">Why Riverbend <span>Gardens?</span></a></li>
			<li class="fifth"><a href="/csa/locations">Pick Up Locations</a></li>		</ul>
	</nav>
	<div class="cbp-af-header">
	    <div class="cbp-af-inner">
		    <div class="wrapper">
		        <h1><span>I know about it already,</span> sign me up!</h1>
		        <nav>
	            	<a href="/product/wintercsa/">Winter CSA Sign up</span></a>
		        </nav>
	        </div>
	    </div>
	</div>
<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<div class="full-section part1">
		<div class="wrapper">
			<?php get_template_part( '_post', 'title' ); ?>
			<p>10 weeks, 5 deliveries. Full winter-season shares only (Sorry, no week-to-week orders available). </p>
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
			<a href="/csa/about">What is a CSA?</a>
		</div>
	</div>
	<div class="outerContainer">
		<div class="innerContainer">
			<a href="/csa/riverbend">Why Riverbend Gardens?</a>
		</div>
	</div>
	<div class="outerContainer">
		<div class="innerContainer">
			<a href="/contact">Get in touch</a>
		</div>
	</div>
</div>

<?php endwhile; ?>
<?php get_footer(); ?>
