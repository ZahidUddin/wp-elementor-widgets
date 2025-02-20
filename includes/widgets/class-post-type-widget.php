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
				'label'   => __( 'Select Post Template', 'wp-elementor-widgets' ),
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
		];
	
		$query = new WP_Query( $args );
	
		// Search Input Field
		echo '<input type="text" class="post-search-input" placeholder="' . __( 'Search posts...', 'wp-elementor-widgets' ) . '" 
		data-post-type="' . esc_attr( $settings['post_type'] ) . '" 
		data-posts-per-page="' . esc_attr( $settings['posts_per_page'] ) . '" 
		data-loop-template="' . esc_attr( $settings['loop_template'] ) . '">';
	
		// Posts Container
		echo '<div class="post-grid" id="post-grid" style="display:grid; grid-template-columns: repeat(' . esc_attr( $settings['columns'] ) . ', 1fr); gap: 20px;">';
	
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
	
				// Check if a loop template is selected
				if ( ! empty( $settings['loop_template'] ) ) {
					echo '<div class="post-item">';
					echo \Elementor\Plugin::$instance->frontend->get_builder_content( $settings['loop_template'] );
					echo '</div>';
				} else {
					// Fallback: Basic Post Structure
					echo 'Select Template First';
				}
			}
			wp_reset_postdata();
		} else {
			echo '<p>' . __( 'No posts found.', 'wp-elementor-widgets' ) . '</p>';
		}
	
		echo '</div>'; // End post-grid div
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
			'meta_query'     => [
				[
					'key'     => '_elementor_template_type',
					'value'   => 'loop-item',
					'compare' => '='
				]
			]
		];

		$templates = get_posts( $args );

		$options = [ '' => __( 'Select Template', 'wp-elementor-widgets' ) ];
		foreach ( $templates as $template ) {
			$options[ $template->ID ] = $template->post_title;
		}
		return $options;
	}
}
