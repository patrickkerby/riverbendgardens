<?php
/**
 * @package Basis Child
 */
?>

<?php get_header(); ?>
<section class="basis-list first banner last" style="background-image: url('https://riverbendcsa.ca/wp-content/themes/riverbend/images/hdr-cauliflower.jpg');">
	<div class="product-section">
				<div class="banner-title">
			<h2><?php basis_archives_title(); ?></h2>
		</div>
	</div>
</section>
<div class="post-content">
	<div class="post-wrapper">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( '_posts' ); ?>
			<?php endwhile; ?>
			<?php get_template_part( '_pagination', 'index' ); ?>
		<?php
		// No posts.
		else : ?>
			<?php get_template_part( '_posts', 'none' ); ?>
		<?php endif; ?>
	</div>
	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>