<?php
/**
 * Static banner
 *
 * @package lovik/coma
 */

namespace IWP\WPBakery;

/**
 * StaticBanner class file.
 */
class StaticBanner {
	/**
	 * StaticBanner construct.
	 */
	public function __construct() {
		add_shortcode( 'iwp_static_banner', [ $this, 'output' ] );

		// Map shortcode to Visual Composer.
		if ( function_exists( 'vc_lean_map' ) ) {
			vc_lean_map( 'iwp_static_banner', [ $this, 'map' ] );
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

		$image        = wp_get_attachment_image_url( $atts['image'], 'full' );
		$image_mobile = wp_get_attachment_image_url( $atts['image_mobile'], 'full' );
		$css_class    = vc_shortcode_custom_css_class( $atts['css'] ?? '', ' ' );
		if ( ! empty( $image ) ) {
			?>
			<div class="banner <?php echo esc_attr( $css_class ); ?>">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="banner-img">
								<img
										class="desktop"
										src="<?php echo esc_url( $image ); ?>"
										alt="<?php echo esc_attr( get_the_title( $atts['image'] ) ); ?>">
								<img
										class="mobile"
										src="<?php echo esc_url( $image_mobile ? $image_mobile : $image ); ?>"
										alt="<?php echo esc_attr( get_the_title( $atts['image'] ) ); ?>">
								<div class="desc">
									<h1><?php echo esc_html( $atts['title'] ?? '' ); ?></h1>
									<p><?php echo esc_html( $atts['sub_title'] ?? '' ); ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		return ob_get_clean();
	}

	/**
	 * Map field.
	 *
	 * @return array
	 */
	public function map(): array {
		return [
			'name'                    => esc_html__( 'Статичний банер', 'coma' ),
			'description'             => esc_html__( 'Статичний банер', 'coma' ),
			'base'                    => 'iwp_static_banner',
			'category'                => __( 'Coma', 'coma' ),
			'show_settings_on_create' => false,
			'icon'                    => '',
			'params'                  => [
				[
					'type'        => 'attach_image',
					'value'       => '',
					'heading'     => __( 'Банер (картинка)', 'coma' ),
					'param_name'  => 'image',
					'admin_label' => false,
					'save_always' => true,
					'group'       => 'General',
				],
				[
					'type'        => 'attach_image',
					'value'       => '',
					'heading'     => __( 'Банер (картинка мобільна)', 'coma' ),
					'param_name'  => 'image_mobile',
					'admin_label' => false,
					'save_always' => true,
					'group'       => 'General',
				],
				[
					'type'        => 'textfield',
					'param_name'  => 'title',
					'value'       => '',
					'heading'     => __( 'Заголовок', 'coma' ),
					'admin_label' => false,
					'save_always' => true,
					'group'       => 'General',
				],
				[
					'type'        => 'textfield',
					'param_name'  => 'sub_title',
					'value'       => '',
					'heading'     => __( 'Під заголовок', 'coma' ),
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
