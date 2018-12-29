<?php
/**
 * @package Basis Child
 */
 


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
  echo '<section id="shop-banner"></section><div class="post-content">
		<article id="shop">';
}

function my_theme_wrapper_end() {
  echo '		</article>
	</div>';
}

/*

** Remove tabs from product details page

*/

add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

unset( $tabs['additional_information'] ); // Remove the additional information tab

return $tabs;

}

remove_filter ('the_content', 'wpautop');

add_shortcode( 'iframe' , 'mycustom_shortcode_iframe' );
function mycustom_shortcode_iframe($args, $content) {
    $keys = array("src", "width", "height", "scrolling", "marginwidth", "marginheight", "frameborder");
    $arguments = mycustom_extract_shortcode_arguments($args, $keys);
    return '<iframe ' . $arguments . '></iframe>';
}

function mycustom_extract_shortcode_arguments($args, $keys) {
    $result = "";
    foreach ($keys as $key) {
        if (isset($args[$key])) {
            $result .= $key . '="' . $args[$key] . '" ';
        }
    }
    return $result;
}


/* unique single product templates */

add_filter( 'woocommerce_locate_template', 'so_25789472_locate_template', 10, 3 );

function so_25789472_locate_template( $template, $template_name, $template_path ){

    // on single posts with weekly category and only for single-product/something.php templates
    if( is_product() && has_term( 'weekly', 'product_cat' ) && strpos( $template_name, 'single-product/') !== false ){

        // replace single-product with single-product-weekly in template name
        $weekly_template_name = str_replace("single-product/", "single-product-weekly/", $template_name );

        // look for templates in the single-product-weekly/ folder
        $weekly_template = locate_template(
            array(
                trailingslashit( $template_path ) . $weekly_template_name,
                $weekly_template_name
            )
        );

        // if found, replace template with that in the single-product-weekly/ folder
        if ( $weekly_template ) {
            $template = $weekly_template;
        }
    }

    return $template;
}

/*

 * Hide "Products" in WooCommerce breadcrumb

 */

function woo_custom_filter_breadcrumbs_trail ( $trail ) {
  foreach ( $trail as $k => $v ) {
    if ( strtolower( strip_tags( $v ) ) == 'products' ) {
      unset( $trail[$k] );
      break;
    }
  }
  return $trail;
}

add_filter( 'woo_breadcrumbs_trail', 'woo_custom_filter_breadcrumbs_trail', 10 );

add_theme_support( 'woocommerce' );
 
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

// Change placeholder in the notes section of checkout
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     $fields['order']['order_comments']['placeholder'] = 'Any notes or comments you would like us to see?';
     return $fields;
}

/** 
 * Manipulate default state and countries
 * 
 * As always, code goes in your theme functions.php file
 */
add_filter( 'default_checkout_state', 'change_default_checkout_state' );
 
function change_default_checkout_state() {
  return 'AB'; // state code
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_referral_field_display_admin_order_meta', 10, 1 );
 
function my_referral_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Referral').':</strong> ' . get_post_meta( $order->id, 'referral', true ) . '</p>';
}

add_filter( 'woocommerce_shop_order_search_fields', 'woocommerce_shop_order_search_order_total' );
 
function woocommerce_shop_order_search_order_total( $search_fields ) {
 
  $search_fields[] = 'referral';
 
  return $search_fields;
 
}

/** Add sticky nav script **/
function add_modernizr() {
wp_register_script('modernizr_script', get_stylesheet_directory_uri() . '/js/modernizr.custom.js', array(), '1.0.0', false);
wp_enqueue_script('modernizr_script');
}
function add_classie() {
wp_register_script('classie', get_stylesheet_directory_uri() . '/js/classie.js', array(), '1.0.0', true);
wp_enqueue_script('classie');
}
function add_stickynav() {
wp_register_script('stickynav_script', get_stylesheet_directory_uri() . '/js/stickynav.js', array(), '1.0.0', true);
wp_enqueue_script('stickynav_script');
}

add_action( 'wp_enqueue_scripts', 'add_modernizr' );  
add_action( 'wp_enqueue_scripts', 'add_classie' );  
add_action( 'wp_enqueue_scripts', 'add_stickynav' );  


function riverbend_fonts() { 
    wp_enqueue_style(
    'riverbend_fonts',
    get_stylesheet_directory_uri() . '/NexaWebFonts/Nexa.css',
    array(),
    '1.0.0' 
);
}
add_action( 'wp_enqueue_scripts', 'riverbend_fonts' );

function footable_style() { 
    wp_enqueue_style(
    'footable_style',
    get_stylesheet_directory_uri() . '/footable.standalone.min.css',
    array(),
    '1.0.0'
);
}
add_action( 'wp_enqueue_scripts', 'footable_style' );

/**
 * Optimize WooCommerce Scripts
 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
 */
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
 
function child_manage_woocommerce_styles() {
	//remove generator meta tag
	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
 
	//first check that woo exists to prevent fatal errors
	if ( function_exists( 'is_woocommerce' ) ) {
		//dequeue scripts and styles
		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
			wp_dequeue_style( 'woocommerce_frontend_styles' );
			wp_dequeue_style( 'woocommerce_fancybox_styles' );
			wp_dequeue_style( 'woocommerce_chosen_styles' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'wc_price_slider' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'wc-cart-fragments' );
			wp_dequeue_script( 'wc-checkout' );
			wp_dequeue_script( 'wc-add-to-cart-variation' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-cart' );
			wp_dequeue_script( 'wc-chosen' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'jquery-placeholder' );
			wp_dequeue_script( 'fancybox' );
			wp_dequeue_script( 'jqueryui' );
		}
	}
} 

// Add ACF options page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

add_action( 'wp_enqueue_scripts', 'mytheme_scripts' );
/**
 * Enqueue Dashicons style for frontend use
 */
function mytheme_scripts() {
	wp_enqueue_style( 'dashicons' );
}