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

$logoHeader      = ! empty( get_theme_mod( 'coma_logo' ) ) ? get_theme_mod( 'coma_logo' ) : false;
$scheduleWork    = ! empty( get_theme_mod( 'coma_schedule' ) ) ? get_theme_mod( 'coma_schedule' ) : false;
$phoneOne        = ! empty( get_theme_mod( 'coma_phone_one' ) ) ? get_theme_mod( 'coma_phone_one' ) : false;
$phoneTwo        = ! empty( get_theme_mod( 'coma_phone_two' ) ) ? get_theme_mod( 'coma_phone_two' ) : false;
$adviceTetx      = ! empty( get_theme_mod( 'coma_action_button_consultation_text' ) ) ? get_theme_mod( 'coma_action_button_consultation_text' ) : '';
$adviceUrl       = ! empty( get_theme_mod( 'coma_action_button_consultation_url' ) ) ? get_theme_mod( 'coma_action_button_consultation_url' ) : false;
$appointmentUrl  = ! empty( get_theme_mod( 'coma_action_button_appointment_url' ) ) ? get_theme_mod( 'coma_action_button_appointment_url' ) : false;
$appointmenttext = ! empty( get_theme_mod( 'coma_action_button_appointment_text' ) ) ? get_theme_mod( 'coma_action_button_appointment_text' ) : false;

// Social.
$facebook  = ! empty( get_theme_mod( 'coma_facebook' ) ) ? get_theme_mod( 'coma_facebook' ) : false;
$instagram = ! empty( get_theme_mod( 'coma_instagram' ) ) ? get_theme_mod( 'coma_instagram' ) : false;
$twitter   = ! empty( get_theme_mod( 'coma_twitter' ) ) ? get_theme_mod( 'coma_twitter' ) : false;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-site-verification" content="9L7IdPf6N6jr5islyNb2Ql-IXYEZXCg29D-UYuwRIL8"/>
	<title><?php bloginfo( 'name' ); ?> | <?php bloginfo( 'description' ); ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.cdnfonts.com/css/montserrat" rel="stylesheet">
	<?php wp_head(); ?>
	<!-- Meta Pixel Code -->
	<script>
		! function( f, b, e, v, n, t, s ) {
			if ( f.fbq ) return;
			n = f.fbq = function() {
				n.callMethod ?
					n.callMethod.apply( n, arguments ) : n.queue.push( arguments );
			};
			if ( ! f._fbq ) f._fbq = n;
			n.push = n;
			n.loaded = ! 0;
			n.version = '2.0';
			n.queue = [];
			t = b.createElement( e );
			t.async = ! 0;
			t.src = v;
			s = b.getElementsByTagName( e )[ 0 ];
			s.parentNode.insertBefore( t, s );
		}( window, document, 'script',
			'https://connect.facebook.net/en_US/fbevents.js'
		);
		fbq( 'init', '1132185267839097' );
		fbq( 'track', 'PageView' );
	</script>
	<noscript>
		<img
				height="1"
				width="1"
				style="display:none"
				src="https://www.facebook.com/tr?id=1132185267839097&ev=PageView&noscript=1"/>
	</noscript>
	<!-- End Meta Pixel Code -->
	<!-- Google Tag Manager -->
	<script>( function( w, d, s, l, i ) {
			w[ l ] = w[ l ] || [];
			w[ l ].push( {
				'gtm.start':
					new Date().getTime(), event: 'gtm.js'
			} );
			var f = d.getElementsByTagName( s )[ 0 ],
				j = d.createElement( s ), dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
			f.parentNode.insertBefore( j, f );
		} )( window, document, 'script', 'dataLayer', 'GTM-M4F6GLBP' );</script>
	<!-- End Google Tag Manager -->

</head>
<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript>
	<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M4F6GLBP"
			height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<header>
	<div class="top-header">
		<div class="container">
			<div class="row justify-content-space-between align-items-center">
				<div class="col">
					<a href="<?php echo esc_url( $appointmentUrl ); ?>" class="btn">
						<?php printf( '%s <strong> %s </strong>', esc_html__( 'Завантажуй наш додаток  ', 'coma' ), esc_html__( ' i отримай -5%', 'coma' ) ); ?>
					</a>
				</div>
				<div class="col">
					<ul>
						<li>
							<a
									rel="noindex, nofollow"
									href="tel:<?php echo esc_html( apply_filters( 'sanitize_phone_number', $phoneOne ) ); ?>"><?php echo esc_html( $phoneOne ); ?></a>
						</li>
						<li>
							<a
									rel="noindex, nofollow"
									href="tel:<?php echo esc_html( apply_filters( 'sanitize_phone_number', $phoneTwo ) ); ?>"><?php echo esc_html( $phoneTwo ); ?></a>
						</li>
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
	</div>
	<div class="container">
		<div class="row align-items-center">
			<div class="col-5">
				<div class="burger"><span></span><span></span><span></span></div>
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'top_bar_header_menu',
						'menu_class'     => 'menu',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					]
				);
				?>
			</div>
			<div class="col-2">
				<a class="logo" href="<?php echo is_front_page() ? '#' : get_bloginfo( 'url' ); ?>">
					<?php if ( $logoHeader ) : ?>
						<img src="<?php echo esc_url( $logoHeader ); ?>" alt="logo">
					<?php else : ?>
						<h3><?php bloginfo( 'name' ); ?></h3>
					<?php endif; ?>
				</a>
			</div>
			<div class="col-5">
				<div class="row align-items-center">
					<div class="col">
						<a href="<?php echo esc_html( $adviceUrl ); ?>" class="button">
							<?php echo esc_html( $adviceTetx ); ?>
						</a>
					</div>
					<div class="col-auto">
						<ul class="menu-icons">
							<!--							<li>-->
							<!--								<a href="#" class="icon-search">-->
							<!---->
							<!--								</a>-->
							<!--							</li>-->
							<li>
								<a
										href="<?php echo esc_url( esc_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>"
										class="icon-user"></a>
							</li>
							<li>
								<?php $items_count = WC()->cart->get_cart_contents_count(); ?>
								<a class="icon-bag" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
									<p
											id="mini-cart-count"
											style="display: <?php echo ! empty( $items_count ) ? 'block' : 'none'; ?>">
										<?php echo $items_count ? esc_html( $items_count ) : ''; ?>
									</p>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'header_menu',
						'menu_class'     => 'menu',
						'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					]
				);
				?>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php
				if ( has_nav_menu( 'header_menu_home_page' ) ) {
					wp_nav_menu(
						[
							'theme_location' => 'header_menu_home_page',
							'menu_class'     => 'menu',
							'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						]
					);
				}
				?>
			</div>
		</div>
	</div>
</header>
