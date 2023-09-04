<?php
class WPSPLI_Smart_PipeLiner_Admin_Settings {

    public function processSettingsForm($POST = array()){
       
        $client_id = $client_secret = "";
        
       	if ( isset( $_POST['submit'] ) ) {

            if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == "general"){
                $client_id                  = sanitize_text_field($_REQUEST['wpszi_smart_zoho_settings']['client_id']);
                $client_secret              = sanitize_text_field($_REQUEST['wpszi_smart_zoho_settings']['client_secret']);
                $wpszi_smart_zoho_data_center  = sanitize_text_field($_REQUEST['wpszi_smart_zoho_settings']['data_center']);    
            }
                        
            $wpszi_smart_zoho_settings  = !empty(get_option( 'wpszi_smart_zoho_settings' )) ? get_option( 'wpszi_smart_zoho_settings' ) : array();

            $wpszi_smart_zoho_settings = array_merge($wpszi_smart_zoho_settings, $_REQUEST['wpszi_smart_zoho_settings']);
            
            update_option( 'wpszi_smart_zoho_settings', $wpszi_smart_zoho_settings );
            
            if ( $client_id && $client_secret ) {
                $redirect_uri = esc_url(WPSPLI_REDIRECT_URI);
                $redirect_url = "$wpszi_smart_zoho_data_center/oauth/v2/auth?client_id=$client_id&redirect_uri=$redirect_uri&response_type=code&scope=ZohoCRM.modules.all,ZohoCRM.settings.all&access_type=offline";
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