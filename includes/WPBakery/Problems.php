<?php
/**
 * Problems block.
 *
 * @package lovik/coma
 */

namespace IWP\WPBakery;

/**
 * Problems class file.
 */
class Problems {
	/**
	 * Problems construct.
	 */
	public function __construct() {
		add_shortcode( 'iwp_problems', [ $this, 'output' ] );

		// Map shortcode to Visual Composer.
		if ( function_exists( 'vc_lean_map' ) ) {
			vc_lean_map( 'iwp_problems', [ $this, 'map' ] );
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

		get_template_part( 'template/problems', '', [ 'atts' => $atts ] );

		return ob_get_clean();
	}

	/**
	 * Map field.
	 *
	 * @return array
	 */
	public function map(): array {
		return [
			'name'                    => esc_html__( 'Блок проблем', 'coma' ),
			'description'             => esc_html__( 'Блок проблем', 'coma' ),
			'base'                    => 'iwp_problems',
			'category'                => __( 'Coma', 'coma' ),
			'show_settings_on_create' => false,
			'icon'                    => '',
			'params'                  => [
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
					'type'        => 'attach_image',
					'value'       => '',
					'heading'     => __( 'Банер (картинка)', 'coma' ),
					'param_name'  => 'image',
					'admin_label' => false,
					'save_always' => true,
					'class'       => 'head-image',
					'group'       => 'General',
				],
				[
					'type'       => 'textfield',
					'value'      => '',
					'heading'    => __( 'CSS Клас', 'coma' ),
					'param_name' => 'css_class',
					'group'      => 'General',
				],
				[
					'type'        => 'param_group',
					'heading'     => __( 'Проблеми', 'coma' ),
					'param_name'  => 'problems',
					'value'       => '',
					'params'      => [
						[
							'type'       => 'textfield',
							'value'      => '',
							'heading'    => __( 'Номер', 'coma' ),
							'param_name' => 'number',
						],
						[
							'type'       => 'dropdown',
							'value'      => self::get_problem_tegs( 'problems-tag' ),
							'heading'    => __( 'Проблемы', 'coma' ),
							'param_name' => 'problem',
						],
						[
							'type'       => 'dropdown',
							'value'      => self::get_problem_tegs( 'product-type' ),
							'heading'    => __( 'Тип продукта', 'coma' ),
							'param_name' => 'product_type',
						],
					],
					'admin_label' => false,
					'save_always' => true,
					'group'       => 'General',
				],
				[
					'type'        => 'points',
					'value'       => '',
					'heading'     => __( 'Банер (картинка)', 'coma' ),
					'param_name'  => 'points',
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

	/**
	 * Get problem tag.
	 *
	 * @params string $tax_name
	 *
	 * @return array
	 */
	static protected function get_problem_tegs( string $tax_name ): array {
		$problems_tags = get_terms(
			[
				'taxonomy'   => $tax_name,
				'hide_empty' => false,
				'parent'     => 0,
			]
		);

		if ( empty( $problems_tags ) ) {
			return [];
		}

		$problems_array = [];

		$problems_array[ __( 'Выбери опцию', 'coma' ) ] = 0;

		foreach ( $problems_tags as $problem_tag ) {
			$problems_array[ $problem_tag->name ] = $problem_tag->term_id;
		}

		return $problems_array;
	}
}
