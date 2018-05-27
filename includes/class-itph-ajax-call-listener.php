<?php
namespace itph;

class ITPH_AJAX_Call_Listener {

	/**
	 * Attach AJAX call listener.
	 */
	public static function init() : void {
		$update_feedback_cb = ['itph\ITPH_AJAX_Call_Listener', 'update_feedback'];

		add_action( 'wp_ajax_nopriv_itph_post_feedback', $update_feedback_cb );
		add_action( 'wp_ajax_itph_post_feedback', $update_feedback_cb );
	}

	/**
	 * Update post meta field.
	 */
	public static function update_feedback() : void {
		$post_id = $_POST['post_id'];
		$opts = get_option( 'itph_plugin_options' );

		if ( $opts['answer_set_type'] == 'standard' ) {
			$field_name = 'itph_sset_' . ( $_POST['value'] == 'positive' ? 'positive' : 'negative' );
		} elseif ( $opts['answer_set_type'] == 'custom' ) {
			$field_name = 'itph_cset_' . htmlspecialchars( $_POST['value'] );
		} elseif ( $opts['answer_set_type'] == 'stars' ) {
			$field_name = 'itph_star_' . $_POST['value'];
		}

		$current_value = (int) get_post_meta( $post_id, $field_name, true ) ?: 0;
		update_post_meta( $post_id, $field_name, $current_value + 1 );
	}

}
?>
