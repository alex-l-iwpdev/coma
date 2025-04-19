<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

/**
 * Created 11.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', [] );

if ( ! empty( $product_tabs ) ) :
	$i = 0;
	?>
	<div class="nav-block">
		<ul class="nav nav-tabs" role="tablist">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<li class="nav-item"
					id="tab-title-<?php echo esc_attr( $key ); ?>"
					role="presentation"
				>
					<button
							type="button"
							class="nav-link <?php echo 0 === $i ? 'active' : ''; ?>"
							id="<?php echo esc_attr( $key ); ?>-tabs-controle"
							data-bs-target="#<?php echo esc_attr( $key ); ?>-tab"
							role="tab"
							data-bs-toggle="tab"
							aria-controls="<?php echo esc_attr( $key ); ?>-tab"
							aria-selected="false"
					>
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</button>
				</li>
				<?php
				$i ++;
			endforeach;
			?>
		</ul>
	</div>
	<?php $i = 0; ?>
	<div class="tab-content">
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div
					class="tab-pane fade <?php echo 0 === $i ? 'active show' : ''; ?>"
					id="<?php echo esc_attr( $key ); ?>-tab"
					role="tabpanel"
					aria-labelledby="<?php echo esc_attr( $key ); ?>-tab">
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
			<?php
			$i ++;
		endforeach;
		?>
	</div>
	<?php do_action( 'woocommerce_product_after_tabs' ); ?>
<?php endif; ?>
