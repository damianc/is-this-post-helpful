<?php
// Exit if called from out of WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// Delete options no longer needed.
delete_option( 'itph_plugin_options' );

// Delete post meta no longer needed.
$sql = "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE %s";
$safe_sql = $wpdb->prepare($sql, 'itph_%');
$wpdb->query($safe_sql);
?>
