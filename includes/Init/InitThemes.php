<?php
/**
 * Created 04.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\Init
 */

namespace IWP\Init;

use IWP\Customize\CustomizeTheme;
use IWP\Helpers\HelpersFrontEnd;
use IWP\Helpers\WooCommerceFilter;
use IWP\MetaBox\MetaBoxPageSettings;
use IWP\Widget\NewProduct\NewProductWidget;
use IWP\Woocommerce\WoocommerceInit;
use IWP\WPBakery\Articles;
use IWP\WPBakery\BrandsLogo;
use IWP\WPBakery\CallToActionBlock;
use IWP\WPBakery\HeroSlider;
use IWP\WPBakery\Problems;
use IWP\WPBakery\Slider;
use IWP\WPBakery\Social;
use IWP\WPBakery\StaticBanner;

/**
 * Init Themes Class.
 */
class InitThemes {

	const COMA_VERSION = '1.2.4';

	/**
	 * Constructor InitThemes class.
	 */
	public function __construct() {
		$this->url_rewrite_rules();
	}

	/**
	 * Add Rewrite rules url
	 */
	public function url_rewrite_rules(): void {

		add_rewrite_rule(
				'shop/filter/([-_a-zA-Z0-9+%.:]+)/page/(\d+)/?$',
				'index.php?post_type=product&filter=$matches[1]&paged=$matches[2]',
				'top'
		);

		add_rewrite_rule(
				'shop/filter/([-_a-zA-Z0-9+%.:]+)/?$',
				'index.php?post_type=product&filter=$matches[1]',
				'top'
		);
	}

	/**
	 * Add Support SVG File.
	 *
	 * @param array $mime_types Allowed Mime Types.
	 *
	 * @return array
	 */
	public static function mime_types( array $mime_types ): array {
		$mime_types['svg'] = 'image/svg+xml';

		return $mime_types;
	}

	/**
	 * Init Themes Hook.
	 */
	public function init(): void {
		// Actions.
		add_action( 'wp_enqueue_scripts', [ $this, 'add_script_and_style' ] );
		add_action( 'after_setup_theme', [ $this, 'support_theme' ] );
		add_action( 'customize_register', [ $this, 'add_customize' ] );
		add_action( 'widgets_init', [ $this, 'add_widget_zone_and_widget' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'add_admin_script_and_style' ] );
		add_action( 'vc_before_init', [ $this, 'add_bakery_components' ] );
		add_action( 'after_setup_theme', [ $this, 'add_text_domain' ] );
		add_action( 'custom_switcher', [ $this, 'get_languages_switcher' ] );
		add_action( 'init', [ $this, 'register_problem_tag' ] );
		vc_add_shortcode_param( 'dropdown_multi', [ $this, 'dropdown_multi_settings_field' ] );
		vc_add_shortcode_param( 'points', [ $this, 'points_fields' ] );


		// Filters.
		add_filter( 'upload_mimes', [ $this, 'mime_types' ] );
		add_filter( 'excerpt_length', [ $this, 'excerpt_length' ], 50, 1 );
		add_filter( 'excerpt_more', [ $this, 'change_excerpt_more' ], 50, 1 );
		add_filter( 'vc_shortcodes_css_class', [ $this, 'change_default_grid' ], 100, 2 );
		add_filter( 'query_vars', [ $this, 'add_filter_vars' ] );
		add_filter( 'wpseo_canonical', [ $this, 'delete_page_in_shop' ], 100 );

		// Woocommerce Remove and add Action.
		new WoocommerceInit();

		// Settings Page MetaBox.
		new MetaBoxPageSettings();

		// Add Filter Helpers.
		new WooCommerceFilter();
	}

