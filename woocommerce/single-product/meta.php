<?php
/**
 * Created 06.11.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$productBrand = wp_get_post_terms( $product->get_id(), 'berocket_brand' );
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<span class="brand-meta">
		<?php
		if ( ! empty( $productBrand[0] ) ) {
			esc_html_e( 'Бренди: ', 'coma' );
			?>
			<a href="<?php echo esc_url( get_term_link( $productBrand[0]->term_id ?: 0 ) ); ?>">
			<?php echo esc_html( $productBrand[0]->name ?: 0 ) ?? ''; ?>
		</a>
		<?php } ?>
	</span>

	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
