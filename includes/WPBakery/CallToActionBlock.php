<?php
/**
 * Created 19.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\WPBakery
 */

namespace IWP\WPBakery;

/**
 * CallToActionBlock Class.
 */
class CallToActionBlock {
	/**
	 * Construct CallToActionBlock.
	 */
	public function __construct() {
		add_shortcode( 'iwp_question_block', [ $this, 'output' ] );

		// Map shortcode to Visual Composer.
		if ( function_exists( 'vc_lean_map' ) ) {
			vc_lean_map( 'iwp_question_block', [ $this, 'map' ] );
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
		?>
		<div class="question">
			<p>Залишились питання?</p><a class="button transparent" href="#">Отримати онлайн консультацiю</a><a
					class="button"
					href="#">Записатися
				на прийом</a>
		</div>
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
			'name'                    => esc_html__( 'Блок консультації', 'coma' ),
			'description'             => esc_html__( 'Блок консультації', 'coma' ),
			'base'                    => 'iwp_question_block',
			'category'                => __( 'Coma', 'coma' ),
			'show_settings_on_create' => false,
			'icon'                    => '',
			'params'                  => [
				[
					'type'       => 'textfield',
					'value'      => '',
					'heading'    => __( 'Заголовок', 'coma' ),
					'param_name' => 'title',
				],
				[
					'type'       => 'textfield',
					'value'      => '',
					'heading'    => __( 'Текст першої кнопки', 'coma' ),
					'param_name' => 'button_one_text',
				],
				[
					'type'       => 'textfield',
					'value'      => '',
					'heading'    => __( 'URL першої кнопки', 'coma' ),
					'param_name' => 'button_one_url',
				],
				[
					'type'       => 'textfield',
					'value'      => '',
					'heading'    => __( 'Текст другої кнопки', 'coma' ),
					'param_name' => 'button_one_text',
				],
				[
					'type'       => 'textfield',
					'value'      => '',
					'heading'    => __( 'URL другої кнопки', 'coma' ),
					'param_name' => 'button_one_url',
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