	/**
	 * Add Scripts and Style in Theme.
	 */
	public function add_script_and_style(): void {

		$url = get_template_directory_uri();

		// JS.
		wp_enqueue_script(
				'build',
				$url . '/assets/js/build.js',
				[
						'jquery',
						'fancybox',
						'bootstrap',
						'slick',
				],
				self::COMA_VERSION,
				true
		);
		wp_enqueue_script( 'fancybox', $url . '/assets/js/jquery.fancybox.min.js', [ 'jquery' ], self::COMA_VERSION, true );
		wp_enqueue_script( 'IncrementBox', $url . '/assets/js/jquery.IncrementBox.js', [ 'jquery' ], self::COMA_VERSION, true );
		wp_enqueue_script( 'slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', [ 'jquery' ], '1.8.1', true );
		wp_enqueue_script(
				'bootstrap',
				'//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"',
				[ 'jquery' ],
				'5.0.2',
				true
		);
		wp_enqueue_script(
				'main',
				$url . '/assets/js/main.js',
				[ 'jquery', 'select' ],
				self::COMA_VERSION,
				true
		);

		wp_enqueue_script(
				'select',
				$url . '/assets/js/select2.min.js',
				[ 'jquery' ],
				self::COMA_VERSION,
				true
		);

		wp_enqueue_script(
				'com-tab',
				$url . '/assets/js/tab.min.js',
				[ 'jquery' ],
				self::COMA_VERSION,
				true
		);

		wp_localize_script(
				'main',
				'coma',
				[
						'url' => admin_url( 'admin-ajax.php' ),
				]
		);

		// CSS.
		wp_enqueue_style( 'main', $url . '/assets/css/main.css', '', self::COMA_VERSION );
		wp_enqueue_style( 'style', $url . '/style.css', '', self::COMA_VERSION );
		wp_enqueue_style( 'fancybox', $url . '/assets/css/jquery.fancybox.min.css', '', self::COMA_VERSION );
		wp_enqueue_style( 'select', $url . '/assets/css/select2.min.css', '', self::COMA_VERSION );
		wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&amp;display=swap', '', '1.0.0' );

		// Add Support IE 9.
		wp_enqueue_script( 'html5', '//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js', [], '3.7.0', false );
		wp_enqueue_script( 'respond', '//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js', [], '1.4.2', false );
		wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
		wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

	}

	/**
	 * Add Scripts and Style to Admin page.
	 *
	 * @param string $hook_suffix Page Hook.
	 */
	public function add_admin_script_and_style( string $hook_suffix ): void {

		if ( 'widgets.php' === $hook_suffix ) {
			wp_enqueue_media();
			wp_enqueue_script( 'newProductWidget', get_template_directory_uri() . '/assets/js/admin/widget.js', false, '1.0.0', true );
		}

	}

	/**
	 * Support theme functionality.
	 */
	public function support_theme(): void {
		// WooCommerce Supports.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-zoom' );

		// Add Helpers To Front End.
		new HelpersFrontEnd();

		// Add Menu Area Supports.
		register_nav_menus(
				[
						'top_bar_header_menu'       => __( 'Меню в шапці біля лого', 'coma' ),
						'header_menu'               => __( 'Меню в шапці', 'coma' ),
						'header_menu_home_page'     => __( 'Меню в шапці на головній сторінці', 'coma' ),
						'footer_menu_first_column'  => __( 'Меню в підвалі перша колонка', 'coma' ),
						'footer_menu_second_column' => __( 'Меню в підвалі друга колонка', 'coma' ),
				]
		);

		// Register Image Size.
		add_image_size( 'post-image', 314, 311, [ 'center', 'top' ] );
		add_image_size( 'single-post-image', 1326, 750, [ 'center', 'top' ] );

	}

	/**
	 * Add Customize function in Theme.
	 *
	 * @return void
	 */
	public function add_customize(): void {
		new CustomizeTheme();
	}

	/**
	 * Adds widget zones and custom widgets to the theme.
	 *
	 * @return void
	 */
	public function add_widget_zone_and_widget(): void {

		// Register widget zone.
		register_sidebar(
				[
						'name'          => __( 'Блог і категорії', 'coma' ),
						'id'            => 'blog-sidebar',
						'before_widget' => '<div>',
						'after_widget'  => '</div>',
						'before_title'  => '<h3>',
						'after_title'   => '</h3>',
				]
		);

		register_sidebar(
				[
						'name'          => __( 'Блог внутрішня', 'coma' ),
						'id'            => 'blog-inside-sidebar',
						'before_widget' => '<div>',
						'after_widget'  => '</div>',
						'before_title'  => '<h3>',
						'after_title'   => '</h3>',
				]
		);

		register_sidebar(
				[
						'name'          => __( 'Сторінка товарів', 'coma' ),
						'id'            => 'products-sidebar',
						'before_widget' => '<div>',
						'after_widget'  => '</div>',
						'before_title'  => '<h3>',
						'after_title'   => '</h3>',
				]
		);

		if ( class_exists( NewProductWidget::class ) ) {
			register_widget( NewProductWidget::class );
		}

	}

