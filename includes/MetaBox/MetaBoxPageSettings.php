<?php
/**
 * Created 16.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\MetaBox
 */

namespace IWP\MetaBox;

/**
 * MetaBoxPageSettings Class.
 */
class MetaBoxPageSettings {
	/**
	 * Construct MetaBoxPageSettings.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'init' ] );
		add_action( 'save_post', [ $this, 'savePostMeta' ] );
	}

	/**
	 * Init MetaBox.
	 */
	public function init(): void {
		add_meta_box(
		'iwp-page-settings',
		__( 'Налаштування сторінки', 'coma' ),
		[ $this, 'metaBoxCallback' ],
		'page',
		'normal',
		'high',
		[
		'__back_compat_meta_box' => false,
		]
		);
	}

	/**
	 * Output Meta Box form.
	 *
	 * @param Object $post post.
	 */
	public function metaBoxCallback( $post ): void {
		wp_nonce_field( 'iwp_nonce', 'iwp_noncename' );

		$outputTitle = get_post_meta( $post->ID, 'iwp_page_settings_title', true );
		if ( ! $outputTitle ) {
			$outputTitle = 'on';
		}
		?>
		<div class="form-check">
			<input class="form-check-input" type="radio" name="iwp_page_settings_title" id="iwp-page-settings-title-off" value="off"
			<?php echo( 'off' === $outputTitle ? 'checked' : '' ); ?>>
			<label class="form-check-label" for="iwp-page-settings-title-off">
				<?php echo esc_html__( 'Відключити назву сторінки', 'coma' ); ?>
			</label>
		</div>
		<div class="form-check">
			<input class="form-check-input" type="radio" name="iwp_page_settings_title" id="iwp-page-settings-title-on" value="on"
			<?php echo( 'on' === $outputTitle ? 'checked' : '' ); ?>>
			<label class="form-check-label" for="iwp-page-settings-title-on">
				<?php echo esc_html__( 'Включити назву сторінки', 'coma' ); ?>
			</label>
		</div>
		<?php
	}

	public function savePostMeta( $post_id ) {
		if ( ! isset( $_POST['iwp_page_settings_title'] ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST['iwp_noncename'], 'iwp_nonce' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$title = sanitize_text_field( $_POST['iwp_page_settings_title'] );

		update_post_meta( $post_id, 'iwp_page_settings_title', $title );
	}
}
