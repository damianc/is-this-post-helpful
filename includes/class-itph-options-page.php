<?php
namespace itph;

class ITPH_Options_Page {
 
	/**
	 * Register a new settings page under Settings.
	 */
	public static function register() : void {
		add_action( 'admin_menu', function () : void {
			add_options_page(
				'Is This Post Helpful plugin settings',
				'Is This Post Helpful',
				'manage_options',
				'is-this-post-helpful',
				['itph\ITPH_Options_Page', 'display_page']
			);
		} );
	}

	/**
	 * Display the setting page under Settings.
	 */
	public static function display_page() : void {
	?>

	<div class="wrap">
		<h1>Is This Post Helpful plugin settings</h1>
		<form action="options.php" method="post" id="itph-settings-form">
			<?php settings_fields( 'itph_plugin_options' ); ?>
			<?php do_settings_sections( 'is-this-post-helpful' ); ?>
			<input type="submit" value="Save Changes" class="button-primary" />
		</form>
	</div>

	<?php
	}
}
?>
