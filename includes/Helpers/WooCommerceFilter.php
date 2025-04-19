<?php
/**
 * Created 04.09.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\Helpers
 */

namespace IWP\Helpers;

use WP_Term;

/**
 * WooCommerceFilter class file.
 */
class WooCommerceFilter {

	/**
	 * Code Match.
	 *
	 * @var string[] Invalid characters.
	 */
	private $code_match = [
		'"',
		'!',
		'@',
		'#',
		'$',
		'%',
		'^',
		'&',
		'*',
		'(',
		')',
		'_',
		'+',
		'{',
		'}',
		'|',
		':',
		'"',
		'<',
		'>',
		'?',
		'[',
		']',
		';',
		"'",
		',',
		'.',
		'/',
		'',
		'~',
		'`',
		'=',
	];

	/**
	 * Construct WooCommerceFilter class.
	 */
	public function __construct() {
		add_action( 'admin_post_nopriv_iwp_prod_filter', [ $this, 'prodFilterHandler' ] );
		add_action( 'admin_post_iwp_prod_filter', [ $this, 'prodFilterHandler' ] );
	}

	/**
	 * Get Products Category List.
	 *
	 * @return array|WP_Term[]
	 */
	public function getProductTypesList() {
		$productsCategory = get_terms(
			[
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'ASC',
				'parent'     => 0,
			]
		);

		if ( ! empty( $productsCategory ) && ! is_wp_error( $productsCategory ) ) {
			return $productsCategory;
		}

		return [];
	}

	/**
	 * Get products type child.
	 *
	 * @param int $termID Term ID.
	 *
	 * @return array|int[]|string|string[]|\WP_Error|WP_Term[]
	 */
	public function getChildProductType( int $termID ) {
		$productsCategory = get_terms(
			[
				'taxonomy'   => 'product_cat',
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'ASC',
				'parent'     => $termID,
			]
		);

		if ( ! empty( $productsCategory ) && ! is_wp_error( $productsCategory ) ) {
			return $productsCategory;
		}

		return [];
	}

	/**
	 * Unset parent terms if select child term.
	 *
	 * @param array $termsSlugs Array Term Slugs.
	 *
	 * @return array Array slugs.
	 */
	public function unsetParentTerm( array $termsSlugs ): array {
		$termID = [];
		foreach ( $termsSlugs as $term ) {
			$termObj = get_terms(
				[
					'taxonomy'   => 'product_cat',
					'hide_empty' => true,
					'slug'       => $term,

				]
			);

			$termID[ $termObj[0]->term_id ] = $termObj[0]->slug;

			if ( is_wp_error( $termObj ) ) {
				return [];
			}

			if ( 0 !== $termObj[0]->parent ) {
				unset( $termID[ $termObj[0]->parent ] );
			}
		}

		return array_values( $termID );
	}

	/**
	 * Get Product Brands List.
	 *
	 * @return array|WP_Term[]
	 */
	public function getBarantdsList() {
		$productsBarands = get_terms(
			[
				'taxonomy'   => 'berocket_brand',
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'ASC',
			]
		);

		if ( ! empty( $productsBarands ) && ! is_wp_error( $productsBarands ) ) {
			return $productsBarands;
		}

		return [];
	}

	/**
	 * Generate Url Redirect
	 */
	public function prodFilterHandler(): void {
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, 'iwp_prod_filter_nonce', FILTER_SANITIZE_STRING ), 'iwp_prod_filter' ) ) {
			wp_safe_redirect( filter_input( INPUT_POST, '_wp_http_referer', FILTER_SANITIZE_STRING ) );
		}

		$request = ! empty( $_REQUEST['iwp_prod'] ) ? wp_unslash( $_REQUEST['iwp_prod'] ) : [];
		$request = array_filter( $request );

		$params = [];
		foreach ( $request as $key => $item ) {
			$item           = array_filter( (array) $item );
			$params[ $key ] = [];

			foreach ( $item as $value ) {
				$params[ $key ][] = rawurlencode( str_replace( $this->code_match, '-', $value ) );
			}
		}

		$redirect = get_bloginfo( 'url' ) . '/shop/filter/';
		$i        = 0;
		foreach ( $params as $key => $param ) {
			if ( 0 === $i ) {
				$redirect .= $key . '-in-' . implode( '-or-', (array) $param );
				$i ++;
				continue;
			}

			$param = array_filter( $param );

			// Why it is different to the above?
			foreach ( $param as $index => $item ) {
				$addon = ( 0 === $index ) ? '-and-' . $key . '-in-' : '-or-';

				$redirect .= $addon . $item;
			}
		}
		wp_safe_redirect( $redirect . '/' );
		die();
	}

	/**
	 * Parse string URL
	 *
	 * @param string $urlQuery URL Query.
	 *
	 * @return array|false
	 */
	public function parseURLQuery( string $urlQuery ) {
		$paramString = $urlQuery;
		$queryArg    = [];
		if ( ! empty( $paramString ) ) {
			$params = explode( '-and-', $paramString );
			foreach ( $params as $param ) {
				$items     = explode( '-in-', urldecode( $param ) );
				$paramName = $items[0];
				unset( $items[0] );
				if ( preg_match( '-or-', $items[1] ) ) {
					$queryArg[ $paramName ] = explode( '-or-', $items[1] );
				} else {
					$queryArg[ $paramName ] = $items;
				}
			}

			return array_filter( $queryArg );
		} else {
			return false;
		}
	}
}
