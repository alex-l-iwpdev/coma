<?php
/**
 * Template part Problem.
 *
 * @params lovik/coma
 */

$atts       = $args['atts'] ?? [];
$image      = wp_get_attachment_image( $atts['image'], 'full' );
$problems   = vc_param_group_parse_atts( $atts['problems'] );
$coordinate = ! empty( $atts['points'] ) ? str_replace( '``', '"', $atts['points'] ) : '';

$coordinate = substr_replace( $coordinate, '[', 0, 1 );
$coordinate = substr_replace( $coordinate, ']', - 1 );
$coordinate = str_replace( '[{`', '[', $coordinate );
$coordinate = str_replace( '`}]', ']', $coordinate );

$coordinate = json_decode( $coordinate );
?>
<div class="product-tabs <?php echo esc_html( $atts['css_class'] ?? '' ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2><?php echo esc_html( $atts['title'] ?? '' ); ?></h2>
				<h4><?php echo esc_html( $atts['sub_title'] ?? '' ); ?></h4>
			</div>
		</div>
		<div class="row align-items-start">
			<div class="col-xxl-8 col-xl-8 col-lg-7 col-md-12 col-sm-12">
				<div class="photo">
					<?php
					if ( ! empty( $image ) ) {
						echo wp_kses_post( $image );
					} else {
						esc_attr_e( 'Встановіть зображення', 'coma' );
					}

					if ( ! empty( $problems ) ) {
						?>
						<ul class="nav-photo">
							<?php foreach ( $problems as $key => $problem ) { ?>
								<li
										class="<?php echo 0 === $key ? 'active' : ''; ?>"
										style="left: <?php echo esc_html( $coordinate[ $key ]->x ); ?>%; top:<?php echo esc_html( $coordinate[ $key ]->y ); ?>%; ">
									<a
											href="#block-<?php echo esc_html( $atts['css_class'] ?? '' ); ?>-<?php echo esc_html( $key ); ?>"
											data-tab="tab"></a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div>
			</div>
			<div class="col-xxl-4 col-xl-4 col-lg-5 col-md-12 col-sm-12">
				<?php if ( ! empty( $problems ) ) { ?>
					<div class="tab-content">
						<?php
						foreach ( $problems as $key => $problem ) {
							$problem_type_term = get_term_by( 'id', $problem['product_type'], 'product-type' );
							$args              = [
									'post_type'      => 'product',
									'post_status'    => 'publish',
									'posts_per_page' => 10,
									'tax_query'      => [
											'relation' => 'AND',
											[
													'taxonomy' => 'product-type',
													'field'    => 'id',
													'terms'    => $problem_type_term->term_id,
											],
											[
													'taxonomy' => 'problems-tag',
													'field'    => 'id',
													'terms'    => $problem['problem'],
											],
									],
							];

							$product_query = new WP_Query( $args );
							?>
							<div
									class="tab-pane tab-product <?php echo 0 === $key ? 'active' : ''; ?>"
									id="block-<?php echo esc_html( $atts['css_class'] ?? '' ); ?>-<?php echo esc_html( $key ); ?>">
								<h4><?php echo esc_html( $problem_type_term->name ); ?>:</h4>
								<?php if ( $product_query->have_posts() ) { ?>
									<div class="product-items">
										<?php
										$index = 1;
										while ( $product_query->have_posts() ) {
											$product_query->the_post();
											$product_id = get_the_ID();
											get_template_part(
													'template/product',
													'item',
													[
															'product_id' => $product_id,
															'index'      => $index,
															'list_name'  => $atts['sub_title'],
													]
											);
											$index ++;
										}
										wp_reset_postdata();
										?>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
