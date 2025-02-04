<?php

namespace App;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files
 */
collect([
    'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment'
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

/**
 * Remove related products output
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter( 'woocommerce_composite_force_old_style_price_html', '__return_true' );


/**
 * Add custom field to the checkout
 */
add_action( 'woocommerce_after_order_notes', 'App\custom_checkout_field_pickupname' );

function custom_checkout_field_pickupname( $checkout ) {

    echo '<div id="custom_checkout_field_pickupname"><h2>' . __('Pickup Details') . '</h2>';

    woocommerce_form_field( 'pickup_name', array(
        'type'          => 'text',
        'class'         => array('pickup-names form-row-wide'),
        'label'         => __('Name(s) of those who will pickup this CSA'),
        'placeholder'   => __('Your name + anyone else who may pickup'),
        ), $checkout->get_value( 'pickup_name' ));

    echo '</div>';
}
    /**
     * Update the order meta with field value
     */
    add_action( 'woocommerce_checkout_update_order_meta', 'App\custom_checkout_field_pickupname_update_order_meta' );

    function custom_checkout_field_pickupname_update_order_meta( $order_id ) {
        if ( ! empty( $_POST['pickup_name'] ) ) {
            update_post_meta( $order_id, 'Pickup Name(s)', sanitize_text_field( $_POST['pickup_name'] ) );
        }
    }

    /**
     * Display field value on the order edit page
     */
    add_action( 'woocommerce_admin_order_data_after_billing_address', 'App\custom_checkout_field_pickupname_display_admin_order_meta', 10, 1 );

    function custom_checkout_field_pickupname_display_admin_order_meta($order){
        echo '<p><strong>'.__('Pickup Name(s)').':</strong> ' . get_post_meta( $order->id, 'Pickup Name(s)', true ) . '</p>';
    }
    


/**
 * Add custom field to the checkout
 */
add_action( 'woocommerce_after_order_notes', 'App\custom_checkout_field_referral' );

function custom_checkout_field_referral( $checkout ) {

    echo '<div id="custom_checkout_field_referral"><h2>' . __('Referral Info:') . '</h2>';

    woocommerce_form_field( 'referral', array(
        'type'          => 'email',
        'class'         => array('referral-names form-row-wide'),
        'label'         => __('Email Address of who referred you'),
        'placeholder'   => __('example@test.com'),
        'required'      => false,
        ), $checkout->get_value( 'referral' ));

    woocommerce_form_field( 'referral-code', array(
        'type'          => 'text',
        'class'         => array('referral-names form-row-wide'),
        'label'         => __('Referral Code'),
        'placeholder'   => __('CSA2023-XXXXXX'),
        'required'      => false,
        ), $checkout->get_value( 'referral-code' ));

    echo '</div>';
}
    /**
     * Update the order meta with field value
     */
    add_action( 'woocommerce_checkout_update_order_meta', 'App\custom_checkout_field_referral_update_order_meta' );

    function custom_checkout_field_referral_update_order_meta( $order_id ) {
        if ( ! empty( $_POST['referral'] ) ) {
            update_post_meta( $order_id, 'referral', sanitize_text_field( $_POST['referral'] ) );
        }
        if ( ! empty( $_POST['referral-code'] ) ) {
            update_post_meta( $order_id, 'referral-code', sanitize_text_field( $_POST['referral-code'] ) );
        }
    }

    /**
     * Display field value on the order edit page
     */
    add_action( 'woocommerce_admin_order_data_after_billing_address', 'App\custom_checkout_field_referral_display_admin_order_meta', 10, 1 );

    function custom_checkout_field_referral_display_admin_order_meta($order){
        echo '<p><strong>'.__('Referral Email').':</strong> ' . get_post_meta( $order->id, 'referral', true ) . '</p>';
        echo '<p><strong>'.__('Referral Code').':</strong> ' . get_post_meta( $order->id, 'referral-code', true ) . '</p>';
    }
    
    
add_filter( 'woocommerce_checkout_fields' , 'App\bbloomer_simplify_checkout_virtual' );
 
function bbloomer_simplify_checkout_virtual( $fields ) {
    
   $only_virtual = true;
    
   foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
      // Check if there are non-virtual products
      if ( ! $cart_item['data']->is_virtual() ) $only_virtual = false;   
   }
     
    if( $only_virtual ) {
       unset($fields['billing']['billing_company']);
       unset($fields['billing']['billing_address_1']);
       unset($fields['billing']['billing_address_2']);
       unset($fields['billing']['billing_city']);
       unset($fields['billing']['billing_postcode']);
       unset($fields['billing']['billing_country']);
       unset($fields['billing']['billing_state']);
       unset($fields['billing']['billing_phone']);
       add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
     }
     
     return $fields;
}

// Remove the Private: prefix from titles
add_filter('private_title_format', 'App\remove_private_prefix');
function remove_private_prefix($format) {
    return '%s';
}

// ----------  ADDITIONAL FEES

// Add fee to cart if product pickup location is set to home delivery
add_action('woocommerce_cart_calculate_fees', 'App\delivery_fee');

function delivery_fee() {
	if (is_admin() && !defined('DOING_AJAX')) {
		return;
	}
 
    $customer_data = WC()->session->get('customer');
    $billing_city = $customer_data['city'];

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $product_id = $cart_item['product_id'];
        $variation_pickup_location = $cart_item['variation']['attribute_pa_pickup-location'];

        // Set fee for fullseason
        if($product_id == 5958) {
            $delivery_fee = 168;
        }

        // Set fee for biweekly
        if($product_id == 87354 || $product_id == 103905) {
            $delivery_fee = 168;
        }

        if ($billing_city != NULL && $variation_pickup_location == 'home-delivery') {

            if($billing_city == 'Edmonton') {
                WC()->cart->add_fee(__('Home Delivery Fee (Edmonton)', 'txtdomain'), $delivery_fee, true);
                WC()->session->set('delivery_error', false);

            }
            elseif($billing_city == 'Sherwood Park') {
                WC()->cart->add_fee(__('Home Delivery Fee (Sherwood Park)', 'txtdomain'), $delivery_fee, true);
                WC()->session->set('delivery_error', false);
            }
            else {
                WC()->cart->add_fee(__('Home Delivery only available for Edmonton or Sherwood Park addresses', 'txtdomain'), 0, true);
                WC()->session->set('delivery_error', true);
            }
        }
        else {
            WC()->session->set('delivery_error', false);
        }
    }
}

