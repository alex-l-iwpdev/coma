<?php
/**
 * Created 05.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP
 */

get_header();
?>
<section>
	<div class="blog articles">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-12">
					<div class="row row-cols-xl-3 row-cols-lg-2 row-cols-md-1 row-cols-sm-2 row-cols-1">
						<?php if ( have_posts() ) : ?>
							<?php
							while ( have_posts() ) :
								the_post();
								?>
								<div class="col">
									<div class="item">
										<a class="link" href="<?php the_permalink(); ?>">
											<?php
											if ( has_post_thumbnail() ) :
												the_post_thumbnail( 'post-image' );
												?>
											<?php else : ?>
												<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/no-image.png"
													 alt="no image">
											<?php endif; ?>
										</a>
										<h3 class="title">
											<a class="link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
										<p class="desc"><?php the_excerpt(); ?></p>
									</div>
								</div>
							<?php endwhile; ?>
						<?php endif; ?>
					</div>
					<div class="row">
						<div class="col-12">
							<?php
							if ( function_exists( 'wp_pagenavi' ) ) :
								wp_pagenavi();
								?>
							<?php else : ?>
								<div class="nav-previous">
									<?php
									next_posts_link( __( '<span class="meta-nav">&larr;</span> Старіші пости', 'coma' ) );
									?>
								</div>
								<div class="nav-next">
									<?php
									previous_posts_link( __( 'Новіші пости <span class="meta-nav">&rarr;</span>', 'coma' ) );
									?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if ( shortcode_exists( 'templatera' ) ) : ?>
		<div class="description-block">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php echo do_shortcode( '[templatera id="107"]' ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>
<?php get_footer(); ?>
