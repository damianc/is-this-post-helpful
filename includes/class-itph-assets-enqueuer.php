<?php
namespace itph;

class ITPH_Assets_Enqueuer {
	public static $plugin_path;

	/**
	 * Enqueue assets used on back-end pages.
	 */
	public static function back() : void {
		add_action( 'admin_enqueue_scripts', function ( string $hook ) : void {
			wp_enqueue_style(
				'feedback-stats',
				self::$plugin_path . 'css/back/feedback-stats.css'
			);

			if ( $hook != 'settings_page_is-this-post-helpful' ) {
				return;
			}

			// scripts

			wp_register_script(
				'settings-form',
				self::$plugin_path . 'js/back/settings-form.js',
				['jquery', 'button-preview', 'box-preview', 'custom-answer'], 101, true
			);

			wp_register_script(
				'button-preview',
				self::$plugin_path . 'js/back/button-preview.js',
				['jquery'], null, true
			);

			wp_register_script(
				'box-preview',
				self::$plugin_path . 'js/back/box-preview.js',
				['jquery'], null, true
			);

			wp_register_script(
				'custom-answer',
				self::$plugin_path. 'js/back/custom-answer.js',
				['jquery'], null, true
			);

			wp_enqueue_script( 'settings-form' );
			wp_enqueue_script( 'button-preview' );
			wp_enqueue_script( 'custom-answer' );

			// styles

			wp_enqueue_style(
				'settings-form',
				self::$plugin_path . 'css/back/settings-form.css'
			);
		} );
	}

	/**
	 * Enqueue assets used on front-end pages.
	 */
	public static function front() : void {
		add_action( 'wp_enqueue_scripts', function () : void {
			// scripts

			wp_register_script(
				'feedback-box',
				self::$plugin_path . 'js/front/feedback-box.js',
				['jquery'], null, true
			);

			$plugin_options = get_option( 'itph_plugin_options' );
			$params = [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'response_message' => $plugin_options['response_message'],
				'post_id' => get_the_ID()
			];

			wp_enqueue_script( 'feedback-box' );
			wp_localize_script( 'feedback-box', 'itph_plugin_params', $params );

			// styles

			wp_enqueue_style(
				'feedback-box',
				self::$plugin_path . 'css/front/feedback-box.css'
			);
		} );
	}
}
?>
