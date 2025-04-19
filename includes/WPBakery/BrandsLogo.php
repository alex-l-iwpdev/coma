<?php
/**
 * Created 10.09.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\WPBakery
 */

namespace IWP\WPBakery;

/**
 * BrandsLogo class file.
 */
class BrandsLogo {
	/**
	 * Construct Slider.
	 */
	public function __construct() {
		add_shortcode( 'iwp_brands_logo', [ $this, 'output' ] );

		// Map shortcode to Visual Composer.
		if ( function_exists( 'vc_lean_map' ) ) {
			vc_lean_map( 'iwp_brands_logo', [ $this, 'map' ] );
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
		$brands = vc_param_group_parse_atts( $atts['brands'] );
		if ( ! empty( $brands ) ) :
			?>
			<div class="row row-cols-xl-6 row-cols-3">
				<?php
				foreach ( $brands as $brand ) :
					$link = isset( $brand['link'] ) ? vc_build_link( $brand['link'] ) : [ 'url' => "#" ];
					?>
					<div class="col">
						<div class="item">
							<a href="<?php echo esc_url( $link['url'] ); ?>">
								<img
										src="<?php echo esc_url( wp_get_attachment_image_url( $brand['image'], 'full' ) ); ?>"
										alt="<?php echo esc_attr( get_the_title( $brand['image'] ) ); ?>">
							</a>
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
			'name'                    => esc_html__( 'Логотипи брендів', 'coma' ),
			'description'             => esc_html__( 'Логотипи брендів', 'coma' ),
			'base'                    => 'iwp_brands_logo',
			'category'                => __( 'Coma', 'coma' ),
			'show_settings_on_create' => false,
			'icon'                    => '',
			'params'                  => [
				[
					'type'        => 'param_group',
					'heading'     => __( 'Бренди', 'coma' ),
					'param_name'  => 'brands',
					'value'       => '',
					'params'      => [
						[
							'type'       => 'attach_image',
							'value'      => '',
							'heading'    => __( 'Банер (картинка)', 'coma' ),
							'param_name' => 'image',
						],
						[
							'type'       => 'vc_link',
							'value'      => '',
							'heading'    => __( 'Посилання на бренд', 'coma' ),
							'param_name' => 'link',
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
