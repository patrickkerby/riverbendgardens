<?php
/*
Template Name: CSA FAQ
*/
?>

<?php get_header(); ?>
<section id="shop-banner"></section>
	<nav id="csa-nav">
		<ul>
			<li class="first"><a href="<?php echo home_url(); ?>">How it works</a></li>
			<li class="second"><a href="/about">What is a CSA?</a></li>
			<li class="third active"><a href="#">FAQ</a></li>
			<li class="fourth"><a href="/riverbend">Why Riverbend <span>Gardens?</span></a></li>
			<li class="fifth"><a href="/locations">Pick Up Locations</a></li>
		</ul>
	</nav>
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
<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>
	<div class="full-section part1">
		<div class="wrapper">
			<?php get_template_part( '_post', 'title' ); ?>
			<p>We've tried our best to make our CSA program as simple and straight-forward as possible. That being said, we'll try and clear up any details or "what if" scenarios here! If you have a question that's not answered here please <a href="/contact">email us</a> and we'll get right back to you! </p>
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
			<a href="<?php echo site_url(); ?>">How it works</a>
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
