<?php
namespace itph;

class ITPH_Feedback_Stats {
	public static $options;

	/**
	 * Fetch the plugin options.
	 */
	public static function init() :void {
		self::$options = get_option( 'itph_plugin_options' );
	}

	/**
	 * Produce feedback stats markup.
	 */
	public static function build_markup() : void {
		$post_id = get_the_ID();
		$opts = self::$options;

		echo '<p><b>' . $opts['question_text'] . '</b></p>';

		if ( $opts['answer_set_type'] == 'standard' ) {
			$positive = get_post_meta( $post_id, 'itph_sset_positive', true ) ?: 0;
			$negative = get_post_meta( $post_id, 'itph_sset_negative', true ) ?: 0;

			echo "
				<div class=\"feedback-entry\">
					<span class=\"colored-counter\" style=\"color: {$opts['positive_answer_fg_color']}; background-color: {$opts['positive_answer_bg_color']}\">$positive</span>
					{$opts['positive_answer']}
				</div>
				<div class=\"feedback-entry\">
					<span class=\"colored-counter\" style=\"color: {$opts['negative_answer_fg_color']}; background-color: {$opts['negative_answer_bg_color']}\">$negative</span>
					{$opts['negative_answer']}
				</div>
			";
		} elseif ( $opts['answer_set_type'] == 'custom' ) {
			$answer_set = json_decode( $opts['custom_answer_set'], true );
			foreach ( $answer_set as $text => $styles ) {
				$fb_num = get_post_meta( $post_id, 'itph_cset_' . $text, true ) ?: 0;
				echo "
					<div class=\"feedback-entry\">
						<span class=\"colored-counter\" style=\"color: {$styles['fgColor']}; background-color: {$styles['bgColor']}\">$fb_num</span>
						$text
					</div>
				";
			}
		} elseif ( $opts['answer_set_type'] == 'stars' ) {
			foreach ( [1, 2, 3, 4, 5] as $stars ) {
				$fb_num = get_post_meta( $post_id, 'itph_star_' . $stars, true ) ?: 0;
				echo "<div class=\"feedback-entry\" style=\"color: #fa0\"><span class=\"pure-counter\">$fb_num</span>";
				for ( $i = 1; $i <= $stars; $i++ ) {
					echo '<span>&#9733;</span>';
				}
				echo '</div>';
			}
		}
	}

	/**
	 * Display feedback stats in widget on the edit post page.
	 */
	public static function show_in_widget() : void {
		add_action( 'admin_init', function () {
			add_meta_box(
				'metabox-post-feedback',
				'Feedback',
				['itph\ITPH_Feedback_Stats', 'build_markup'],
				self::$options['post_types'],
				'side',
				'high'
			);
		} );
	}

	/**
	 * Display feedback stats in column on the posts list page.
	 */
	public static function show_in_column() : void {
		$opts = self::$options;
		$post_types = $opts['post_types'];

		$add_column_cb = ['itph\ITPH_Feedback_Stats', 'add_feedback_stats_column'];
		$show_column_cb = ['itph\ITPH_Feedback_Stats', 'show_feedback_stats_column'];

		foreach ( $post_types as $post_type ) {
			if ( $post_type == 'post' ) {
				add_filter( 'manage_posts_columns', $add_column_cb );
				add_action( 'manage_posts_custom_column', $show_column_cb );
				continue;
			}
			if ( $post_type == 'page' ) {
				add_filter( 'manage_pages_columns', $add_column_cb );
				add_action( 'manage_pages_custom_column', $show_column_cb );
				continue;
			}
			add_filter( 'manage_' . $post_type . '_posts_columns', $add_column_cb );
			add_action( 'manage_' . $post_type . '_posts_custom_column', $show_column_cb );
		}
	}

	/**
	 * Add new column to the posts list table.
	 */
	public static function add_feedback_stats_column( array $columns ) : array {
		$columns['itph_feedback'] = 'Feedback';
		return $columns;
	}

	/**
	 * Display custom column in the posts list table.
	 */
	public static function show_feedback_stats_column( string $column ) : void {
		if ( $column == 'itph_feedback' ) {
			self::build_markup();
		}
	}
}
?>
