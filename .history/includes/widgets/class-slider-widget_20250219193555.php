<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WP_Elementor_Slider_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'wp_elementor_slider';
	}

	public function get_title() {
		return __( 'Swiper Slider', 'wp-elementor-widgets' );
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
					],
					[
						'name'  => 'image',
						'label' => __( 'Slide Image', 'wp-elementor-widgets' ),
						'type'  => \Elementor\Controls_Manager::MEDIA,
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="wp-elementor-slider swiper">
			<div class="swiper-wrapper">
				<?php foreach ( $settings['slides'] as $slide ) : ?>
					<div class="swiper-slide">
						<img src="<?php echo esc_url( $slide['image']['url'] ); ?>" alt="">
						<div class="slider-content">
							<h2><?php echo esc_html( $slide['title'] ); ?></h2>
							<p><?php echo esc_html( $slide['description'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<!-- Swiper Navigation -->
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
		<?php
	}
}
