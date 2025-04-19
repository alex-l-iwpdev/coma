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
 * Articles class file.
 */
class Articles {
	/**
	 * Construct Articles.
	 */
	public function __construct() {
		add_shortcode( 'iwp_articles', [ $this, 'output' ] );

		// Map shortcode to Visual Composer.
		if ( function_exists( 'vc_lean_map' ) ) {
			vc_lean_map( 'iwp_articles', [ $this, 'map' ] );
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
		$arg = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $atts['count'] ?? 6,
			'orderby'        => 'date',
			'cat'            => explode( ',', $atts['category'] ),
		];

		$query = new \WP_Query( $arg );
		if ( $query->have_posts() ) :
			?>
			<div class="row row-cols-xl-6 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					?>
					<div class="col">
						<div class="item">
							<a href="<?php the_permalink(); ?>" class="link">
								<?php if ( has_post_thumbnail( get_the_ID() ) ) : ?>
									<?php the_post_thumbnail( 'post-image' ); ?>
								<?php else : ?>
									<img
											src="
										<?php
											echo esc_url( get_template_directory_uri() . '/assets/img/no-image.png' );
											?>
										"
											alt="No Image">
								<?php endif; ?>
							</a>
							<h3 class="title">
								<a class="link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h3>
							<p class="desc"><?php echo esc_html( get_the_excerpt( get_the_ID() ) ); ?></p>
						</div>
					</div>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<div class="row row-cols-xl-6 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1">
				<div class="col">
					<h4><?php esc_html_e( 'Статей, не знайдено', 'coma' ); ?></h4>
				</div>
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
			'name'                    => esc_html__( 'Cтатті', 'coma' ),
			'description'             => esc_html__( 'Cтатті', 'coma' ),
			'base'                    => 'iwp_articles',
			'category'                => __( 'Coma', 'coma' ),
			'show_settings_on_create' => false,
			'icon'                    => '',
			'params'                  => [
				[
					'type'        => 'dropdown',
					'heading'     => __( 'Заголовок', 'coma' ),
					'param_name'  => 'category',
					'value'       => $this->getCategoryArray(),
					'admin_label' => false,
					'save_always' => true,
					'group'       => 'General',
				],
				[
					'type'        => 'textfield',
					'param_name'  => 'count',
					'value'       => '',
					'heading'     => __( 'Кількість виведених статей', 'coma' ),
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
	 * Get category list to dropdown menu.
	 *
	 * @return array
	 */
	private function getCategoryArray(): array {
		$terms = get_categories(
			[
				'taxonomy'   => 'category',
				'type'       => 'post',
				'hide_empty' => 1,
			]
		);

		$category = [];

		if ( $terms ) {
			foreach ( $terms as $term ) {
				$category[ $term->name ] = $term->term_id;
			}
		}

		return $category;
	}
}
