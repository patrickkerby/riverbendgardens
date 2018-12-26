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
	<title><?php wp_title( ' | ', true, 'right' ); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
	<script type="text/javascript" src="https://riverbendcsa.ca/wp-content/themes/riverbend/js/footable.min.js"></script>
	<link rel="shortcut icon" href="https://riverbendcsa.ca/favicon.icns">

	<script type="text/javascript">
( function($) {
		$(document).ready(function(){
	    $("select").change(function(){
	        $(this).find("option:selected").each(function(){
	            var optionValue = $(this).attr("value");
	            if(optionValue){
	                $(".week").not("." + optionValue).hide();
	                $("." + optionValue).show();
	            } else{
	                $(".week").hide();
	            }
	        });
	    }).change();
	});
	} ) ( jQuery );
	</script>

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

