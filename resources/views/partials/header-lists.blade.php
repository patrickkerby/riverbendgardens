<!DOCTYPE html>
<!--[if IE 7]>    <html class="no-js IE7 IE" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js IE8 IE" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>    <html class="no-js IE9 IE" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<title><?php wp_title( ' | ', true, 'right' ); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
	<link rel="shortcut icon" href="favicon.icns">	
</head>
<body id="list" <?php body_class(); ?>>
	<nav>
		<?php
		if($post->post_parent)
			$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
		else
			$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
		if ($children) { ?>
			<ul>
				<li><a href="../">Lists Index</a></li>
				<?php echo $children; ?>
			</ul>
		<?php } ?>
	</nav>

