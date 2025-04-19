<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

/**
 * Created 08.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 */

$class = '';
$class = apply_filters( 'woocommerce_class_wrapper', $class );
?>
<section>
	<div class="<?php echo esc_attr( $class ); ?>">
		<div class="container">
			<?php echo is_shop() || is_archive() ? '<div class="head-fix">' : ''; ?>
