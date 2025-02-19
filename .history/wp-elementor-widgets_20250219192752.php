<?php
/**
 * Plugin Name: WP Elementor Widgets
 * Plugin URI: https://example.com
 * Description: A collection of custom Elementor widgets.
 * Version: 1.0
 * Author: WP Plugin Architect
 * Author URI: https://chatgpt.com/g/g-6cqBCrKTn-wp-plugin-architect
 * Text Domain: wp-elementor-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define plugin paths
define( 'WP_ELEMENTOR_WIDGETS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_ELEMENTOR_WIDGETS_URL', plugin_dir_url( __FILE__ ) );

// Load Widget Loader
require_once WP_ELEMENTOR_WIDGETS_PATH . 'includes/class-widget-loader.php';

// Enqueue global styles and scripts
function wp_elementor_widgets_enqueue_assets() {
	wp_enqueue_style( 'wp-elementor-widgets-global', WP_ELEMENTOR_WIDGETS_URL . 'assets/css/global.css' );
	wp_enqueue_script( 'wp-elementor-widgets-global', WP_ELEMENTOR_WIDGETS_URL . 'assets/js/global.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'wp_elementor_widgets_enqueue_assets' );
