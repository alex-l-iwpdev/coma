jQuery( document ).ready( function( $ ) {
	$( document.body ).trigger( 'wc_fragments_refreshed' );

	/**
	 * Header language switcher
	 */
	if ( $( '#language' ).length ) {
		$( '#language' ).change( function( e ) {
			if ( $( this ).prop( 'checked' ) ) {
				$( '.language' ).data( 'active_lang', 'ru' );
				location.href = $( '.language' ).data( 'url_ru' );
			} else {
				$( '.language' ).data( 'active_lang', 'uk' );
				location.href = $( '.language' ).data( 'url_uk' );
			}
		} );
	}

	if ( $( 'body:not(.woocommerce-checkout) select' ).length ) {
		$( 'select:not(#rating)' ).select2( {
			width: '100%',
		} );
	}

	/**
	 * Filter submit.
	 */
	$( '.filters .checkbox input' ).change( function( e ) {
		$( '#filter_product' ).submit();
	} );

	let variationSelect = $( '.variations .value select' );

	if ( variationSelect.length ) {

		variationSelect.change( function( e ) {
			let priceEl = $( this ).parents( '.description' ).find( '.price' );
			let availabilityEL = $( this ).parents( '.description' ).find( '.availability' );
			let availabilityValue = availabilityEL.text();
			let value = $( this ).val().length;


			let variationID = get_variation_id_by_name( $( this ).val() );

			setTimeout( function() {

				if ( value ) {
					let availabilityValue = $( '.single_variation_wrap .woocommerce-variation-availability .stock' );
					availabilityValue.hide();

					if ( 'Немає в наявності' !== availabilityValue.text() ) {
						console.log( 'if', availabilityValue.text(), 'availabilityValue', availabilityValue );
						$( '.description .availability' ).text( 'В наявностi' );
						availabilityEL.removeClass( 'no-active' );
						availabilityEL.addClass( 'active' );
					} else {
						console.log( 'else', availabilityValue.text(), 'availabilityValue', availabilityValue );
						$( '.description .availability' ).text( 'Немає в наявності' );
						availabilityEL.removeClass( 'active' );
						availabilityEL.addClass( 'no-active' );
					}
				}
			}, 200 );
		} );

		$( document ).on( 'show_variation', '.variations_form.cart', function( event, variation ) {
			$( '.description p.price' ).html( variation.price_html );
		} );

		let priceEL = $( '.container .col-lg-7 .price' );
		let defaultPrice = priceEL.text();

		$( '.reset_variations' ).click( function( e ) {
			priceEL.text( defaultPrice );
		} );
	}

	function get_variation_id_by_name( name ) {
		const variationData = $( '.variations_form.cart' ).data( 'product_variations' );

		variationData.map( ( el, i ) => console.log( el, i ) );

		// console.log( variationData );
	}

} );
