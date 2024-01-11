<?php

/**
 * Plugin Name:       Custom Header Plutiim
 * Description:       Custom Header Plutiim Widget is created by Zain Hassan.
 * Version:           1.0.0
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