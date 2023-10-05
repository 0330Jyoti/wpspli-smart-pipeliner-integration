<?php
class WPSPLI_Smart_PipeLiner_Admin_Synchronization {

    public function processSynch($POST = array()){
       
       	if ( isset( $_POST['submit'] ) ) {

            if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == "general"){
                $client_id                  = sanitize_text_field($_REQUEST['wpspli_smart_pipeliner_settings']['client_id']);
                $client_secret              = sanitize_text_field($_REQUEST['wpspli_smart_pipeliner_settings']['client_secret']);
                $wpspli_smart_pipeliner_data_center  = sanitize_text_field($_REQUEST['wpspli_smart_pipeliner_settings']['data_center']);
            }
                        
            $wpspli_smart_pipeliner_settings  = !empty(get_option( 'wpspli_smart_pipeliner_settings' )) ? get_option( 'wpspli_smart_pipeliner_settings' ) : array();

            $wpspli_smart_pipeliner_settings = array_merge($wpspli_smart_pipeliner_settings, $_REQUEST['wpspli_smart_pipeliner_settings']);
            
            update_option( 'wpspli_smart_pipeliner_settings', $wpspli_smart_pipeliner_settings );
            
        }


        /*Synch product*/
        if( isset( $_POST['smart_synch'] ) && $_POST['smart_synch'] == 'pipeliner' ){

           
            $id = $_POST['id'];

            switch ($_POST['wp_module']) {
                
                case 'products':
                    
                    $WPSPLI_Smart_Pipeliner_Public = new WPSPLI_Smart_Pipeliner_Public();
                    $WPSPLI_Smart_Pipeliner_Public->addProductToPipeliner( $id );

                    break;

                case 'orders':
                    
                    $WPSPLI_Smart_Pipeliner_Public = new WPSPLI_Smart_Pipeliner_Public();
                    $WPSPLI_Smart_Pipeliner_Public->addOrderToPipeliner( $id );

                    break;

                case 'customers':
                    
                    $WPSPLI_Smart_Pipeliner_Public = new WPSPLI_Smart_Pipeliner_Public();
                    $WPSPLI_Smart_Pipeliner_Public->addUserToPipeliner( $id );

                    break;    
                
                default:
                    # code...
                    break;
            }
            
        }
        

    }

    public function displaySynchData(){
        require_once WPSPLI_PLUGIN_PATH . 'admin/partials/synchronization.php';
    }
}
?>