<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

/*
* Remove tabs from product details page
*/
// add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

// // function woo_remove_product_tabs( $tabs ) {
// //     unset( $tabs['additional_information'] ); // Remove the additional information tab
// // return $tabs;
// // }

/* unique single product templates */

// add_filter( 'woocommerce_locate_template', 'so_25789472_locate_template', 10, 3 );

// function so_25789472_locate_template( $template, $template_name, $template_path ){

//     // on single posts with weekly category and only for single-product/something.php templates
//     if( is_product() && has_term( 'weekly', 'product_cat' ) && strpos( $template_name, 'single-product/') !== false ){

//         // replace single-product with single-product-weekly in template name
//         $weekly_template_name = str_replace("single-product/", "single-product-weekly/", $template_name );

//         // look for templates in the single-product-weekly/ folder
//         $weekly_template = locate_template(
//             array(
//                 trailingslashit( $template_path ) . $weekly_template_name,
//                 $weekly_template_name
//             )
//         );

//         // if found, replace template with that in the single-product-weekly/ folder
//         if ( $weekly_template ) {
//             $template = $weekly_template;
//         }
//     }
//     return $template;
// }

// Change placeholder in the notes section of checkout
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     $fields['order']['order_comments']['placeholder'] = 'Any notes or comments you would like us to see?';
     return $fields;
}

/** 
 * Manipulate default state and countries
 */
add_filter( 'default_checkout_state', 'change_default_checkout_state' );
 
function change_default_checkout_state() {
  return 'AB'; // state code
}

// Add ACF options page
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}
