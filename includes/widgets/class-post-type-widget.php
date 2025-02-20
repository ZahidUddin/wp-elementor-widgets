<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Elementor_Post_Type_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wp_elementor_post_type';
	}

	public function get_title() {
		return __( 'Post Type Grid', 'wp-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'wp-elementor-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'   => __( 'Select Post Type', 'wp-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_post_types(),
				'default' => 'post',
			]
		);

		$this->add_control(
			'loop_template',
			[
				'label'   => __( 'Select Elementor Loop Item', 'wp-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_elementor_templates(),
				'default' => '',
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => __( 'Posts Per Page', 'wp-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => __( 'Columns', 'wp-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'default' => '3',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = [
			'post_type'      => $settings['post_type'],
			'posts_per_page' => $settings['posts_per_page'],
			'paged'          => 1,
		];

		$query = new WP_Query( $args );

		echo '<div class="post-grid" data-post-type="' . esc_attr( $settings['post_type'] ) . '" 
			data-posts-per-page="' . esc_attr( $settings['posts_per_page'] ) . '" 
			data-columns="' . esc_attr( $settings['columns'] ) . '">';

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				// Use Elementor Loop Template
				echo '<div class="post-item">';
				do_action( 'elementor/theme/section_render', $settings['loop_template'] );
				echo '</div>';
			}
			wp_reset_postdata();
		} else {
			echo '<p>' . __( 'No posts found.', 'wp-elementor-widgets' ) . '</p>';
		}

		echo '</div>';

		echo '<button class="load-more-posts" data-page="1">' . __( 'Load More', 'wp-elementor-widgets' ) . '</button>';
	}

	private function get_post_types() {
		$post_types = get_post_types( [ 'public' => true ], 'objects' );
		$options = [];
		foreach ( $post_types as $post_type ) {
			$options[ $post_type->name ] = $post_type->label;
		}
		return $options;
	}

	private function get_elementor_templates() {
		$args = [
			'post_type'      => 'elementor_library',
			'posts_per_page' => -1,
		];
		$templates = get_posts( $args );

		$options = [ '' => __( 'Select Template', 'wp-elementor-widgets' ) ];
		foreach ( $templates as $template ) {
			$options[ $template->ID ] = $template->post_title;
		}
		return $options;
	}
}
