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
						'name'    => 'image',
						'label'   => __( 'Slide Image', 'wp-elementor-widgets' ),
						'type'    => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
					],
					[
						'name'    => 'title',
						'label'   => __( 'Title', 'wp-elementor-widgets' ),
						'type'    => \Elementor\Controls_Manager::TEXT,
						'default' => __( 'Slide Title', 'wp-elementor-widgets' ),
					],
					[
						'name'    => 'description',
						'label'   => __( 'Description', 'wp-elementor-widgets' ),
						'type'    => \Elementor\Controls_Manager::TEXTAREA,
						'default' => __( 'Slide description goes here.', 'wp-elementor-widgets' ),
					],
					[
						'name'        => 'button_text',
						'label'       => __( 'Button Text', 'wp-elementor-widgets' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'default'     => __( 'Learn More', 'wp-elementor-widgets' ),
					],
					[
						'name'        => 'button_link',
						'label'       => __( 'Button Link', 'wp-elementor-widgets' ),
						'type'        => \Elementor\Controls_Manager::URL,
						'placeholder' => __( 'https://your-link.com', 'wp-elementor-widgets' ),
					],
					[
						'name'    => 'image_position',
						'label'   => __( 'Image Position', 'wp-elementor-widgets' ),
						'type'    => \Elementor\Controls_Manager::SELECT,
						'options' => [
							'left'  => __( 'Left', 'wp-elementor-widgets' ),
							'right' => __( 'Right', 'wp-elementor-widgets' ),
						],
						'default' => 'right',
					],
					[
						'name'    => 'info_bg_color',
						'label'   => __( 'Information Background Color', 'wp-elementor-widgets' ),
						'type'    => \Elementor\Controls_Manager::COLOR,
						'default' => '#f4f4f4',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}
		?>

		<div class="wp-elementor-slider swiper">
			<div class="swiper-wrapper">
				<?php foreach ( $settings['slides'] as $slide ) : ?>
					<?php 
						$image_url = ! empty( $slide['image']['url'] ) ? esc_url( $slide['image']['url'] ) : '';
						$image_position = esc_attr( $slide['image_position'] ); 
						$info_bg_color = esc_attr( $slide['info_bg_color'] );
					?>
					<div class="swiper-slide">
						<div class="slide-container <?php echo $image_position === 'left' ? 'image-left' : 'image-right'; ?>">
							<div class="slide-content" style="background-color: <?php echo $info_bg_color; ?>;">
								<h2><?php echo esc_html( $slide['title'] ); ?></h2>
								<p><?php echo esc_html( $slide['description'] ); ?></p>
								<?php if ( ! empty( $slide['button_text'] ) && ! empty( $slide['button_link']['url'] ) ) : ?>
									<a href="<?php echo esc_url( $slide['button_link']['url'] ); ?>" class="slider-button">
										<?php echo esc_html( $slide['button_text'] ); ?>
									</a>
								<?php endif; ?>
							</div>
							<div class="slide-image">
								<?php if ( ! empty( $image_url ) ) : ?>
									<img src="<?php echo $image_url; ?>" alt="Slide Image">
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<!-- Swiper Navigation -->
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-pagination"></div>
		</div>

		<?php
	}
}
