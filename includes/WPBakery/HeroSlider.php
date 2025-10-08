<?php

namespace IWP\WPBakery;

class HeroSlider {
	/**
	 * Construct HeroSlider.
	 */
	public function __construct() {
		add_shortcode( 'iwp_hero_slider', [ $this, 'output' ] );

		// Map shortcode to Visual Composer.
		if ( function_exists( 'vc_lean_map' ) ) {
			vc_lean_map( 'iwp_hero_slider', [ $this, 'map' ] );
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
					<?php
					$url = vc_build_link( $slider['slide_url'] );
					?>
					<div class="item">
						<a
								class="url"
								target="<?php echo esc_attr( $url['target'] ?? '' ); ?>"
								href="<?php echo esc_url( $url['url'] ); ?>">
						</a>
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
				'name'                    => esc_html__( 'Слайдер', 'coma' ),
				'description'             => esc_html__( 'Слайдер', 'coma' ),
				'base'                    => 'iwp_hero_slider',
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
												'type'       => 'vc_link',
												'value'      => '',
												'heading'    => __( 'URL', 'coma' ),
												'param_name' => 'slide_url',
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
