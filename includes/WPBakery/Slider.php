<?php
/**
 * Created 18.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\WPBakery
 */

namespace IWP\WPBakery;

/**
 * Slider class file.
 */
class Slider {
	/**
	 * Construct Slider.
	 */
	public function __construct() {
		add_shortcode( 'iwp_slider_product', [ $this, 'output' ] );

		// Map shortcode to Visual Composer.
		if ( function_exists( 'vc_lean_map' ) ) {
			vc_lean_map( 'iwp_slider_product', [ $this, 'map' ] );
		}
	}

	/**
	 * Output Short Code template
	 *
	 * @param mixed       $atts    Attributes.
	 * @param string|null $content Content.
	 *
	 * @return string
	 */
	public function output( $atts, string $content = null ): string {
		ob_start();
		$sliders = vc_param_group_parse_atts( $atts['slide'] );
		if ( ! empty( $sliders ) ) :
			?>
			<div class="banner-slider">
				<?php foreach ( $sliders as $slider ) : ?>
					<div class="item">
						<div class="description">
							<h5 class="meta"><?php echo esc_html( $slider['label'] ); ?></h5>
							<h2 class="title"><?php echo esc_html( get_the_title( $slider['id'] ) ); ?></h2>
							<p class="desc"><?php echo wp_kses_post( get_the_excerpt( $slider['id'] ) ); ?></p>
							<a class="button mini" href="<?php echo esc_url( get_the_permalink( $slider['id'] ) ); ?>">
								<?php echo esc_html__( 'Детальнiше', 'coma' ); ?>
							</a>
						</div>
						<div class="img">
							<img
									class="desktop"
									src="<?php echo esc_url( wp_get_attachment_image_url( $slider['image'], 'full' ) ); ?>"
									alt="#">
							<img
									class="mobile"
									src="<?php echo esc_url( wp_get_attachment_image_url( $slider['image_mobile'], 'full' ) ?: wp_get_attachment_image_url( $slider['image'], 'full' ) ); ?>"
									alt="#">
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php
		endif;

		return ob_get_clean();
	}

	/**
	 * Map field.
	 *
	 * @return array
	 */
	public function map(): array {
		return [
			'name'                    => esc_html__( 'Слайдер товарів', 'coma' ),
			'description'             => esc_html__( 'Слайдер товарів', 'coma' ),
			'base'                    => 'iwp_slider_product',
			'category'                => __( 'Coma', 'coma' ),
			'show_settings_on_create' => false,
			'icon'                    => '',
			'params'                  => [
				[
					'type'        => 'param_group',
					'heading'     => __( 'Слайди', 'coma' ),
					'param_name'  => 'slide',
					'value'       => '',
					'params'      => [
						[
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => __( 'ID товару', 'coma' ),
							'param_name' => 'id',
						],
						[
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => __( 'Лейбл товару', 'coma' ),
							'param_name' => 'label',
						],
						[
							'type'       => 'attach_image',
							'value'      => '',
							'heading'    => __( 'Банер (картинка)', 'coma' ),
							'param_name' => 'image',
						],
						[
							'type'       => 'attach_image',
							'value'      => '',
							'heading'    => __( 'Банер (картинка мобільна)', 'coma' ),
							'param_name' => 'image_mobile',
						],
					],
					'admin_label' => false,
					'save_always' => true,
					'group'       => 'General',
				],
				[
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'coma' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'coma' ),
				],
			],
		];
	}
}
