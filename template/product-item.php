<?php
/**
 * Product item template.
 *
 * @params lovik/coma
 */

use IWP\Helpers\HelpersFrontEnd;
use IWP\Woocommerce\WoocommerceInit;

$product_arg = wc_get_product( $args['product_id'] );
$woo         = new WoocommerceInit();
$index       = (int) $args['index'];
$list_name   = $args['list_name'];

// Prepare an array for Data-Product_ads
$helpers    = new HelpersFrontEnd();
$event      = $helpers->build_ga4_add_to_cart_event( (int) $product_arg->get_id(), 1, $list_name, $index );
$event_json = esc_attr( wp_json_encode( $event, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );
?>
<div class="item">
	<?php
	if ( has_post_thumbnail( $product_arg->get_id() ) ) {
		the_post_thumbnail( 'thumbnail' );
	}
	?>
	<div class="description">
		<h4>
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h4>
		<?php $woo->stockQuantity(); ?>
		<div class="dfr">
			<?php echo wp_kses_post( $product_arg->get_price_html() ); ?>
			<a
					class="button icon-cart"
					data-product_ads="<?php echo esc_attr( $event_json ); ?>"
					href="<?php echo esc_url( $product_arg->add_to_cart_url() ); ?>"></a>
		</div>
	</div>
</div>
