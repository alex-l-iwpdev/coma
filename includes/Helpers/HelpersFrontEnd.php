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

	/**
	 * Формирует массив данных для GA4 ecommerce события add_to_cart.
	 * Возвращает массив, который можно напрямую передать в dataLayer.push().
	 *
	 * Пример использования в JS (после JSON-энкода результата):
	 * dataLayer.push( {...} );
	 *
	 * @param int         $product_id   ID товара.
	 * @param int         $quantity     Количество.
	 * @param string      $list_name    Название списка (item_list_name).
	 * @param int         $index        Порядковый номер товара в списке.
	 * @param string|null $currency     Валюта. По умолчанию — валюта магазина WooCommerce.
	 * @param float|null  $value        Общая сумма корзины для события. Если не задано — price*quantity.
	 *
	 * @return array Структура события GA4 add_to_cart.
	 */
	public function build_ga4_add_to_cart_event(
		int $product_id,
		int $quantity = 1,
		string $list_name = '',
		int $index = 0,
		?string $currency = null,
		?float $value = null
	): array {
		if ( ! function_exists( 'wc_get_product' ) ) {
			return [];
		}

		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			return [];
		}

		$price    = (float) $product->get_price(); // учитывает скидку, если есть
		$quantity = max( 1, (int) $quantity );
		$subtotal = $price * $quantity;

		if ( null === $currency ) {
			$currency = function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : 'UAH';
		}

		// SKU или ID
		$item_id = $product->get_sku();
		if ( empty( $item_id ) ) {
			$item_id = (string) $product->get_id();
		}

		// Название товара
		$item_name = $product->get_name();

		// Бренд — пытаемся получить из таксономии product_brand или атрибута pa_brand
		$item_brand = '';
		if ( taxonomy_exists( 'product_brand' ) ) {
			$brand_terms = get_the_terms( $product->get_id(), 'product_brand' );
			if ( ! is_wp_error( $brand_terms ) && ! empty( $brand_terms ) ) {
				$item_brand = $brand_terms[0]->name;
			}
		}
		if ( '' === $item_brand ) {
			$brand_attr = $product->get_attribute( 'pa_brand' );
			if ( ! empty( $brand_attr ) ) {
				$item_brand = $brand_attr;
			}
		}

		// Категории товара (иерархия до 3 уровней)
		$item_category  = '';
		$item_category2 = '';
		$item_category3 = '';

		$cat_terms = get_the_terms( $product->get_id(), 'product_cat' );
		if ( ! is_wp_error( $cat_terms ) && ! empty( $cat_terms ) ) {
			$cat = $cat_terms[0]; // берем первую категорию
			// Получаем иерархию от верхней к нижней
			$ancestors = array_reverse( get_ancestors( $cat->term_id, 'product_cat' ) );
			$chain     = [];
			foreach ( $ancestors as $ancestor_id ) {
				$term = get_term( $ancestor_id, 'product_cat' );
				if ( $term && ! is_wp_error( $term ) ) {
					$chain[] = $term->name;
				}
			}
			$chain[] = $cat->name; // текущая категория в конце

			$item_category  = $chain[0] ?? '';
			$item_category2 = $chain[1] ?? '';
			$item_category3 = $chain[2] ?? '';
		}

		$item = [
			'item_id'        => $item_id,
			'item_name'      => $item_name,
			'item_brand'     => $item_brand,
			'item_category'  => $item_category,
			'item_category2' => $item_category2,
			'item_category3' => $item_category3,
			'item_list_name' => $list_name,
			'price'          => round( $price, 2 ),
			'quantity'       => $quantity,
			'index'          => (int) $index,
		];

		$event = [
			'event'     => 'add_to_cart',
			'ecommerce' => [
				'currency' => $currency,
				'value'    => round( null !== $value ? (float) $value : $subtotal, 2 ),
				'items'    => [ $item ],
			],
		];

		return $event;
	}
}