	/**
	 * Filter Change default value the_excerpt text.
	 *
	 * @return int
	 */
	public function excerpt_length(): int {
		return 10;
	}

	/**
	 * Filter Change constructions [...] at the end
	 *
	 * @return string
	 */
	public function change_excerpt_more(): string {
		return '...';
	}

	/**
	 * Change Default Grid to Bootstrap.
	 *
	 * @param string $class_string Class Name.
	 * @param string $tag          Tag Name.
	 *
	 * @return string
	 */
	public function change_default_grid( string $class_string, string $tag ): string {
		if ( 'vc_row' === $tag || 'vc_row_inner' === $tag ) {
			$class_string = str_replace( [ 'wpb_row', 'row-fluid', 'vc_row' ], [ 'row', '', '' ], $class_string );
		}

		if ( 'vc_column' === $tag || 'vc_column_inner' === $tag ) {
			$class_string = preg_replace(
					[
							'/vc_col-lg-(\d{1,2})/',
							'/vc_col-md-(\d{1,2})/',
							'/vc_col-sm-(\d{1,2})/',
							'/vc_col-xs-(\d{1,2})/',
					],
					[
							'col-lg-$1',
							'col-md-$1',
							'col-sm-$1',
							'col-$1',
					],
					$class_string
			);
			$class_string = str_replace( [ 'vc_column_container', 'wpb_column' ], [ '', '' ], $class_string );
		}

		return $class_string;
	}

	/**
	 * Add WPBakery components.
	 */
	public function add_bakery_components(): void {
		new Social();
		new Slider();
		new CallToActionBlock();
		new Articles();
		new BrandsLogo();
		new StaticBanner();
		new Problems();
		new HeroSlider();
	}

	/**
	 * Add Query vars filter
	 *
	 * @param array $vars Vars Query.
	 *
	 * @return array
	 */
	public function add_filter_vars( array $vars ): array {
		$vars[] = 'filter';

		return $vars;
	}

	/**
	 * Add Russian Localization
	 */
	public function add_text_domain(): void {
		load_theme_textdomain( 'coma', get_template_directory() . '/languages' );
	}

