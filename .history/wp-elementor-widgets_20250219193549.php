<?php
/**
 * Plugin Name: WP Elementor Widgets
 * Plugin URI: https://example.com
 * Description: A collection of custom Elementor widgets including a Swiper.js-powered slider.
 * Version: 1.0
 * Author: WP Plugin Architect
 * Author URI: https://chatgpt.com/g/g-6cqBCrKTn-wp-plugin-architect
 * Text Domain: wp-elementor-widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define paths
define( 'WP_ELEMENTOR_WIDGETS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_ELEMENTOR_WIDGETS_URL', plugin_dir_url( __FILE__ ) );

// Load widget loader
require_once WP_ELEMENTOR_WIDGETS_PATH . 'includes/class-widget-loader.php';

// Enqueue styles and scripts
function wp_elementor_widgets_enqueue_assets() {
	// Swiper.js CDN
	wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' );
	wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), false, true );

	// Custom plugin assets
	wp_enqueue_style( 'wp-elementor-widgets-global', WP_ELEMENTOR_WIDGETS_URL . 'assets/css/global.css' );
	wp_enqueue_style( 'wp-elementor-slider-style', WP_ELEMENTOR_WIDGETS_URL . 'assets/css/slider.css' );
	wp_enqueue_script( 'wp-elementor-slider-script', WP_ELEMENTOR_WIDGETS_URL . 'assets/js/slider.js', array( 'swiper-js' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'wp_elementor_widgets_enqueue_assets' );
