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

    echo '<div id="custom_checkout_field_referral"><h2>' . __('Referral Email Address') . '</h2>';

    woocommerce_form_field( 'referral', array(
        'type'          => 'text',
        'class'         => array('referral-names form-row-wide'),
        'label'         => __('Email Address of who referred you'),
        'placeholder'   => __('example@test.com'),
        ), $checkout->get_value( 'referral' ));

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
    }

    /**
     * Display field value on the order edit page
     */
    add_action( 'woocommerce_admin_order_data_after_billing_address', 'App\custom_checkout_field_referral_display_admin_order_meta', 10, 1 );

    function custom_checkout_field_referral_display_admin_order_meta($order){
        echo '<p><strong>'.__('Referral').':</strong> ' . get_post_meta( $order->id, 'referral', true ) . '</p>';
    }
    