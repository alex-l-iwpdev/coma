<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

use IWP\Helpers\WooCommerceFilter;

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$helpersWoo   = new WooCommerceFilter();
$paramsFilter = $helpersWoo->parseURLQuery( get_query_var( 'filter' ) );
$termID       = get_queried_object()->term_id ?? false;

$brandBanner     = false;
$termDescription = false;
if ( $termID ) {
	$brandBanner     = get_term_meta( $termID, 'brand_banner_url', true );
	$termDescription = term_description( $termID, 'berocket_brand' );
}
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
?>
	<div class="row">
		<div class="col-12">
			<div class="brand-description">
				<?php if ( $brandBanner ) : ?>
					<div class="img">
						<img src="<?php echo esc_url( $brandBanner ); ?>" alt="Brands Banner">
					</div>
				<?php endif; ?>
				<div class="desc">
					<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
						<h1 class="title"><?php woocommerce_page_title(); ?></h1>
					<?php endif; ?>
					<?php if ( $termDescription ) : ?>
						<div class="brand-desc">
							<?php echo wp_kses_post( $termDescription ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php
/**
 * Hook: woocommerce_action_block.
 *
 * @hooked addActionBlock - 10
 */
do_action( 'woocommerce_action_block' );

$query_obj = get_queried_object();

if ( ! $paramsFilter && ! empty( $query_obj ) ) {
	$query_param   = [];
	$query_param[] = $query_obj->slug;
}
?>
	</div>
	<div class="row">
		<div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 col-12">
			<div class="filters">
				<form
						action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
						method="post"
						id="filter_product">
					<h4><?php esc_html_e( 'Фiльтри', 'coma' ); ?></h4>
					<p>
						<?php esc_html_e( 'Пошук', 'coma' ); ?>
					</p>
					<div class="input">
						<?php $searchProduct = isset( $paramsFilter['search'] ) ? implode( ' ', $paramsFilter['search'] ) : false; ?>
						<label for="search">
							<input
									type="text"
									value="<?php echo esc_attr( $searchProduct ) ?? ''; ?>"
									name="iwp_prod[search]"
									id="search"
							>
							<button type="submit" class="icon-search"></button>
						</label>
					</div>
					<p>
						<?php esc_html_e( 'Тип товару', 'coma' ); ?>
					</p>
					<ul class="type-products">
						<?php
						if ( ! empty( $helpersWoo->getProductTypesList() ) ) :
							$typesProduct = $paramsFilter['type'] ?? $query_param;
							foreach ( $helpersWoo->getProductTypesList() as $prodCat ) :
								?>
								<li>
									<div class="checkbox">
										<input
												id="iwp-prod-type-<?php echo esc_attr( $prodCat->term_id ); ?>"
												name="iwp_prod[type][]"
												data-filter="type"
												value="<?php echo esc_attr( $prodCat->slug ); ?>" type="checkbox"
											<?php
											echo ! empty( $typesProduct ) && in_array( $prodCat->slug, $typesProduct, true ) ? 'checked' :
												''
											?>
										>
										<label for="iwp-prod-type-<?php echo esc_attr( $prodCat->term_id ); ?>">
											<?php echo esc_html( $prodCat->name ); ?>
										</label>
									</div>
									<?php
									$childTerm = $helpersWoo->getChildProductType( $prodCat->term_id );
									$open      = ! empty( $typesProduct ) && in_array( $prodCat->slug, $typesProduct, true ) ? 'block' : 'none';
									?>
									<?php if ( ! empty( $childTerm ) ) : ?>
										<ul class="child-type" style="display: <?php echo esc_attr( $open ); ?>">
											<li>
												<?php foreach ( $childTerm as $child ) : ?>
													<div class="checkbox">
														<input
																id="iwp-prod-type-<?php echo esc_attr( $child->term_id ); ?>"
																name="iwp_prod[type][]"
																data-filter="type"
																value="<?php echo esc_attr( $child->slug ); ?>"
																type="checkbox"
															<?php
															echo ! empty( $typesProduct ) && in_array( $child->slug, $typesProduct, true ) ? 'checked' :
																''
															?>
														>
														<label for="iwp-prod-type-<?php echo esc_attr( $child->term_id ); ?>">
															<?php echo esc_html( $child->name ); ?>
														</label>
													</div>
												<?php endforeach; ?>
											</li>
										</ul>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
					<p><?php esc_html_e( 'Цiна', 'coma' ); ?></p>
					<?php $priceProduct = $paramsFilter['price'] ?? false; ?>
					<div class="inputs">
						<label for=""><?php esc_html_e( 'Вiд', 'coma' ); ?>
							<input
									type="text"
									data-filter="price-start"
									value="<?php echo ! empty( $priceProduct[0] ) ? esc_attr( $priceProduct[0] ) : ''; ?>"
									name="iwp_prod[price][]"
									id="price-start"
							>
						</label>
						<label for=""><?php esc_html_e( 'до', 'coma' ); ?>
							<input
									type="text"
									data-filter="price-end"
									id="price-end"
									value="<?php echo ! empty( $priceProduct[1] ) ? esc_attr( $priceProduct[1] ) : ''; ?>"
									name="iwp_prod[price][]">
						</label>
					</div>
					<p><?php esc_html_e( 'Наявнiсть', 'coma' ); ?></p>
					<?php $stockProduct = $paramsFilter['stock'] ?? false; ?>
					<div class="checkbox">
						<input
								id="iwp-prod-stock-in"
								name="iwp_prod[stock][]"
								data-filter="stock-in"
								value="instock"
								type="checkbox"
							<?php
							echo ! empty( $stockProduct ) && in_array( 'instock', $stockProduct, true ) ? 'checked' : ''
							?>
						>
						<label for="iwp-prod-stock-in"><?php esc_html_e( 'В наявності', 'coma' ); ?></label>
					</div>
					<div class="checkbox">
						<input
								id="iwp-prod-stock-out"
								name="iwp_prod[stock][]"
								data-filter="stock-out"
								value="outstock"
								type="checkbox"
							<?php
							echo ! empty( $stockProduct ) && in_array( 'outofstock', $stockProduct, true ) ? 'checked' : ''
							?>
						>
						<label for="iwp-prod-stock-out"><?php esc_html_e( 'Передзамовлення', 'coma' ); ?></label>
					</div>
					<p><?php esc_html_e( 'Акційний товар', 'coma' ); ?></p>
					<?php $salesProduct = $paramsFilter['sales'] ?? false; ?>
					<div class="checkbox">
						<input
								id="iwp-prod-sales"
								name="iwp_prod[sales][]"
								data-filter="sales"
								value="sales"
								type="checkbox"
							<?php
							echo ! empty( $salesProduct ) && in_array( 'sales', $salesProduct, true ) ? 'checked' : ''
							?>
						>
						<label for="iwp-prod-sales"><?php esc_html_e( 'Зi знижкою', 'coma' ); ?></label>
					</div>
					<p><?php esc_html_e( 'Бренд', 'coma' ); ?></p>
					<?php
					if ( ! empty( $helpersWoo->getBarantdsList() ) ) :
						$brandsProduct = $paramsFilter['brands'] ?? $query_param;
						foreach ( $helpersWoo->getBarantdsList() as $prodBrand ) :
							?>
							<div class="checkbox">
								<input
										id="iwp-prod-brand-<?php echo esc_attr( $prodBrand->term_id ); ?>"
										name="iwp_prod[brands][]"
										data-filter="brands"
										value="<?php echo esc_attr( $prodBrand->slug ); ?>"
										type="checkbox"
									<?php
									echo ! empty( $brandsProduct ) && in_array( $prodBrand->slug, $brandsProduct, true ) ? 'checked' : ''
									?>
								>
								<label for="iwp-prod-brand-<?php echo esc_attr( $prodBrand->term_id ); ?>">
									<?php echo esc_attr( $prodBrand->name ); ?>
								</label>
							</div>
						<?php
						endforeach;
					endif;
					?>
					<input type="hidden" name="action" value="iwp_prod_filter">
					<?php wp_nonce_field( 'iwp_prod_filter', 'iwp_prod_filter_nonce' ); ?>
					<input type="submit" value="<?php esc_html_e( 'Застосувати фільтри' ); ?>">
				</form>
			</div>
		</div>
		<div class="col-xxl-9 col-xl-9 col-lg-8 col-md-7 col-12">
			<?php
			if ( woocommerce_product_loop() ) {

				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );

				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();

						/**
						 * Hook: woocommerce_shop_loop.
						 */
						do_action( 'woocommerce_shop_loop' );

						wc_get_template_part( 'content', 'product' );
					}
				}

				woocommerce_product_loop_end();

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			}
			?>
		</div>
	</div>
<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_seo_block.
 *
 * @hooked addSeoBlock - 10 (Output shortcode templatera seo block)
 * @arg    string ShortCode.
 */
do_action( 'woocommerce_seo_block', '[templatera id="107"]' );

get_footer( 'shop' );
