<?php

/**
 * Plugin Name:       Custom Header Plutiim
 * Description:       Custom Header Plutiim Widget is created by Zain Hassan.
 * Version:           1.0.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Zain Hassan
 * Author URI:        https://hassanzain.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       hz-widgets
*/

if(!defined('ABSPATH')){
    exit;
}


/**
 * Register List Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_chp_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/chp-widget.php' );

	$widgets_manager->register( new \Elementor_Chp_Widget() );

}
add_action( 'elementor/widgets/register', 'register_chp_widget' );

function plutiim_register_dependencies_scripts() {

	/* Scripts */
	wp_register_script( 'custom-header-plutiim', plugins_url( 'inc/assets/js/header-plutiim.js', __FILE__ ));

}
add_action( 'wp_enqueue_scripts', 'plutiim_register_dependencies_scripts' );


function get_cart_count() {
    echo WC()->cart->get_cart_contents_count();
    die();
}

add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');
