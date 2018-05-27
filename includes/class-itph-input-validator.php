<?php
namespace itph;

require_once 'class-itph-options-defaults.php';

class ITPH_Input_Validator {
	/**
	 * Check if input data contains empty fields.
	 */
	public static function empty_values( array $input ) : array {
		$defaults = ITPH_Options_Defaults::get();
		$empty_value_err = false;
		$empties = [];

		$passed_unconditionally = [
			'question_text', 'question_text_fg_color', 'question_text_bg_color', 'question_text_border_color',
			'box-margin-top', 'box-margin-bottom', 'box-margin-left', 'box-margin-right',
			'box-padding-top', 'box-padding-bottom', 'box-padding-left', 'box-padding-right',
			'response_message'
		];

		$passed_conditionally = [];

		if ( $input['answer_set_type'] == 'standard' ) {
			array_push( $passed_conditionally, [
				'positive_answer', 'positive_answer_fg_color', 'positive_answer_bg_color',
				'negative_answer', 'negative_answer_fg_color', 'negative_answer_bg_color'
			] );
		}

		$passed = array_merge( $passed_unconditionally, $passed_conditionally );

		// empty string checking

		foreach ( $passed as $val ) {
			if ( isset( $input[ $val ] ) && $input[ $val ] == '' ) {
				$empty_value_err = true;
				$empties[] = $val;
				$input[ $val ] = $defaults[ $val ];
			}
		}

		// empty object checking

		if ( ! isset( $input['post_types'] ) ) {
			$empty_value_err = true;
			$empties[] = 'post_types';
			$input['post_types'] = $defaults['post_types'];
		} 

		if ( $input['answer_set_type'] == 'custom' ) {
			if ( isset( $input['custom_answer_set'] ) && $input['custom_answer_set'] == '{}' ) {
				$empty_value_err = true;
				$empties[] = 'custom_answer_set';
				$input['custom_answer_set'] = $defaults['custom_answer_set'];
			}
		}

		if ( $empty_value_err ) {
			add_settings_error(
				'itph_general_settings',
				'itph_padding_error',
				'
					You passed empty values! Default values have been used instead.
					<p><small>FIELDS CORRECTED: ' . implode(', ', $empties) . '</small></p>
				',
				'error'
			);
		}

		return $input;
	}

	/**
	 * Check if input data contains negative values for the padding.
	 */
	public static function negative_padding(array $input) : array {
		$padding_err = false;

		if ( (int) $input['box-padding-top'] < 0 ) {
			$input['box-padding-top'] = 0;
			$padding_err = true;
		}

		if ( (int) $input['box-padding-bottom'] < 0 ) {
			$input['box-padding-bottom'] = 0;
			$padding_err = true;
		}

		if ( (int) $input['box-padding-left'] < 0 ) {
			$input['box-padding-left'] = 0;
			$padding_err = true;
		}

		if ( (int) $input['box-padding-right'] < 0 ) {
			$input['box-padding-right'] = 0;
			$padding_err = true;
		}

		if ( $padding_err ) {
			add_settings_error(
				'itph_layer_padding',
				'itph_padding_error',
				'Padding cannot be negative! 0\'s have been used instead.',
				'error'
			);
		}

		return $input;
	}
}
?>
