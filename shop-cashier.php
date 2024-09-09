<?php
/*
Plugin Name: Shop Cashier
Description: Creates a Shop Cashier user role and limits their product access to offline products only. Created for 8692342-zen
Version: 1.0 Author: Woo Growth Team Text
License: GPL2
Requires Plugins:  woocommerce
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the custom user role when the theme or plugin is
 */
function add_custom_shop_manager_role() {
	// Get the shop_manager role
	$shop_manager = get_role( 'shop_manager' );

	// Add a new role called 'custom_shop_manager' with the same capabilities
	add_role(
		'shop_cashier',
		'Shop Cashier',
		$shop_manager->capabilities
	);

}

add_action( 'after_setup_theme', 'add_custom_shop_manager_role' );

/**
 * Remove the custom user role if necessary (optional, for cleanup purposes)
 * Call this function when you want to remove the custom role, e.g. during theme/plugin deactivation
 */
function remove_custom_shop_manager_role() {
	remove_role( 'custom_shop_manager' );
}

/**
 * Modify the product query to restrict products to the 'offline' category for custom shop managers
 */
add_action( 'pre_get_posts', 'restrict_custom_shop_manager_products_view' );

function restrict_custom_shop_manager_products_view( $query ) {

	// Check if the user is logged in and has the role 'custom_shop_manager'
	if ( ! is_user_logged_in() || ! current_user_can( 'shop_cashier' ) ) {
		return;
	}
	
	// Check if it's a WooCommerce product query
	if( $query->get( 'post_type' ) !== 'product' ){
		return;
	}

	// Modify the query to limit products to the 'offline' category
	$tax_query = (array) $query->get( 'tax_query' );

	// Add the 'offline' category restriction
	$tax_query[] = array(
		'taxonomy' => 'product_cat',
		'field'    => 'slug',
		'terms'    => 'offline', // Slug of the 'offline' category
	);

	$query->set( 'tax_query', $tax_query );

}
 