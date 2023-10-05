<?php
class WPSPLI_Smart_PipeLiner_Admin_Settings {

    public function processSettingsForm($POST = array()){
       
        $client_id = $client_secret = "";
        
       	if ( isset( $_POST['submit'] ) ) {

            if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == "general"){
                $client_id                  = sanitize_text_field($_REQUEST['wpspli_smart_pipeliner_settings']['client_id']);
                $client_secret              = sanitize_text_field($_REQUEST['wpspli_smart_pipeliner_settings']['client_secret']);
                $wpspli_smart_pipeliner_data_center  = sanitize_text_field($_REQUEST['wpspli_smart_pipeliner_settings']['data_center']);    
            }
                        
            $wpspli_smart_pipeliner_settings  = !empty(get_option( 'wpspli_smart_pipeliner_settings' )) ? get_option( 'wpspli_smart_pipeliner_settings' ) : array();

            $wpspli_smart_pipeliner_settings = array_merge($wpspli_smart_pipeliner_settings, $_REQUEST['wpspli_smart_pipeliner_settings']);
            
            update_option( 'wpspli_smart_pipeliner_settings', $wpspli_smart_pipeliner_settings );
            
            if ( $client_id && $client_secret ) {
                $redirect_uri = esc_url(WPSPLI_REDIRECT_URI);
                $redirect_url = "$wpspli_smart_pipeliner_data_center/oauth/v2/auth?client_id=$client_id&redirect_uri=$redirect_uri&response_type=code&scope=PipelinerCRM.modules.all,PipelinerCRM.settings.all&access_type=offline";
                if ( wp_redirect( $redirect_url ) ) {
				    exit;
				}
            }
            
        }
    }

    public function displaySettingsForm(){
        require_once WPSPLI_PLUGIN_PATH . 'admin/partials/settings.php';
    }
}
?>