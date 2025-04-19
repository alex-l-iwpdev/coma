<?php use IWP\Helpers\HelpersFrontEnd;

/**
 * Created 06.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP
 */

$helpers = new \IWP\Helpers\HelpersFrontEnd();
get_header(); ?>
<section>
	<div class="blog">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php
					if ( class_exists( HelpersFrontEnd::class ) ) {
						$helpers->kama_breadcrumbs( ' • ' );
					}
					?>
				</div>
			</div>
			<div class="row">
				<?php if ( have_posts() ) : ?>
					<?php
					while ( have_posts() ) :
						the_post();
						$postID = get_the_ID();
						?>
						<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-12">
							<div class="blog-content">
								<?php
								if ( has_post_thumbnail( $postID ) ) :
									the_post_thumbnail(
										'single-post-image',
										[
											'class' => 'thumbnail',
											'alt'   => 'Post Thumbnail',
										]
									)
									?>
								<?php endif; ?>
								<h1 class="title"><?php the_title(); ?></h1>
								<?php the_content(); ?>
							</div>
							<?php
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
							?>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="articles">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h2 class="title"><span><?php echo esc_html__( 'Iншi cтаттi', 'coma' ); ?></span></h2>
				</div>
			</div>
			<div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1">
				<?php
				$categoryID = wp_get_post_terms( $postID, 'category', [ 'fields' => 'ids' ] );
				$arg        = [
					'cat'            => $categoryID,
					'posts_per_page' => 4,
					'post_type'      => 'post',
					'post__not_in'   => [ $postID ],
					'post_status'    => 'publish',
				];

				$query = new WP_Query( $arg );

				if ( $query->have_posts() ) :
					while ( $query->have_posts() ) :
						$query->the_post();
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
					<?php
					endwhile;
					wp_reset_postdata();
					?>
				<?php endif; ?>
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
