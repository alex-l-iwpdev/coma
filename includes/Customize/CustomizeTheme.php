<?php
/**
 * Created 04.08.2021
 * Version 1.0.0
 * Last update
 * Author: Alex L
 * Author URL: https://i-wp-dev.com/
 *
 * @package IWP\Customize
 */

namespace IWP\Customize;

use WP_Customize_Image_Control;

/**
 * Class CustomizeTheme.
 */
class CustomizeTheme {
	/**
	 * Connect to WP_Customize_Manager class.
	 *
	 * @var \WP_Customize_Manager
	 */
	private $customize;

	/**
	 * Constructor CustomizeTheme class.
	 */
	public function __construct() {
		global $wp_customize;
		$this->customize = $wp_customize;

		$this->addSection();

		$this->generalSettings();
		$this->contactSettings();
	}

	/**
	 * Add Section to Customize.
	 */
	public function addSection(): void {
		$this->customize->add_section(
			'general',
			[
				'title'    => __( 'Основні налаштування', 'coma' ),
				'priority' => 70,
			]
		);

		$this->customize->add_section(
			'info',
			[
				'title'    => __( 'Контактні дані', 'coma' ),
				'priority' => 75,
			]
		);

	}

	/**
	 * Add General Settings Field.
	 */
	public function generalSettings(): void {

		// Logo Start.
		$this->customize->add_setting(
			'coma_logo',
			[
				'transport' => 'refresh',
				'height'    => 325,
			]
		);
		$this->customize->add_setting(
			'coma_logo_white',
			[
				'transport' => 'refresh',
				'height'    => 325,
			]
		);

		$this->customize->add_control(
			new WP_Customize_Image_Control(
				$this->customize,
				'coma_logo',
				[
					'label'    => __( 'Логотип', 'coma' ),
					'section'  => 'general',
					'settings' => 'coma_logo',
				]
			)
		);
		$this->customize->add_control(
			new WP_Customize_Image_Control(
				$this->customize,
				'coma_logo_white',
				[
					'label'    => __( 'Білий логотип', 'coma' ),
					'section'  => 'general',
					'settings' => 'coma_logo_white',
				]
			)
		);
		// Logo End.

		// Copyright.
		$this->customize->add_setting(
			'coma_copyright',
			[
				'transport' => 'refresh',
				'height'    => 325,
			]
		);
		$this->customize->add_control(
			'coma_copyright',
			[
				'section' => 'general',
				'label'   => __( 'Копірайт', 'coma' ),
				'type'    => 'textarea',
			]
		);
	}

	/**
	 * Add Contact Settings Field.
	 */
	public function contactSettings(): void {

		// Schedule.
		$this->customize->add_setting(
			'coma_schedule',
			[
				'transport' => 'refresh',
				'height'    => 325,
			]
		);
		$this->customize->add_control(
			'coma_schedule',
			[
				'section' => 'info',
				'label'   => __( 'Графік роботи', 'coma' ),
				'type'    => 'textarea',
			]
		);

		// Contact phone.
		$this->customize->add_setting(
			'coma_phone_one',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_phone_one',
			[
				'section' => 'info',
				'label'   => __( 'Телефон 1', 'coma' ),
				'type'    => 'text',
			]
		);
		$this->customize->add_setting(
			'coma_phone_two',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_phone_two',
			[
				'section' => 'info',
				'label'   => __( 'Телефон 2', 'coma' ),
				'type'    => 'text',
			]
		);

		// Social Link.
		$this->customize->add_setting(
			'coma_facebook',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_facebook',
			[
				'section' => 'info',
				'label'   => __( 'Facebook', 'coma' ),
				'type'    => 'url',
			]
		);
		$this->customize->add_setting(
			'coma_instagram',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_instagram',
			[
				'section' => 'info',
				'label'   => __( 'Facebook', 'coma' ),
				'type'    => 'url',
			]
		);
		$this->customize->add_setting(
			'coma_twitter',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_twitter',
			[
				'section' => 'info',
				'label'   => __( 'Twitter', 'coma' ),
				'type'    => 'url',
			]
		);

		// Action Block.
		$this->customize->add_setting(
			'coma_action_text',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_action_text',
			[
				'section' => 'info',
				'label'   => __( 'Текст', 'coma' ),
				'type'    => 'textarea',
			]
		);
		$this->customize->add_setting(
			'coma_action_button_consultation_text',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_action_button_consultation_text',
			[
				'section' => 'info',
				'label'   => __( 'Текст кнопки консультація', 'coma' ),
				'type'    => 'text',
			]
		);
		$this->customize->add_setting(
			'coma_action_button_consultation_url',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_action_button_consultation_url',
			[
				'section' => 'info',
				'label'   => __( 'URL кнопки консультація', 'coma' ),
				'type'    => 'url',
			]
		);
		$this->customize->add_setting(
			'coma_action_button_appointment_text',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_action_button_appointment_text',
			[
				'section' => 'info',
				'label'   => __( 'Текст кнопки записатися на прийом', 'coma' ),
				'type'    => 'text',
			]
		);
		$this->customize->add_setting(
			'coma_action_button_appointment_url',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
				'height'            => 325,
			]
		);
		$this->customize->add_control(
			'coma_action_button_appointment_url',
			[
				'section' => 'info',
				'label'   => __( 'URL кнопки записатися на прийом', 'coma' ),
				'type'    => 'url',
			]
		);
	}
}
