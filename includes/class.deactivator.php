<?php

class WPSPLI_Smart_PipeLiner_Deactivator
{
    public function deactivate() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		$smart_pipeliner_report_table_name 			= $wpdb->prefix . 'smart_pipeliner_report';
		$smart_pipeliner_field_mapping_table_name 	= $wpdb->prefix . 'smart_pipeliner_field_mapping';

		delete_option('wpspli_smart_pipeliner_settings');
		delete_option('wpspli_smart_pipeliner');
		delete_option('wpspli_smart_pipeliner_modules_fields');
	}
}
?>