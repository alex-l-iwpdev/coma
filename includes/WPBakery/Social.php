<?php
/**
 * Created 16.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\WPBakery
 */

namespace IWP\WPBakery;

/**
 * Social Class.
 */
class Social {
	/**
	 * Construct Social.
	 */
	public function __construct() {
		add_shortcode( 'iwp_social_link', [ $this, 'output' ] );

		// Map shortcode to Visual Composer.
		if ( function_exists( 'vc_lean_map' ) ) {
			vc_lean_map( 'iwp_social_link', [ $this, 'map' ] );
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
		$soc = vc_param_group_parse_atts( $atts['soc'] );
		?>
		<h6><?php echo ! empty( $atts['title'] ) ? esc_html( $atts['title'] ) : ''; ?></h6>
		<?php if ( ! empty( $soc ) ) : ?>
			<ul class="soc">
				<?php foreach ( $soc as $item ) : ?>
					<li>
						<a class="icon-<?php echo esc_attr( $item['name'] ); ?>" href="<?php echo esc_url( $item['url'] ); ?>"></a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php
		return ob_get_clean();
	}

	/**
	 * Map field.
	 *
	 * @return array
	 */
	public function map(): array {
		return [
			'name'                    => esc_html__( 'Соцiальнi мережi', 'coma' ),
			'description'             => esc_html__( 'Соцiальнi мережi', 'coma' ),
			'base'                    => 'iwp_social_link',
			'category'                => __( 'Coma', 'coma' ),
			'show_settings_on_create' => false,
			'icon'                    => '',
			'params'                  => [
				[
					'type'        => 'textfield',
					'heading'     => __( 'Заголовок', 'coma' ),
					'param_name'  => 'title',
					'value'       => '',
					'admin_label' => false,
					'save_always' => true,
					'group'       => 'General',
				],
				[
					'type'        => 'param_group',
					'heading'     => __( 'Соцiальнi мережi', 'coma' ),
					'param_name'  => 'soc',
					'value'       => '',
					'params'      => [
						[
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => __( 'Назва', 'coma' ),
							'param_name' => 'name',
						],
						[
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => __( 'URL', 'coma' ),
							'param_name' => 'url',
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