add_filter('woocommerce_order_button_html', 'App\disable_place_order_button_html');
function disable_place_order_button_html( $button ) {
    
    $delivery_error_check = WC()->session->get('delivery_error');

    if( $delivery_error_check ) {
        echo '<div class="woocommerce-error" style="position: fixed; z-index: 999999; left: 1rem; right: 1rem; bottom: 1rem; width: 90%; margin-left: auto; margin-right: auto;">Home Delivery only available for Edmonton or Sherwood Park addresses. <br> Please <a href="/cart">return to cart</a> and choose a pickup location, or use a different Billing/Shipping address. </div>';
        $style  = 'style="background:Silver !important; color:white !important; cursor: not-allowed !important; text-align:center;"';
        $text   = apply_filters('woocommerce_order_button_text', __('Place order', 'woocommerce'));
        $button = '<button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($text) . '" disabled="disabled" ' . $style . '>' . esc_html($text) . '</button>';
    }
    return $button;
}

// Prep for quick view
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );    // Strip out the default linking so we can control the quickview
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );     // Strip out the default linking so we can control the quickview
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );           // No prices in thumbnail view plz
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );           // We need to add our own button in for the quick view

// Setup for Product Modal Quickview
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );              // Get rid of sku and categories on product modal

/**
 * Remove related products output
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_filter( 'woocommerce_product_add_to_cart_text', 'App\woocommerce_add_to_cart_button_text_archives' );  
function woocommerce_add_to_cart_button_text_archives() {
    return __( 'View Product', 'woocommerce' );
}

/**
 * @snippet       4 Products Per Category @ WooCommerce Shop
 * @how-to        businessbloomer.com/woocommerce-customization
 * @author        Rodolfo Melogli, Business Bloomer
 * @compatible    WooCommerce 6
 * @community     https://businessbloomer.com/club/
 */
 
 add_action( 'woocommerce_shop_loop', 'App\add_csa_to_shop' );
 
 function add_csa_to_shop() {
    echo do_shortcode( '[products limit="20" columns="1" category="' . 'csa' . '"]' );
 }

 add_action( 'woocommerce_shop_loop', 'App\add_merch_to_shop' );
 
 function add_merch_to_shop() {
    echo do_shortcode( '[products limit="20" columns="4" category="' . 'clothing, gift-certificate' . '"]' );
 }

 add_action( 'woocommerce_after_shop_loop_item_title', 'App\sp_wc_add_short_description' );
function sp_wc_add_short_description() {
    if( is_shop() ){
        global $product;
        echo '<div class="product-short-description">';
        echo $product->post->post_excerpt;
        echo '</div>';
    }
}