	/**
	 * Output custom swicher.
	 */
	public function get_languages_switcher(): void {
		if ( function_exists( 'icl_get_languages' ) ) {
			$languages = icl_get_languages( 'skip_missing=0&orderby=code' );
			if ( ! empty( $languages ) ) {
				ob_start();
				$active_lang = [];
				foreach ( $languages as $language ) {
					if ( $language['active'] ) {
						$active_lang = $language;
					}
				}

				?>
				<div
						class="language <?php echo 'uk' === ICL_LANGUAGE_CODE ? '' : 'checked'; ?>"
						data-after="Ru"
						data-before="Uk"
						data-active_lang="<?php echo esc_attr( $active_lang['code'] ); ?>"
						data-url_ru="<?php echo esc_url( $languages['ru']['url'] ?? '#' ); ?>"
						data-url_uk="<?php echo esc_url( $languages['uk']['url'] ?? '#' ); ?>"
				>
					<input id="language" type="checkbox" <?php echo 'uk' === ICL_LANGUAGE_CODE ? '' : 'checked'; ?>>
					<label for="language"> </label>
				</div>
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo ob_get_clean();
				// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}

	/**
	 * Delete /page/2/  in shop page and product category.
	 *
	 * @param string $canonical Canonical url.
	 *
	 * @return string
	 */
	public function delete_page_in_shop( string $canonical ): string {

		if ( is_shop() ) {
			$canonical = 'https://coma.org.ua/shop/';
		}

		if ( is_product_category() ) {
			$canonical = preg_replace( '/\/page\/\d+\//', '/', $canonical );
		}

		return $canonical;
	}

	/**
	 * Register problem taxonomy.
	 *
	 * @return void
	 */
	public function register_problem_tag(): void {
		register_taxonomy(
				'problems-tag',
				[ 'product' ],
				[
						'label'        => '',
						'labels'       => [
								'name'              => __( 'Проблеми', 'coma' ),
								'singular_name'     => __( 'Проблеми', 'coma' ),
								'search_items'      => __( 'Шукати проблему', 'coma' ),
								'all_items'         => __( 'Усі проблеми', 'coma' ),
								'view_item '        => __( 'Смотреть проблему', 'coma' ),
								'parent_item'       => __( 'Батьківська проблема', 'coma' ),
								'parent_item_colon' => __( 'Батьківська проблема:', 'coma' ),
								'edit_item'         => __( 'Редагувати проблему', 'coma' ),
								'update_item'       => __( 'Оновити проблему', 'coma' ),
								'add_new_item'      => __( 'Створити новий проблему', 'coam' ),
								'new_item_name'     => __( 'Створити новий проблему', 'coma' ),
								'menu_name'         => __( 'Проблеми', 'coma' ),
								'back_to_items'     => __( '← Назад до проблем', 'coma' ),
						],
						'description'  => '',
						'public'       => true,
						'hierarchical' => true,
						'rewrite'      => true,
						'show_in_rest' => true,
				]
		);

		register_taxonomy(
				'product-type',
				[ 'product' ],
				[
						'label'        => '',
						'labels'       => [
								'name'              => __( 'Тип продукту', 'coma' ),
								'singular_name'     => __( 'Тип продукту', 'coma' ),
								'search_items'      => __( 'Шукати продукт', 'coma' ),
								'all_items'         => __( 'Усі продукти', 'coma' ),
								'view_item '        => __( 'Смотреть продукт', 'coma' ),
								'parent_item'       => __( 'Батьківський продукт', 'coma' ),
								'parent_item_colon' => __( 'Батьківський продукт:', 'coma' ),
								'edit_item'         => __( 'Редагувати продукт', 'coma' ),
								'update_item'       => __( 'Оновити продукт', 'coma' ),
								'add_new_item'      => __( 'Створити новий тип продукту', 'coam' ),
								'new_item_name'     => __( 'Створити новий тип продукту', 'coma' ),
								'menu_name'         => __( 'Тип продукту', 'coma' ),
								'back_to_items'     => __( '← Назад до продукту', 'coma' ),
						],
						'description'  => '',
						'public'       => true,
						'hierarchical' => true,
						'rewrite'      => true,
						'show_in_rest' => true,
				]
		);
	}

	/**
	 * Add dropdown multiselect.
	 *
	 * @param array  $param Params.
	 * @param string $value Value.
	 *
	 * @return string
	 */
	public function dropdown_multi_settings_field( array $param, string $value ) {
		$param_line = '';
		$param_line .= '<select multiple name="' . esc_attr( $param['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select ' . esc_attr( $param['param_name'] ) . ' ' . esc_attr( $param['type'] ) . '">';
		foreach ( $param['value'] as $text_val => $val ) {
			if ( is_numeric( $text_val ) && ( is_string( $val ) || is_numeric( $val ) ) ) {
				$text_val = $val;
			}
			$text_val = __( $text_val, 'js_composer' );
			$selected = '';

			if ( ! is_array( $value ) ) {
				$param_value_arr = explode( ',', $value );
			} else {
				$param_value_arr = $value;
			}

			if ( $value !== '' && in_array( $val, $param_value_arr, true ) ) {
				$selected = ' selected="selected"';
			}
			$param_line .= '<option class="' . $val . '" value="' . $val . '"' . $selected . '>' . $text_val . '</option>';
		}
		$param_line .= '</select>';

		return $param_line;
	}

	/**
	 * Points fields.
	 *
	 * @param array  $param Params.
	 * @param string $value Value.
	 *
	 * @return false|string
	 */
	public function points_fields( array $param, string $value ) {
		ob_start();
		?>
		<div class="image-wrapper">
			<div class="img" style="display: table; position: relative;">
				<img src="" class="image-header-big" alt="">
			</div>
			<div class="navigation">
				<a href="#" class="add_point">Add point</a>
			</div>
			<input
					type="hidden"
					class="wpb_vc_param_value wpb-input <?php echo esc_attr( $param['param_name'] ) . ' ' . esc_attr( $param['type'] ); ?>"
					name="<?php echo esc_attr( $param['param_name'] ); ?>"
					id="cms_problem_points"
					value="<?php echo esc_attr( $value ?? '' ); ?>">
		</div>
		<script type="application/javascript">
			jQuery( document ).ready( function() {
				var imgSRCHead = jQuery( '.gallery_widget_attached_images_list img' ).attr( 'src' );
				var imgBig = jQuery( '.image-header-big' ).attr( 'src', imgSRCHead );
				var iterator = 1;
				var pointsArray = [];
				var pointValue = jQuery( '#cms_problem_points' ).val();
				var imgWrapper = jQuery( '.img' );

				if ( pointValue.length ) {
					var valuePoints = JSON.parse( jQuery( '#cms_problem_points' ).val() );
					pointsArray = valuePoints;
					addPointValue( pointsArray );
					deletePoint();
				}

				if ( imgSRCHead.length ) {
					var addPointButton = jQuery( '.add_point' );

					addPointButton.click( function( e ) {
						e.preventDefault();
						var index = pointsArray.length - 1 ?? 0;
						var point = `<a href="#" class="point"  draggable="true" data-index="${index}">x</a>`;
						pointsArray.push( { x: 0, y: 0 } ); // Добавляем новую точку в массив

						imgWrapper.append( jQuery( point ).draggable( {
							containment: 'parent',
							drag: function( event, ui ) {
								var containerWidth = jQuery( imgWrapper ).width();
								var containerHeight = jQuery( imgWrapper ).height();
								var newX = ui.position.left;
								var newY = ui.position.top;

								var newXProcent = ( newX / containerWidth ) * 100;
								var newYProcent = ( newY / containerHeight ) * 100;

								pointsArray[ index ].x = newXProcent;
								pointsArray[ index ].y = newYProcent;
							},
							stop: function() {
								deletePoint();
								jQuery( '#cms_problem_points' ).val( JSON.stringify( pointsArray ) );
							}
						} ) );

						iterator++;
					} );
				}

				function setDragAndDrop( point, index ) {
					console.log( 'setW', point );
					jQuery( point ).draggable( {
						containment: 'parent', // Ограничиваем перемещение элемента в пределах контейнера
						drag: function( event, ui ) {
							console.log( 'darag' );
							var containerWidth = jQuery( imgWrapper ).width();
							var containerHeight = jQuery( imgWrapper ).height();
							var newX = ui.position.left;
							var newY = ui.position.top;

							var newXProcent = ( newX / containerWidth ) * 100;
							var newYProcent = ( newY / containerHeight ) * 100;

							pointsArray[ index ].x = newXProcent;
							pointsArray[ index ].y = newYProcent;
						},
						stop: function() {
							jQuery( '#cms_problem_points' ).val( JSON.stringify( pointsArray ) );
						}
					} );
				}

				function addPointValue( points ) {
					points.map( ( el, i ) => {
						var point = jQuery( `<a href="#" class="point" data-index="${i}">x</a>` );
						point.css( { 'left': el.x + '%', 'top': el.y + '%' } );
						imgWrapper.append( point );
						setDragAndDrop( point, i );
					} );
				}

				function deletePoint() {
					jQuery( '.point' ).click( function( e ) {
						e.preventDefault();
						let index = jQuery( this ).data( 'index' );
						jQuery( this ).remove();
						pointsArray.splice( index, 1 );
						jQuery( '#cms_problem_points' ).val( JSON.stringify( pointsArray ) );
					} );
				}
			} );
		</script>
		<style>
			div.img {
				counter-reset: list;
			}

			.point {
				position: absolute !important;
				width: 49px !important;
				height: 49px !important;
				z-index: 1;
				transition: all 0.3s ease;
				font-size: 0;
			}

			.point:after {
				content: '';
				width: 49px;
				height: 49px;
				border-radius: 50%;
				background: rgba(17, 17, 17, .6);
				transition: all 0.3s ease;
				position: absolute;
				left: 0;
				right: 0;
				bottom: 0;
				top: 0;
				z-index: -1;
			}

			.point:before {
				counter-increment: list;
				content: counter(list);
				position: relative;
				width: 49px;
				height: 49px;
				display: -ms-flexbox;
				display: flex;
				-ms-flex-direction: column;
				flex-direction: column;
				-ms-flex-align: center;
				align-items: center;
				-ms-flex-pack: center;
				justify-content: center;
				font-size: 18px;
				font-weight: 800;
				font-family: 'Montserrat', sans-serif;
				color: #fff;
				cursor: pointer;
			}
		</style>
		<?php
		return ob_get_clean();
	}
}
