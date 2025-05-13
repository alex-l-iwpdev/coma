<?php
/**
 * Created 09.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package  IWP\Woocommerce
 */

namespace IWP\Woocommerce;

use IWP\Helpers\WooCommerceFilter;
use WP_Query;

/**
 * WoocommerceInit Class.
 * works with hooks and WooCommerce filters.
 */
class WoocommerceInit {

	/**
	 * Filter Class.
	 *
	 * @var WooCommerceFilter Helpers Class.
	 */
	private $filter;

	/**
	 * Construct WoocommerceInit Class.
	 */
	public function __construct() {
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices' );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

		add_filter(
			'woocommerce_product_loop_title_classes',
			function () {
				return 'title';
			}
		);
		add_filter( 'woocommerce_class_wrapper', [ $this, 'filterClassWrapper' ] );
		add_filter( 'woocommerce_product_tabs', [ $this, 'renameTabs' ], 98 );
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'refreshCartCount' ] );

		add_action( 'woocommerce_seo_block', [ $this, 'addSeoBlock' ], 10, 1 );
		add_action( 'woocommerce_before_shop_loop_item', [ $this, 'changeClassProductLinkOpen' ], 10 );
		add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'stockQuantity' ], 5 );
		add_action( 'woocommerce_single_product_summary', [ $this, 'stockQuantity' ], 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20 );
		add_action( 'pre_get_posts', [ $this, 'addQueryFilter' ] );
		add_action( 'get_related_product', 'woocommerce_output_related_products' );
		add_action( 'woocommerce_after_shop_loop_item', [ $this, 'addByToOneClick' ], 1 );
		add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'getTags' ], 5 );
		add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display', 10 );

		$this->filter = new WooCommerceFilter();
	}

	/**
	 * Include Template Action Block.
	 *
	 * Hook: woocommerce_action_block.
	 */
	public function addActionBlock(): void {
		include COMA_TEMPLATE_DIR . '/woocommerce/global/action-block.php';
	}

	/**
	 * Output ShortCode Template SEO block.
	 *
	 * Hook:woocommerce_seo_block.
	 *
	 * @param string $shortCode SortCode.
	 */
	public function addSeoBlock( string $shortCode ): void {
		if ( ! empty( $shortCode ) ) {
			include COMA_TEMPLATE_DIR . '/woocommerce/global/seo-block.php';
		} else {
			echo esc_html__( 'Шорткод не найден', 'coma' );
		}

	}

	/**
	 * WooCommerce template loop product link open.
	 * add Class link.
	 */
	public function changeClassProductLinkOpen(): void {
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link link"></a>';
	}

	/**
	 * Output availability tag product.
	 *
	 * Hook: woocommerce_after_shop_loop_item_title
	 */
	public function stockQuantity(): void {
		global $product;
		if ( $product->get_stock_quantity() > 0 || 'instock' === $product->get_stock_status() ) {
			echo '<p class="availability active">' . esc_html__( 'В наявностi', 'coma' ) . '</p>';
		} else {
			echo '<p class="availability">' . esc_html__( 'В дорозi', 'coma' ) . '</p>';
		}
	}

	/**
	 * Add class to Wrapper WooCommerce.
	 *
	 * Filter: woocommerce_class_wrapper.
	 *
	 * @return string
	 */
	public function filterClassWrapper(): string {
		$class = '';

		if ( is_singular( 'product' ) ) {
			$class = 'product';
		}

		if ( is_archive() ) {
			$class = 'brand';
		}

		return $class;
	}

	/**
	 * Rename Tabs title.
	 *
	 * @param array $tabs Tabs Array parameters.
	 *
	 * @return array
	 */
	public function renameTabs( array $tabs ): array {
		$tabs['description']['title']            = __( 'Iнформація про товар', 'coma' );
		$tabs['additional_information']['title'] = __( 'Характеристики', 'coma' );
		$tabs['delivery']                        = [
			'title'    => __( 'Доставка та термiни повернення', 'coma' ),
			'priority' => 30,
			'callback' => [ $this, 'addDeliveryTab' ],
		];

		return $tabs;
	}

	/**
	 * Output info delivery tab.
	 */
	public function addDeliveryTab(): void {
		echo do_shortcode( '[templatera id="119"]' );
	}


	/**
	 * Update Main query product from filter.
	 *
	 * @param WP_Query $query Main Query.
	 *
	 * @return WP_Query
	 */
	public function addQueryFilter( WP_Query $query ): WP_Query {

		if (
			! is_admin() && $query->is_main_query() &&
			is_post_type_archive( 'product' ) &&
			! empty( $query->query_vars['filter'] )
		) {
			$args         = [];
			$filterParams = $this->filter->parseURLQuery( $query->query_vars['filter'] );
			foreach ( $filterParams as $key => $param ) {
				switch ( $key ) {
					case 'type':
						$args['tax_query'][] =
							[
								'taxonomy' => 'product_cat',
								'field'    => 'slug',
								'terms'    => $this->filter->unsetParentTerm( $param ),
								'operator' => 'IN',
							];
						break;
					case 'price':
						if ( ! empty( $param[0] ) ) {
							$args['meta_query']['relation'] = 'AND';
							$args['meta_query'][]           = [
								'key'     => '_price',
								'value'   => $param,
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC',
							];
						}
						break;
					case 'stock':
						foreach ( $param as $value ) {
							$arg[] = [
								'key'   => '_stock_status',
								'value' => $value,
							];
						}
						$arg['relation']      = 'OR';
						$args['meta_query'][] = $arg;
						break;
					case 'brands':
						$args['tax_query']['relation'] = 'AND';
						$args['tax_query'][]           =
							[
								'taxonomy' => 'berocket_brand',
								'field'    => 'slug',
								'terms'    => $param,
								'operator' => 'IN',
							];

						break;
					case 'sales':
						$args['meta_query'][] = [
							'relation' => 'AND',
							[
								'key'     => '_sale_price',
								'compare' => 'EXISTS',
							],
						];
						break;
					case 'search':
						$query->set( 's', filter_var( implode( ' ', $param ), FILTER_SANITIZE_STRING ) );
						$query->set( 'post_type', 'product' );
						break;
				}
			}

			foreach ( $args as $key => $arg ) {
				$query->set( $key, $arg );
			}

			return $query;
		}

		return $query;
	}

	/**
	 * Refresh Cart Count.
	 *
	 * @param string $fragments Count.
	 *
	 * @return mixed
	 */
	public function refreshCartCount( $fragments ) {
		ob_start();
		$items_count = WC()->cart->get_cart_contents_count();
		?>
		<p id="mini-cart-count"><?php echo $items_count ?: ''; ?></p>
		<?php
		$fragments['#mini-cart-count'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Add button add to cart in archive page.
	 */
	public function addByToOneClick(): void {
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart' );
	}

	/**
	 * Output product tags.
	 */
	public function getTags(): void {
		global $product;
		$prodID = $product->get_id();
		$tags   = wp_get_post_terms( $prodID, 'product_tag' );
		if ( ! empty( $tags ) ) :
			?>
			<ul class="prod-tags">
				<?php foreach ( $tags as $tag ) : ?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $tag->term_id, 'product_tag' ) ); ?>">
							#<?php echo esc_html( $tag->name ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php
		endif;
	}
}

