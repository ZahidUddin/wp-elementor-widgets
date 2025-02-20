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
	wp_enqueue_script( 'wp-elementor-post-search-script', WP_ELEMENTOR_WIDGETS_URL . 'assets/js/post-type-widget.js', array( 'jquery' ), false, true );

	// Pass AJAX URL to JavaScript
	wp_localize_script(
		'wp-elementor-post-search-script',
		'wp_search_params',
		[
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		]
	);
}
add_action( 'wp_enqueue_scripts', 'wp_elementor_widgets_enqueue_assets' );


add_action( 'wp_ajax_search_posts', 'wp_elementor_search_posts_ajax' );
add_action( 'wp_ajax_nopriv_search_posts', 'wp_elementor_search_posts_ajax' );

function wp_elementor_search_posts_ajax() {
	// Sanitize and validate inputs
	$post_type      = isset( $_POST['post_type'] ) ? sanitize_text_field( $_POST['post_type'] ) : 'post';
	$posts_per_page = isset( $_POST['posts_per_page'] ) ? intval( $_POST['posts_per_page'] ) : 6;
	$search_query   = isset( $_POST['search_query'] ) ? sanitize_text_field( $_POST['search_query'] ) : '';
	$template_id    = isset( $_POST['loop_template'] ) ? intval( $_POST['loop_template'] ) : 0;

	// Stop if search query is empty
	if ( empty( $search_query ) ) {
		wp_die();
	}

	$args = [
		'post_type'      => $post_type,
		'posts_per_page' => $posts_per_page,
		's'              => $search_query, // Search by title
	];

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			// Use Elementor Loop Template if selected
			if ( ! empty( $template_id ) ) {
				echo '<div class="post-item">';
				echo \Elementor\Plugin::$instance->frontend->get_builder_content( $template_id );
				echo '</div>';
			} else {
				// Fallback if no template is selected
				echo 'Select Template First';
			}
		}
		wp_reset_postdata();
	} else {
		echo '<p>' . __( 'No posts found.', 'wp-elementor-widgets' ) . '</p>';
	}

	wp_die();
}
