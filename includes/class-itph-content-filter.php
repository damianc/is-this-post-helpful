<?php
namespace itph;

class ITPH_Content_Filter {
	public static $options;

	/**
	 * Register filter to the content.
	 */
	public static function init() : void {
		self::$options = get_option( 'itph_plugin_options' );
		$filter_content_cb = ['itph\ITPH_Content_Filter', 'filter_content'];

		add_filter( 'the_content', $filter_content_cb );
		add_filter( 'get_the_content', $filter_content_cb );
	}

	/**
	 * Produce buttons markup.
	 */
	public static function feedback_buttons_markup() : string {
		$opts = self::$options;
		$buttons_markup = '';
		$answer_set;

		if ( $opts['answer_set_type'] == 'custom' ) {
			$answer_set = json_decode( $opts['custom_answer_set'], true );
		} elseif ( $opts['answer_set_type'] == 'standard' ) {
			$answer_set = [
				$opts['positive_answer'] => [
					'fgColor' => $opts['positive_answer_fg_color'],
					'bgColor' => $opts['positive_answer_bg_color'],
					'answerType' => 'positive'
				],
				$opts['negative_answer'] => [
					'fgColor' => $opts['negative_answer_fg_color'],
					'bgColor' => $opts['negative_answer_bg_color'],
					'answerType' => 'negative'
				]
			];
		}

		foreach ( $answer_set as $text => $styles ) {
			$data_attr = '';
			if ( array_key_exists( 'answerType', $styles ) ) {
				$data_attr = "data-answer-type=\"{$styles['answerType']}\"";
			}

			$buttons_markup .= "
				<span class=\"answer-button\" $data_attr style=\"color: {$styles['fgColor']}; background-color: {$styles['bgColor']}\">
					$text
				</span>
			";
		}

		return $buttons_markup;
	}

	/**
	 * Produce stars markup.
	 */
	public static function feedback_stars_markup() : string {
		$opts = self::$options;
		$stars_markup = "
			<style>
			.star-button:hover,
			.star-button:hover ~ .star-button {
				color: #fa0;
			}
			.answer-buttons {
				unicode-bidi: bidi-override;
				direction: rtl;
			}
			</style>
		";

		foreach ( [5, 4, 3, 2, 1] as $rate ) {
			$stars_markup .= "
				<span class=\"star-button\" data-star-num=\"$rate\">&#9733;</span>
			";
		}

		return $stars_markup;
	}

	/**
	 * Add feedback box to the post content.
	 */
	public static function filter_content( string $content ) : string {
		if (
			( ! in_array( get_post_type(), self::$options['post_types'] ) ) ||
			( ! is_single() )
		) {
			return $content;
		}

		$opts = self::$options;
		$feedback_markup;

		if ( $opts['answer_set_type'] == 'standard' || $opts['answer_set_type'] == 'custom' ) {
			$feedback_markup = self::feedback_buttons_markup();
		} elseif ( $opts['answer_set_type'] == 'stars' ) {
			$feedback_markup = self::feedback_stars_markup();
		}

		return $content . "
			<style>
			#itph-feedback-box {
				color: {$opts['question_text_fg_color']};
				background-color: {$opts['question_text_bg_color']};
				border: solid 2px {$opts['question_text_border_color']};
				margin-top: {$opts['box-margin-top']}px;
				margin-bottom: {$opts['box-margin-bottom']}px;
				margin-left: {$opts['box-margin-left']}px;
				margin-right: {$opts['box-margin-right']}px;
				padding-top: {$opts['box-padding-top']}px;
				padding-bottom: {$opts['box-padding-bottom']}px;
				padding-left: {$opts['box-padding-left']}px;
				padding-right: {$opts['box-padding-right']}px;
			}
			</style>
			<div id=\"itph-feedback-box\" class=\"{$opts['layout']}\">
				{$opts['question_text']}
				<div class=\"answer-buttons\">
					$feedback_markup
				</div>
				<div class=\"guard\"></div>
			</div>
		";
	}
}
?>
