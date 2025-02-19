<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Elementor_Widget_Loader {

	public function __construct() {
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
	}

	public function register_widgets( $widgets_manager ) {
		foreach ( glob( WP_ELEMENTOR_WIDGETS_PATH . 'includes/widgets/class-*.php' ) as $file ) {
			require_once $file;
		}

		// Register each widget class dynamically
		$widgets = [
			'WP_Elementor_Slider_Widget',
			// Future widgets: 'WP_Elementor_Another_Widget',
		];

		foreach ( $widgets as $widget ) {
			if ( class_exists( $widget ) ) {
				$widgets_manager->register_widget_type( new $widget() );
			}
		}
	}
}

new WP_Elementor_Widget_Loader();
