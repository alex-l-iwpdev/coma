<?php
/**
 * Created 04.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP
 */

use IWP\Helpers\HelpersFrontEnd;

get_header();
$postID   = get_the_ID();
$offTitle = get_post_meta( $postID, 'iwp_page_settings_title', true );
$helpers  = new HelpersFrontEnd();
?>
<section>
	<div class="page-content">
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
				<div class="col-12">
					<?php if ( 'on' === $offTitle ) : ?>
						<h1 class="title"><?php the_title(); ?></h1>
					<?php endif; ?>
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
