<?php
class WPSPLI_Smart_Pipeliner_Field_Mappings {

	var $customer_fields;
	
	public function __construct(){
    	$this->deleteMappingRowFromTable();
    }

    public function processMappingsForm($POST = array()){
       	global $wpdb;
       	if(isset($_REQUEST['add_mapping'])){

       		extract($_POST);

       		$record_exists = $wpdb->get_row( 
       			$wpdb->prepare(
       				"
       				SELECT * FROM ".$wpdb->prefix ."smart_pipeliner_field_mapping  WHERE wp_module = %s AND wp_field = %s  AND pipeliner_module = %s AND pipeliner_field = %s
       				" ,
       				$wp_module, $wp_field, $pipeliner_module, $pipeliner_field
       				)
       			
       		);

			if ( null !== $record_exists ) {
				
			  $reccord_id 		= $record_exists->id;
			  $is_predefined 	= $record_exists->is_predefined;
			  

			  	$wpdb->update(
					$wpdb->prefix . 'smart_pipeliner_field_mapping', 
					array( 
					    'wp_module' 	=> sanitize_text_field($wp_module),
					    'wp_field' 		=> sanitize_text_field($wp_field),
					    'pipeliner_module' 	=> sanitize_text_field($pipeliner_module),
					    'pipeliner_field'	=> sanitize_text_field($pipeliner_field), 
					    'status' 		=> sanitize_text_field($status),
					    'description' 	=> sanitize_text_field($description), 
					    'is_predefined' => sanitize_text_field($is_predefined), 
					), 
					array( 'id' => $reccord_id ), 
					array( 
					    '%s', 
					    '%s', 
					    '%s', 
					    '%s', 
					    '%s', 
					    '%s', 
					    '%s'
					),
					array( '%d' )
				);

			}else{

				$wpdb->insert(
					$wpdb->prefix . 'smart_pipeliner_field_mapping', 
					array( 
					    'wp_module' 	=> sanitize_text_field($wp_module),
					    'wp_field' 		=> sanitize_text_field($wp_field),
					    'pipeliner_module' 	=> sanitize_text_field($pipeliner_module),
					    'pipeliner_field'	=> sanitize_text_field($pipeliner_field), 
					    'status' 		=> sanitize_text_field($status),
					    'description' 	=> sanitize_text_field($description), 
					    'is_predefined' => 'no', 
					), 
					array( 
					    '%s', 
					    '%s', 
					    '%s', 
					    '%s', 
					    '%s', 
					    '%s', 
					    '%s'
					) 
				);	

			}
       		
       	}
    }

    public function deleteMappingRowFromTable(){
		if( isset( $_REQUEST['action'] ) && isset( $_REQUEST['id'] ) &&  $_REQUEST['action'] == 'trash' ){
			global $wpdb;
	   		$wpdb->delete( 
				$wpdb->prefix . 'smart_pipeliner_field_mapping', 
				array( 
				    'id' 	=> sanitize_text_field($_REQUEST['id']),
				), 
				array( 
				    '%d'
				) 
			);
			wp_redirect(admin_url('admin.php?page=wpspli-smart-pipeliner-mappings'));
			exit();
		}    	
    }

    public function displayMappingsForm(){
        $wp_module 		= isset($_GET['wp_module']) ? sanitize_text_field($_GET['wp_module']) : false;
        $pipeliner_module 	= isset($_GET['pipeliner_module']) ? sanitize_text_field($_GET['pipeliner_module']) : false;

        $smart_pipeliner_obj = new WPSPLI_Smart_Pipeliner();
        $wp_modules 	= $smart_pipeliner_obj->get_wp_modules();
        $getListModules = $smart_pipeliner_obj->get_pipeliner_modules();
        
       	require_once WPSPLI_PLUGIN_PATH . 'admin/partials/field-mappings.php';	
    }

    public function displayMappingsFieldList(){

       	require_once WPSPLI_PLUGIN_PATH . 'admin/partials/mappings-field-list.php';	
    }
}
?>