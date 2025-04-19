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

/**
 * Autoloader classes
 */

use IWP\Init\InitThemes;

const COMA_TEMPLATE_DIR = __DIR__;

require_once COMA_TEMPLATE_DIR . '/vendor/autoload.php';

global $comaThemes;
$comaThemes = new InitThemes();
$comaThemes->init();

add_filter( 'woocommerce_get_image_size_woocommerce_thumbnail', function ( $size ) {
	return [
		'width'  => 300,
		'height' => 300,
		'crop'   => 0,
	];
}, 20 );
