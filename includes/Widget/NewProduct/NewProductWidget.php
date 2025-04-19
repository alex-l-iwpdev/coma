<?php
/**
 * Created 05.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\Widget\NewProduct
 */

namespace IWP\Widget\NewProduct;

use WP_Widget;

/**
 * NewProductWidget Class.
 */
class NewProductWidget extends WP_Widget {
	/**
	 * RandomWidget constructor.
	 */
	public function __construct() {
		$widget_options = [
		'classname'   => 'new_product_widget',
		'description' => __( 'Цей віджет виводить товар у вигляді банера', 'coma' ),
		];
		parent::__construct( 'new_product_widget', __( 'Нові товари', 'coma' ), $widget_options );
	}

	/**
	 * Output widget in widget zone.
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Instance.
	 */
	public function widget( $args, $instance ): void {
		$title            = apply_filters( 'widget_title', $instance['title'] );
		$textHeadline     = apply_filters( 'widget_title', $instance['text_headline'] );
		$shortDescription = mb_strimwidth( get_the_excerpt( $instance['product_id'] ), 0, 60, "..." );
		echo wp_kses( $args['before_widget'] . $args['before_title'] . $title . $args['after_title'], 'default' ); ?>
		<div class="mini-banner">
			<img src="<?php echo esc_url( $instance['image_uri'] ) ?? ''; ?>" alt="">
			<div class="desc">
				<p class="meta"><?php echo esc_html( $textHeadline ); ?></p>
				<h5><?php echo esc_html( get_the_title( $instance['product_id'] ) ); ?></h5>
				<p><?php echo filter_var( $shortDescription, FILTER_SANITIZE_STRING ); ?></p>
				<a class="button" href="<?php the_permalink( $instance['product_id'] ); ?>"><?php echo esc_html__( 'Детальнiше', 'coma' ); ?></a>
			</div>
		</div>
		<?php
		echo wp_kses( $args['after_widget'], 'default' );
	}

	/**
	 * From Widget.
	 *
	 * @param array $instance Instence.
	 */
	public function form( $instance ) {
		$title        = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$productID    = ! empty( $instance['product_id'] ) ? $instance['product_id'] : '';
		$textHeadline = ! empty( $instance['text_headline'] ) ? $instance['text_headline'] : '';
		$buttonText   = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Заголовок', 'coma' ); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<p>
			<label
			for="<?php echo esc_attr( $this->get_field_id( 'product_id' ) ); ?>">
				<?php echo esc_html__( 'Ідентифікатор товару', 'coma' ); ?>
			</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'product_id' ) ); ?>"
			name="<?php echo esc_attr( $this->get_field_name( 'product_id' ) ); ?>" value="<?php echo esc_attr( $productID ); ?>"/>
		</p>
		<p>
			<label
			for="<?php echo esc_attr( $this->get_field_id( 'text_headline' ) ); ?>">
				<?php echo esc_html__( 'Текст заголовка', 'coma' ); ?>
			</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'text_headline' ) ); ?>"
			name="<?php echo esc_attr( $this->get_field_name( 'text_headline' ) ); ?>" value="<?php echo esc_attr( $textHeadline ); ?>"/>
		</p>
		<p>
			<label
			for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>">
				<?php echo esc_html__( 'Текст кнопки', 'coma' ); ?>
			</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
			name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" value="<?php echo esc_attr( $buttonText ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_uri' ) ); ?>">
				<?php echo esc_html__( 'Банер (зображення)', 'coma' ); ?>
			</label>
			<img class="<?php echo esc_attr( $this->id ); ?>_img"
			src="<?php echo ( ! empty( $instance['image_uri'] ) ) ? esc_url( $instance['image_uri'] ) : ''; ?>"
			style="margin:0;padding:0;max-width:100%;display:block" alt="Image"/>
			<label>
				<input type="text" class="widefat <?php echo esc_attr( $this->id ); ?>_url"
				name="<?php echo esc_attr( $this->get_field_name( 'image_uri' ) ); ?>"
				value="<?php echo esc_url( $instance['image_uri'] ) ?? ''; ?>" style="margin-top:5px;"/>
			</label>
			<input type="button" id="<?php echo esc_attr( $this->id ); ?>" class="button button-primary js_custom_upload_media"
			value="Upload Image"
			style="margin-top:5px;"/>
		</p>
		<?php
	}

	/**
	 * Save data widget.
	 *
	 * @param array $new_instance New Instance.
	 * @param array $old_instance Old Instance.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ): array {
		$instance                  = $old_instance;
		$instance['title']         = wp_strip_all_tags( $new_instance['title'] );
		$instance['product_id']    = wp_strip_all_tags( $new_instance['product_id'] );
		$instance['text_headline'] = wp_strip_all_tags( $new_instance['text_headline'] );
		$instance['button_text']   = wp_strip_all_tags( $new_instance['button_text'] );
		$instance['image_uri']     = wp_strip_all_tags( $new_instance['image_uri'] );

		return $instance;
	}
}
