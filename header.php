<?php
/**
 * @package Basis Child
 */
?>

<!DOCTYPE html>
<!--[if IE 7]>    <html class="no-js IE7 IE" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js IE8 IE" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>    <html class="no-js IE9 IE" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-PGPJGB4');</script>
	<!-- End Google Tag Manager -->

	<title><?php wp_title( ' | ', true, 'right' ); ?></title>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<?php wp_head(); ?>
	<link rel="shortcut icon" href="favicon.icns">
	<link rel="stylesheet" type="text/css" href="app/themes/riverbend/foundation-icons/foundation-icons.css">
	<meta name="google-site-verification" content="u1ou0Mch5lP6Rv2f3xO8L_VQJ6NSYBKQpp0nHWJ5kTs" />
    <!--[if lte IE 8]><script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PGPJGB4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Hotjar Tracking Code for www.riverbendcsa.ca -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:693981,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
<?php
/**
 * Allow the header to be hidden. The HTML Builder allows the user to hide the header in order to make a microsite or
 * landing page. It uses this filter to control that behavior. Additionally, plugins or child themes can further
 * customize this behavior via the filter.
 */
?>
<?php if ( true === basis_show_header() ) : ?>
<header id="header">
	<div class="header-wrapper">
		<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'header',
					'container_id'    => 'basis-header-nav',
					'container_class' => 'header-menu-container',
					'menu_class'      => 'header-menu',
					'depth'           => '2'
				)
			);
		?>
		<div id="mobile-toggle">
			<span><?php echo wp_strip_all_tags( basis_get_responsive_nav_options( 'label' ) ); ?> </span><i class="fi-list"></i>
		</div>
		<div id="title">
		<?php if ( basis_get_logo()->has_logo() ) : ?>
			<a class="custom-logo" title="<?php esc_attr_e( 'Home', 'basis' ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"></a>
		<?php else : ?>
			<h1>
				<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
			</h1>
		<?php endif; ?>
		</div>
	</div>
</header>
<?php endif; ?>