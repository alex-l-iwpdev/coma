<?php
/**
 * Product item template.
 *
 * @params lovik/coma
 */

use IWP\Woocommerce\WoocommerceInit;

$product_arg = wc_get_product( $args['product_id'] );
$woo         = new WoocommerceInit();
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
			<a class="button icon-cart" href="<?php echo esc_url( $product_arg->add_to_cart_url() ); ?>"></a>
		</div>
	</div>
</div>
