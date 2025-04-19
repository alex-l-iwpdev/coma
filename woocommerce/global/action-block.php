<?php
/**
 * Created 09.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * Hook: woocommerce_action_block.
 *
 * @package IWP\Woocommerce
 */

$text                      = ! ( empty( get_theme_mod( 'coma_action_text' ) ) ) ? get_theme_mod( 'coma_action_text' ) : '';
$textButtonConsultation    = ! ( empty( get_theme_mod( 'coma_action_button_consultation_text' ) ) ) ? get_theme_mod( 'coma_action_button_consultation_text' ) : '';
$textButtonConsultationUrl = ! ( empty( get_theme_mod( 'coma_action_button_consultation_url' ) ) ) ? get_theme_mod( 'coma_action_button_consultation_url' ) : '#';
$textButtonAppointment     = ! ( empty( get_theme_mod( 'coma_action_button_appointment_text' ) ) ) ? get_theme_mod( 'coma_action_button_appointment_text' ) : '';
$textButtonAppointmentUrl  = ! ( empty( get_theme_mod( 'coma_action_button_appointment_url' ) ) ) ? get_theme_mod( 'coma_action_button_appointment_url' ) : '#';
?>
<div class="row">
	<div class="col-12">
		<div class="question">
			<p><?php echo esc_html( $text ); ?></p>
			<a class="button transparent" href="<?php echo esc_url( $textButtonConsultationUrl ); ?>" target="_blank" rel="nofollow">
				<?php echo esc_html( $textButtonConsultation ); ?>
			</a>
			<a class="button"
			href="<?php echo esc_url( $textButtonAppointmentUrl ); ?>"
			target="_blank"
			rel="nofollow"><?php echo esc_html( $textButtonAppointment ); ?></a>
		</div>
	</div>
</div>
