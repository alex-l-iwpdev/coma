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

$logoFooter   = ! empty( get_theme_mod( 'coma_logo_white' ) ) ? get_theme_mod( 'coma_logo_white' ) : false;
$copyright    = ! empty( get_theme_mod( 'coma_copyright' ) ) ? get_theme_mod( 'coma_copyright' ) : 'Сайт створений <a href="https://i-wp-dev.com">i-wp-dev.com</a>';
$scheduleWork = ! empty( get_theme_mod( 'coma_schedule' ) ) ? get_theme_mod( 'coma_schedule' ) : false;
$phoneOne     = ! empty( get_theme_mod( 'coma_phone_one' ) ) ? get_theme_mod( 'coma_phone_one' ) : false;
$phoneTwo     = ! empty( get_theme_mod( 'coma_phone_two' ) ) ? get_theme_mod( 'coma_phone_two' ) : false;

// Social.
$facebook  = ! empty( get_theme_mod( 'coma_facebook' ) ) ? get_theme_mod( 'coma_facebook' ) : false;
$instagram = ! empty( get_theme_mod( 'coma_instagram' ) ) ? get_theme_mod( 'coma_instagram' ) : false;
$twitter   = ! empty( get_theme_mod( 'coma_twitter' ) ) ? get_theme_mod( 'coma_twitter' ) : false;
$phoneOne  = ! empty( get_theme_mod( 'coma_phone_one' ) ) ? get_theme_mod( 'coma_phone_one' ) : false;
$phoneTwo  = ! empty( get_theme_mod( 'coma_phone_two' ) ) ? get_theme_mod( 'coma_phone_two' ) : false;
?>
<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-sm-6 col-12">
				<a class="logo" href="<?php bloginfo( 'url' ); ?>">
					<?php if ( $logoFooter ) : ?>
						<img src="<?php echo esc_url( $logoFooter ); ?>" alt="logo">
					<?php else : ?>
						<h3><?php bloginfo( 'name' ); ?></h3>
					<?php endif; ?>
				</a>
				<a
						href="tel:<?php echo esc_html( apply_filters( 'sanitize_phone_number', $phoneOne ) ); ?>"><?php echo esc_html( $phoneOne ); ?></a>
				<a
						href="tel:<?php echo esc_html( apply_filters( 'sanitize_phone_number', $phoneTwo ) ); ?>"><?php echo esc_html( $phoneTwo ); ?></a>
				<?php if ( $scheduleWork ) : ?>
					<p><?php echo esc_html( $scheduleWork ); ?></p>
				<?php endif; ?>
			</div>
			<div class="col-lg-3 col-sm-6 col-12">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'footer_menu_first_column',
						'menu_class'     => 'menu',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					]
				);
				?>
			</div>
			<div class="col-lg-3 col-sm-6 col-12">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'footer_menu_second_column',
						'menu_class'     => 'menu',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					]
				);
				?>
			</div>
			<div class="col-lg-3 col-sm-6 col-12 align-self-end">
				<div class="payment-logo">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/payment_mc.svg' ); ?>"
						 alt="Master Cart">
					<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/payment_visa.svg' ); ?>"
						 alt="VISA">
				</div>
				<p><?php echo esc_html__( 'Ми у соц. мережах', 'coma' ); ?></p>
				<ul class="soc">
					<?php if ( $facebook ) : ?>
						<li class="icon-facebook"><a href="<?php echo esc_url( $facebook ); ?>"></a></li>
					<?php endif; ?>
					<?php if ( $instagram ) : ?>
						<li class="icon-instagram"><a href="<?php echo esc_url( $instagram ); ?>"></a></li>
					<?php endif; ?>
					<?php if ( $twitter ) : ?>
						<li class="icon-twitter"><a href="<?php echo esc_url( $twitter ); ?>"></a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<p><?php echo wp_kses( $copyright, 'a' ); ?></p>
				</div>
			</div>
		</div>
	</div>
</footer>
<div class="phone-block">
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
		<path d="M280 0C408.1 0 512 103.9 512 232c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-101.6-82.4-184-184-184c-13.3 0-24-10.7-24-24s10.7-24 24-24zm8 192a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm-32-72c0-13.3 10.7-24 24-24c75.1 0 136 60.9 136 136c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-48.6-39.4-88-88-88c-13.3 0-24-10.7-24-24zM117.5 1.4c19.4-5.3 39.7 4.6 47.4 23.2l40 96c6.8 16.3 2.1 35.2-11.6 46.3L144 207.3c33.3 70.4 90.3 127.4 160.7 160.7L345 318.7c11.2-13.7 30-18.4 46.3-11.6l96 40c18.6 7.7 28.5 28 23.2 47.4l-24 88C481.8 499.9 466 512 448 512C200.6 512 0 311.4 0 64C0 46 12.1 30.2 29.5 25.4l88-24z"/>
	</svg>
	<div class="phone">
		<a rel="noindex, nofollow"
		   href="viber://chat?number=%2B+<?php echo esc_html( apply_filters( 'sanitize_phone_number', $phoneOne ) ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
				<path d="M444 49.9C431.3 38.2 379.9 .9 265.3 .4c0 0-135.1-8.1-200.9 52.3C27.8 89.3 14.9 143 13.5 209.5c-1.4 66.5-3.1 191.1 117 224.9h.1l-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM457.9 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9 .4-85.7 .4-85.7-.1 0-.1 0 0 0-101.8-28.2-95.8-134.3-94.7-189.8 1.1-55.5 11.6-101 42.6-131.6 55.7-50.5 170.4-43 170.4-43 96.9 .4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9 .6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4 .7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5 .9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9 .1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7 .5 133 51.4 133.7 139.2zM374.9 329v.2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8h.2c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1 .8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z"/>
			</svg>
			<?php echo esc_html( $phoneOne ); ?>
		</a>
		<a
				rel="noindex, nofollow"
				href="tel:<?php echo esc_html( apply_filters( 'sanitize_phone_number', $phoneTwo ) ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
				<path d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z"/>
			</svg>
			<?php echo esc_html( $phoneTwo ); ?>
		</a>
	</div>

</div>
<?php wp_footer(); ?>
</body>
</html>
