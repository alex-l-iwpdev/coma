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
<?php wp_footer(); ?>
</body>
</html>
