<?php
/**
 * Created 15.08.2021
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
	<div class="page404">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="breadcrumbs"><span><a class="home" href="#">Головна</a></span><span>404</span></div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/404.svg" alt="404 Error">
					<h2><?php echo esc_html__( 'Упс! Схоже ми заблукали...', 'coma' ); ?></h2>
					<div class="buttons">
						<a class="button" href="<?php bloginfo( 'url' ); ?>"><?php echo esc_html__( 'На головну', 'coma' ); ?></a>
						<a class="button transparent"
						href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php echo esc_html__( 'До каталогу', 'coma' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="product">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h2 class="title"><span>Популярнi товари</span></h2>
				</div>
			</div>
			<div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1">
				<div class="col">
					<div class="item">
						<div class="img"><a class="link" href="#"></a><img src="img/product-1.png" alt="#">
							<p class="meta top">Топ продажiв</p>
							<p class="meta stoc">Акцiя</p>
						</div>
						<div class="description">
							<h2 class="title"><a href="#">КРЕМ ДЛЯ ДЕПІЛЯЦІЇ З ЧОРНОЮ ГЛИНОЮ MOREMO BLACK CLAY HAIR REMOVAL CREAM B 100G</a></h2>
							<p class="availability">В дорозi </p>
							<p class="price">340₴</p>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="item">
						<div class="img"><a class="link" href="#"></a><img src="img/product-2.png" alt="#">
							<p class="meta top">Топ продажiв</p>
						</div>
						<div class="description">
							<h2 class="title"><a href="#">КРЕМ ДЛЯ ДЕПІЛЯЦІЇ З ЧОРНОЮ ГЛИНОЮ MOREMO BLACK CLAY HAIR REMOVAL CREAM B 100G</a></h2>
							<p class="availability active">В наявностi</p>
							<p class="price">340₴</p>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="item">
						<div class="img"><a class="link" href="#"></a><img src="img/product-3.png" alt="#">
							<p class="meta stoc">Акцiя</p>
						</div>
						<div class="description">
							<h2 class="title"><a href="#">КРЕМ ДЛЯ ДЕПІЛЯЦІЇ З ЧОРНОЮ ГЛИНОЮ MOREMO BLACK CLAY HAIR REMOVAL CREAM B 100G</a></h2>
							<p class="availability active">В наявностi</p>
							<p class="price">340₴</p>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="item"><a class="link" href="#"></a>
						<div class="img"><img src="img/no-photo.png" alt="#">
							<p class="meta top">Топ продажiв</p>
						</div>
						<div class="description">
							<h2 class="title"><a href="#">КРЕМ ДЛЯ ДЕПІЛЯЦІЇ З ЧОРНОЮ ГЛИНОЮ MOREMO BLACK CLAY HAIR REMOVAL CREAM B 100G</a></h2>
							<p class="availability active">В наявностi</p>
							<p class="price">340₴</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
