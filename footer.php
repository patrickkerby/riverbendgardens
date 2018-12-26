<?php
/**
 * @package Basis Child
 */
?>
<footer id="footer">
	<div class="footer-wrapper">
		<img class="foot-logo" src="/wp-content/themes/riverbend/images/logo-sh.png" />
		<?php basis_maybe_show_footer_widgets(); ?>
		<div class="secondary">
		<section class="fine-print">
			<?php $footer_text = get_theme_mod( 'footer-text' ); ?>
			<?php if ( ! empty( $footer_text ) ) : ?>
			<p class="footer-text">
				<?php echo basis_allowed_tags( $footer_text ); ?>
			</p>
			<?php endif; ?>
			
		</section>

		<?php $social_links = basis_get_social_links(); ?>
		<?php if ( ! empty( $social_links ) ) : ?>
		<ul id="social" class="icons">
			<?php foreach ( $social_links as $service_name => $details ) : ?>
			<li>
				<a class="<?php echo esc_attr( $service_name ); ?>" href="<?php echo esc_url( $details['url'] ); ?>" title="<?php echo esc_attr( $details['title'] ); ?>"></a>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		</div>
	</div>
</footer>

</div>
<?php wp_footer(); ?>

</body>
</html>