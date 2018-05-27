<?php
namespace itph;

class ITPH_Options_Defaults {
	/**
	 * Get default values for the plugin options.
	 */
	public static function get() : array {
		$defaults = [
			'question_text' => 'Is this post helpful?',
			'answer_set_type' => 'standard',
			'positive_answer' => 'Yes',
			'positive_answer_fg_color' => '#ffffff',
			'positive_answer_bg_color' => '#8080ff',
			'negative_answer' => 'No',
			'negative_answer_fg_color' => '#ffffff',
			'negative_answer_bg_color' => '#8080ff',
			'custom_answer_set' => '{"Yes":{"fgColor":"#ffffff","bgColor":"#7cb342"},"In a way":{"fgColor":"#ffffff","bgColor":"#cccccc"},"No":{"fgColor":"#ffffff", "bgColor":"#e53935"}}',
			'layout' => 'inline-left',
			'box-margin-top' => 20,
			'box-margin-bottom' => 20,
			'box-margin-left' => 0,
			'box-margin-right' => 0,
			'box-padding-top' => 20,
			'box-padding-bottom' => 20,
			'box-padding-left' => 20,
			'box-padding-right' => 20,
			'question_text_fg_color' => '#222222',
			'question_text_bg_color' => '#ffffff',
			'question_text_border_color' => '#aaaaaa',
			'response_message' => 'Thank you!',
			'post_types' => ['post']
		];

		return $defaults;
	}
}
?>
