<?php
/**
 * @package Basis Child
 */

global $basis_section_data;
$order = basis_get_html_builder()->get_featured_section_order( $basis_section_data ); ?>
<section class="product-section basis-list <?php echo esc_attr( basis_get_html_builder()->section_classes() ); ?>">
	<div class="wrapper">
	<div class="feature-image <?php echo esc_attr( $order['image'] ); ?>">
		<figure><?php echo wp_get_attachment_image( $basis_section_data['image-id'], 'basis-featured-page' ); ?></figure>
	</div>
	<div class="feature-content <?php echo esc_attr( $order['text'] ); ?>">
		<?php if ( ! empty( $basis_section_data['title'] ) ) : ?>
		<h3 class="feature-section-title"><?php echo basis_allowed_tags( $basis_section_data['title'] ); ?></h3>
		<?php endif; ?>

		<?php if ( ! empty( $basis_section_data['content'] ) ) : ?>
		<?php basis_get_html_builder()->the_builder_content( $basis_section_data['content'] ); ?>
		<?php endif; ?>

	</div>
	</div>
</section>