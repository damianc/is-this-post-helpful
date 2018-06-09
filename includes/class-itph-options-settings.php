<?php
namespace itph;

require_once 'class-itph-markup-displayer.php';
require_once 'class-itph-input-validator.php';

class ITPH_Options_Settings {

	public static $markup_displayer;

	/**
	 * Register settings for the plugin.
	 */
	public static function init() : void {
		add_action( 'admin_init', function () : void {
			self::$markup_displayer = new ITPH_Markup_Displayer( [
				'options' => get_option( 'itph_plugin_options' )
			] );

			register_setting(
				'itph_plugin_options',
				'itph_plugin_options',
				['itph\ITPH_Options_Settings', 'sanitize_input']
			);

			self::add_settings_sections();
			self::add_settings_section_fields();
		});
	}

	/**
	 * Add sections for the plugin settings.
	 */
	private static function add_settings_sections() : void {
		add_settings_section(
			'itph_setting_section',
			'Box components text',
			function () : void {
				echo 'Define text of the question and answer buttons.';
			},
			'is-this-post-helpful'
		);

		add_settings_section(
			'itph_layout_section',
			'Box components layout',
			function () : void {
				echo 'Set the feedback layer layout.';
			},
			'is-this-post-helpful'
		);

		add_settings_section(
			'itph_general_section',
			'General settings.',
			function () : void {
				echo 'Define general options of the feedback.';
			},
			'is-this-post-helpful'
		);
	}

	/**
	 * Add fields for the plugin settings sections.
	 */
	private static function add_settings_section_fields() : void {
		// Setting section / question text
		add_settings_field(
			'itph_question_text',
			'Question text',
			[self::$markup_displayer, 'display_field_markup'],
			'is-this-post-helpful',
			'itph_setting_section',
			['option' => 'question_text']
		);

		// Setting section / answer texts
		add_settings_field(
			'itph_answer_settings',
			'Answer texts',
			[self::$markup_displayer, 'display_answers_markup'],
			'is-this-post-helpful',
			'itph_setting_section'
		);

		// Layout section / layer layout
		add_settings_field(
			'itph_layer_layout',
			'Components layout',
			[self::$markup_displayer, 'display_layout_variants'],
			'is-this-post-helpful',
			'itph_layout_section'
		);

		// Layout section / layer styling
		add_settings_field(
			'itph_layer_styling',
			'Feedback box styling',
			[self::$markup_displayer, 'display_layout_styling'],
			'is-this-post-helpful',
			'itph_layout_section'
		);

		// General section / response message
		add_settings_field(
			'itph_response_message',
			'Response shown after a feedback is sent',
			[self::$markup_displayer, 'display_field_markup'],
			'is-this-post-helpful',
			'itph_general_section',
			['option' => 'response_message']
		);

		// General section / post types involved
		add_settings_field(
			'itph_post_types',
			'Apply for given post types',
			[self::$markup_displayer, 'display_post_types'],
			'is-this-post-helpful',
			'itph_general_section'
		);
	}

	/**
	 * Sanitize input data from the settings page.
	 */
	public static function sanitize_input( array $input ) : array {
		$valid = $input;
		$valid = ITPH_Input_Validator::empty_values( $valid );
		$valid = ITPH_Input_Validator::negative_padding( $valid );

		return $valid;
	}
}
?>
