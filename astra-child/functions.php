<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

/**
 * @snippet       Display Categories Under Product Name @ WooCommerce Cart
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=72844
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 3.2.1
 */
 
add_filter( 'woocommerce_cart_item_name', 'bbloomer_cart_item_category', 99, 3);
 
function bbloomer_cart_item_category( $name, $cart_item, $cart_item_key ) {
 
$product_item = $cart_item['data'];
 
// make sure to get parent product if variation
if ( $product_item->is_type( 'variation' ) ) {
$product_item = wc_get_product( $product_item->get_parent_id() );
} 
 
$cat_ids = $product_item->get_category_ids();
 
// if product has categories, concatenate cart item name with them
if ( $cat_ids ) $name .= '</br>' . wc_get_product_category_list( $product_item->get_id(), ', ', '<span class="posted_in">' . _n( '', 'Categories:', count( $cat_ids ), 'woocommerce' ) . ' ', '</span>' );
 
return $name;
 
}


/**
* Display order items product categories (Orders on front end and emails)
*/
add_action( 'woocommerce_order_item_meta_end', 'display_custom_data_in_emails', 10, 4 );
function display_custom_data_in_emails( $item_id, $item, $order, $bool ) {
    // Get the product categories for this item
    $terms = wp_get_post_terms( $item->get_product_id(), 'product_cat', array( 'fields' => 'names' ) );

    // Output a coma separated string of product category names
    echo "<span style='color: #ff5151'>" . implode(', ', $terms) . "</span>";
}
    
/*
* Display order items product categories in admin order edit pages
*/
add_action( 'woocommerce_after_order_itemmeta', 'custom_admin_order_itemmeta', 15, 3 );
function custom_admin_order_itemmeta( $item_id, $item, $product ){
    //if( ! is_admin() ) return; // only backend

    // Target order "line items" only to avoid errors
    if( $item->is_type( 'line_item' ) ){
        // Get the product categories for this item
        $terms = wp_get_post_terms( $item->get_product_id(), 'product_cat', array( 'fields' => 'names' ) );

        // Output a coma separated string of product category names
        echo "<br><small>" . implode(', ', $terms) . "</small>";
    }
}

/*
* Remove Order Comment field from checkout
*/
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     unset($fields['order']['order_comments']);

     return $fields;
}

/*
* Remove shipping information from cart
*/
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );
function disable_shipping_calc_on_cart( $show_shipping ) {

        return false;

}

/*
* Change Out Of Stock label in Product
*/
add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {
    
    // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
        $availability['availability'] = __('Not Available at this Location', 'woocommerce');
    }
    return $availability;
}
    
/**
 * Change "Out Of Stock" text added on WooCommerce Product Grid.
 *
 * @return String
 */
function your_prefix_change_out_stock_string() {
    return __( 'Not Available at this Location', 'astra-child' );
}
add_filter( 'astra_woo_shop_out_of_stock_string', 'your_prefix_change_out_stock_string' );

/**
 * Disable cart quantity updates.
 * @return String
 */
function wc_remove_all_quantity_fields( $return, $product ) {
    return true;
}
add_filter( 'woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2 );

