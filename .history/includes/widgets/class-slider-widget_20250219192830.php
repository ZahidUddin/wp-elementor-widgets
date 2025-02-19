<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Elementor_Slider_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wp_elementor_slider';
	}

	public function get_title() {
		return __( 'Custom Slider', 'wp-elementor-widgets' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'slider_section',
			[
				'label' => __( 'Slider Settings', 'wp-elementor-widgets' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slides',
			[
				'label'   => __( 'Slides', 'wp-elementor-widgets' ),
				'type'    => \Elementor\Controls_Manager::REPEATER,
				'fields'  => [
					[
						'name'  => 'title',
						'label' => __( 'Title', 'wp-elementor-widgets' ),
						'type'  => \Elementor\Controls_Manager::TEXT,
						'default' => __( '30% Off', 'wp-elementor-widgets' ),
					],
					[
						'name'  => 'description',
						'label' => __( 'Description', 'wp-elementor-widgets' ),
						'type'  => \Elementor\Controls_Manager::TEXTAREA,
						'default' => __( 'Lorem ipsum dolor sit amet...', 'wp-elementor-widgets' ),
					],
					[
						'name'  => 'button_text',
						'label' => __( 'Button Text', 'wp-elementor-widgets' ),
						'type'  => \Elementor\Controls_Manager::TEXT,
						'default' => __( 'Shop Now', 'wp-elementor-widgets' ),
					],
					[
						'name'  => 'button_link',
						'label' => __( 'Button Link', 'wp-elementor-widgets' ),
						'type'  => \Elementor\Controls_Manager::URL,
					],
					[
						'name'  => 'image',
						'label' => __( 'Slide Image', 'wp-elementor-widgets' ),
						'type'  => \Elementor\Controls_Manager::MEDIA,
					],
					[
						'name'  => 'background_color',
						'label' => __( 'Background Color', 'wp-elementor-widgets' ),
						'type'  => \Elementor\Controls_Manager::COLOR,
						'default' => '#f4f4f4',
					],
				],
				'default' => [],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="wp-elementor-slider">
			<div class="slider-container">
				<?php foreach ( $settings['slides'] as $slide ) : ?>
					<div class="slider-item" style="background-color: <?php echo esc_attr( $slide['background_color'] ); ?>;">
						<div class="slider-content">
							<h2><?php echo esc_html( $slide['title'] ); ?></h2>
							<p><?php echo esc_html( $slide['description'] ); ?></p>
							<a href="<?php echo esc_url( $slide['button_link']['url'] ); ?>" class="slider-button">
								<?php echo esc_html( $slide['button_text'] ); ?>
							</a>
						</div>
						<div class="slider-image">
							<img src="<?php echo esc_url( $slide['image']['url'] ); ?>" alt="">
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
