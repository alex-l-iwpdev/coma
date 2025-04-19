<?php
/**
 * Created 04.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\Helpers
 */

namespace IWP\Helpers;

use IWP\Helpers\Kama_Breadcrumbs;

/**
 * HelpersFrontEnd Class.
 * Helps process frontend pins and data.
 */
class HelpersFrontEnd {
	/**
	 * HelpersFrontEnd Constructor.
	 */
	public function __construct() {
		add_filter( 'sanitize_phone_number', [ $this, 'sanitizePhoneNumber' ], 10, 1 );
	}

	/**
	 * Clears the phone number from spaces and dashes brackets.
	 *
	 * @param string $phone Phone Number.
	 *
	 * @return string
	 */
	public function sanitizePhoneNumber( string $phone ): string {
		if ( empty( $phone ) ) {
			return '';
		}

		return filter_var( $phone, FILTER_SANITIZE_NUMBER_INT );
	}

	/**
	 * Kama Breadcrumbs.
	 *
	 * @param string $sep  Step.
	 * @param array  $l10n L10n.
	 * @param array  $args Arguments.
	 */
	public function kama_breadcrumbs( $sep = ' » ', $l10n = [], $args = [] ) {
		$kb = new Kama_Breadcrumbs();
		echo $kb->get_crumbs( $sep, $l10n, $args );
	}
}
