<?php
class WPSPLI_Smart_PipeLiner_API {
    
    var $url;
    var $client_id;
    var $client_secret;
    var $token;
    
    function __construct() {

        $wpspli_smart_pipeliner_settings     = get_option( 'wpspli_smart_pipeliner_settings' );

        $client_id                  = esc_attr($wpspli_smart_pipeliner_settings['client_id']);
        $client_secret              = esc_attr($wpspli_smart_pipeliner_settings['client_secret']);
        $wpspli_smart_pipeliner_data_center  = esc_attr($wpspli_smart_pipeliner_settings['data_center']);

        $wpspli_smart_pipeliner_data_center    = ( $wpspli_smart_pipeliner_data_center ? $wpspli_smart_pipeliner_data_center : 'https://accounts.pipeliner.com' );

        $this->url              = $wpspli_smart_pipeliner_data_center;
        $this->client_id        = $client_id;
        $this->client_secret    = $client_secret;
        $this->token            = get_option( 'wpspli_smart_pipeliner' );

        // Get any existing copy of our transient data
        if ( false === ( $wpspli_smart_pipeliner_expire = get_transient( 'wpspli_smart_pipeliner_expire' ) ) ) {
            
            $this->getRefreshToken($this->token);
        }

        $this->loadAPIFiles();
    }
    
    function loadAPIFiles(){
        require_once WPSPLI_PLUGIN_PATH . 'includes/class.getListofModules.php';
        require_once WPSPLI_PLUGIN_PATH . 'includes/class.getFieldsMetaData.php';
    }

    function getListModules(){
        return (new GetListofModules())->execute($this->token);
    }

    function getFieldsMetaData( $module_name = NULL ){
        return (new GetFieldsMetaData())->execute($this->token, $module_name);
    }

    function getToken( $code, $redirect_uri ) {
        
        $data = array(
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $redirect_uri,
        );
        $data = http_build_query( $data );
        
        $url = $this->url.'/oauth/v2/token';
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );        
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        $json_response = curl_exec( $ch ); 
        curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        
        $response = json_decode( $json_response );
        
        return $response;
    }
    
    function getRefreshToken( $token ) {
        $data = array(
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type'    => 'refresh_token',
            'refresh_token' => $token->refresh_token,
        );
        $data = http_build_query( $data );
        
        $url = $this->url.'/oauth/v2/token';
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );        
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        $json_response = curl_exec( $ch ); 
        curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        
        $response = json_decode( $json_response );
        
        if ( isset( $response->access_token ) ) {
            $token->access_token = $response->access_token;
            $wpspli_smart_pipeliner_expire = 'Expire_Management';
            set_transient( 'wpspli_smart_pipeliner_expire', $wpspli_smart_pipeliner_expire, 3500 );
            update_option( 'wpspli_smart_pipeliner', $token );
        }
        
        return $response;
    }
    
    function manageToken( $token ){
        $old_token = get_option( 'wpspli_smart_pipeliner' );
        if ( ! isset( $token->refresh_token ) && $old_token ) {
            $old_token->access_token = $token->access_token;
            $token = $old_token;
        }
        
        $wpspli_smart_pipeliner_expire = 'Expire_Management';
        set_transient( 'wpspli_smart_pipeliner_expire', $wpspli_smart_pipeliner_expire, 3500 );
        update_option( 'wpspli_smart_pipeliner', $token );
        return true;
    }

    function getModuleFields( $token, $module ) {
        
        $header = array(
            'Authorization: Pipeliner-oauthtoken '.$token->access_token,
            'Content-Type: application/json',
        );
        
        $url = $token->api_domain.'/crm/v2/settings/fields?module='.$module;
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $json_response = curl_exec( $ch );
        curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        
        $response = json_decode( $json_response );
        $fields = array();
        if ( isset( $response->fields ) && $response->fields != null ) {
            foreach ( $response->fields as $field ) {
                if ( isset( $field->view_type->create ) && $field->view_type->create ) {
                    $fields[$field->api_name] = array(
                        'label'     => $field->field_label,
                        'type'      => $field->data_type,
                    );
                }
            }
        }
        return $fields;
    }
    
    function addRecord( $module, $data ) {
        
        $data = array(
            'data'  => array(
                $data,
            ),
        );

        $data = json_encode( $data );
        $header = array(
            'Authorization: Pipeliner-oauthtoken '.$this->token->access_token,
        );
        
        $url = WPSPLI_PIPELINERAPIS_URL.'/crm/v2/'.$module;
        
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        $json_response = curl_exec( $ch );
        curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        
        $response = json_decode( $json_response );
        
        if ( isset( $response->data[0]->status ) && $response->data[0]->status == 'error' ) {
            $log = "errorCode: ".$response->data[0]->code."\n";
            $log .= "message: ".$response->data[0]->message."\n";
            $log .= "Date: ".date( 'Y-m-d H:i:s' )."\n\n";                            

            file_put_contents( WPSPLI_PLUGIN_PATH.'debug.log', $log, FILE_APPEND );
        }
        
        return $response;
    }
    
    function updateRecord( $module, $data, $record_id ) {
        
        $data = array(
            'data'  => array(
                $data,
            ),
        );
        
        $data = json_encode( $data );
        $header = array(
            'Authorization: Pipeliner-oauthtoken '.$this->token->access_token,
        );
        
        $url = WPSPLI_PIPELINERAPIS_URL.'/crm/v2/'.$module.'/'.$record_id;
        
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        $json_response = curl_exec( $ch );
        curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        curl_close( $ch );
        
        $response = json_decode( $json_response );
        if ( isset( $response->data[0]->status ) && $response->data[0]->status == 'error' ) {
            $log = "errorCode: ".$response->data[0]->code."\n";
            $log .= "message: ".$response->data[0]->message."\n";
            $log .= "Date: ".date( 'Y-m-d H:i:s' )."\n\n";                            

            file_put_contents( WPSPLI_PLUGIN_PATH.'debug.log', $log, FILE_APPEND );
        }
        
        return $response;
    }
}
?>