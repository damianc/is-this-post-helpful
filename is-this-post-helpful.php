<?php
/*
Plugin Name: Is This Post Helpful
Plugin URI: https://github.com/damianc/is-this-post-helpful
Description: Collect feedback from your readers with simplistic question box or even turn it into star-based rating.
Version: 1.0
Author: Damian Czapiewski
*/

if ( ! defined( 'ABSPATH' ) ) {
	http_response_code( 403 );
	die( 'Forbidden' );
}

require_once 'includes/class-itph-options-page.php';
require_once 'includes/class-itph-options-settings.php';
require_once 'includes/class-itph-options-defaults.php';

require_once 'includes/class-itph-assets-enqueuer.php';
require_once 'includes/class-itph-ajax-call-listener.php';

require_once 'includes/class-itph-content-filter.php';
require_once 'includes/class-itph-feedback-stats.php';


itph\ITPH_Options_Page::register();
itph\ITPH_Options_Settings::init();

itph\ITPH_Assets_Enqueuer::$plugin_path = plugin_dir_url( __FILE__ );
itph\ITPH_Assets_Enqueuer::back();
itph\ITPH_Assets_Enqueuer::front();

itph\ITPH_AJAX_Call_Listener::init();

itph\ITPH_Content_Filter::init();

itph\ITPH_Feedback_Stats::init();
itph\ITPH_Feedback_Stats::show_in_widget();
itph\ITPH_Feedback_Stats::show_in_column();


register_activation_hook( __FILE__, function () : void {
	update_option( 'itph_plugin_options', itph\ITPH_Options_Defaults::get() );
} );
?>
