<?php
class WPSPLI_Smart_PipeLiner_Public {
  
    public function __construct() {
        
        $this->loadCustomerAction();
        $this->loadOrderAction();
        $this->loadProductAction();
    }


    private function loadCustomerAction() {
        add_action( 'user_register', array($this, 'addUserToZoho') );
        add_action( 'profile_update', array($this, 'addUserToZoho'), 10, 1 );
        add_action( 'woocommerce_update_customer', array($this, 'addUserToZoho'), 10, 1 );
    }


    private function loadOrderAction() {
        add_action( 'save_post', array( $this, 'addOrderToZoho' ), 10, 1 );
        add_action('woocommerce_thankyou', array( $this, 'addOrderToZoho' ), 10, 1);
    }


    private function loadProductAction() {
        add_action( 'woocommerce_update_product', array( $this, 'addProductToZoho' ), 10, 1 );
    }

    public function addUserToZoho( $user_id ){
        global $wpdb;
        $data       = array();
        $user_info  = get_userdata($user_id);

        $default_wp_module = "customers";

        $wpspli_smart_pipeliner_settings = get_option( 'wpspli_smart_pipeliner_settings' );
        $synch_settings         = !empty( $wpspli_smart_pipeliner_settings['synch'] ) ? $wpspli_smart_pipeliner_settings['synch'] : array();

        foreach ($synch_settings as $wp_pipeliner_module => $enable) {
            
            $wp_pipeliner_module = explode('_', $wp_pipeliner_module);
            $wp_module      = $wp_pipeliner_module[0];
            $pipeliner_module    = $wp_pipeliner_module[1];

            if($default_wp_module == $wp_module){
                
                $get_pipeliner_field_mapping = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}smart_pipeliner_field_mapping WHERE wp_module ='".$wp_module."' AND pipeliner_module = '".$pipeliner_module."' AND status='active'");

                foreach ($get_pipeliner_field_mapping as $key => $value) {
                    $wp_field   = $value->wp_field;
                    $pipeliner_field = $value->pipeliner_field;

                    if ( $pipeliner_field ) {
                        if ( isset( $user_info->{$wp_field} ) ) {
                            if ( is_array( $user_info->{$wp_field} ) ) {
                                $user_info->{$wp_field} = implode(';', $user_info->{$wp_field} );
                            }
                            $data[$pipeliner_module][$pipeliner_field] = strip_tags( $user_info->{$wp_field} );
                        }
                    }
                }
            }   
        }

        if( $data != null ){
            $this->prepareAndActionOnData( $user_id, $data, $default_wp_module );
        }
    }


    public function addOrderToZoho( $order_id ){
        global $wpdb, $post_type; 
        $data       = array();

        if ( get_post_type( $order_id ) !== 'shop_order' ){
            return;
        }

        $order = wc_get_order( $order_id );
        
        $default_wp_module = "orders";

        $wpspli_smart_pipeliner_settings = get_option( 'wpspli_smart_pipeliner_settings' );
        $synch_settings         = !empty( $wpspli_smart_pipeliner_settings['synch'] ) ? $wpspli_smart_pipeliner_settings['synch'] : array();

        foreach ($synch_settings as $wp_pipeliner_module => $enable) {
            
            $wp_pipeliner_module = explode('_', $wp_pipeliner_module);
            $wp_module      = $wp_pipeliner_module[0];
            $pipeliner_module    = $wp_pipeliner_module[1];

            if($default_wp_module == $wp_module){
                
                $get_pipeliner_field_mapping = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}smart_pipeliner_field_mapping WHERE wp_module ='".$wp_module."' AND pipeliner_module = '".$pipeliner_module."' AND status='active'");

                foreach ($get_pipeliner_field_mapping as $key => $value) {
                    $wp_field   = $value->wp_field;
                    $pipeliner_field = $value->pipeliner_field;

                    if ( $pipeliner_field ) {

                        if ( null !== $order->{$wp_field}() ) {
                            $data[$pipeliner_module][$pipeliner_field] = strip_tags( $order->{$wp_field}() );
                        }
                    }
                }
            }   
        }
        
        if( $data != null ){
            $this->prepareAndActionOnData( $order_id, $data, $default_wp_module );
        }
    }


    public function addProductToZoho( $post_id ){
        global $wpdb, $post_type, $data; 
        $data = array();

        if ( get_post_type( $post_id ) !== 'product' ){
            return;
        }
        
        $product = wc_get_product( $post_id );

        $default_wp_module = "products";

        $wpspli_smart_pipeliner_settings = get_option( 'wpspli_smart_pipeliner_settings' );
        $synch_settings         = !empty( $wpspli_smart_pipeliner_settings['synch'] ) ? $wpspli_smart_pipeliner_settings['synch'] : array();

        foreach ($synch_settings as $wp_pipeliner_module => $enable) {
            
            $wp_pipeliner_module = explode('_', $wp_pipeliner_module);
            $wp_module      = $wp_pipeliner_module[0];
            $pipeliner_module    = $wp_pipeliner_module[1];

            if($default_wp_module == $wp_module){
                
                $get_pipeliner_field_mapping = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}smart_pipeliner_field_mapping WHERE wp_module ='".$wp_module."' AND pipeliner_module = '".$pipeliner_module."' AND status='active'");

                foreach ($get_pipeliner_field_mapping as $key => $value) {
                    $wp_field   = $value->wp_field;
                    $pipeliner_field = $value->pipeliner_field;

                    if ( $pipeliner_field ) {

                        if ( null !== $product->{$wp_field}() ) {
                            if(is_array($product->{$wp_field}())){
                                $data[$pipeliner_module][$pipeliner_field] = implode(',', $product->{$wp_field}());
                            }else{
                                $data[$pipeliner_module][$pipeliner_field] = strip_tags( $product->{$wp_field}() );    
                            }
                        }
                    }
                }
            }   
        }

        if($data != null ){
            $this->prepareAndActionOnData( $post_id, $data, $default_wp_module );
        }
    }


    public function prepareAndActionOnData($id, $data = array(), $default_wp_module = NULL){
        
        if( $default_wp_module == 'orders' ||  $default_wp_module == 'products' ){
            $smart_pipeliner_relation = get_post_meta( $id, 'smart_pipeliner_relation', true );
        }else{
            $smart_pipeliner_relation = get_user_meta( $id, 'smart_pipeliner_relation', true );    
        }
        

        if ( ! is_array( $smart_pipeliner_relation ) ) {
            $smart_pipeliner_relation = array();
        }

        $pipeliner_api_obj   = new WPSPLI_Smart_Zoho_API();
        
        foreach ($data as $pipeliner_module => $pipeliner_data) {
            
            $record_id = ( isset( $smart_pipeliner_relation[$pipeliner_module] ) ? $smart_pipeliner_relation[$pipeliner_module] : 0 );

            if ( $record_id ) {
                $response = $pipeliner_api_obj->updateRecord($pipeliner_module, $pipeliner_data, $record_id);
            }else{
                $response = $pipeliner_api_obj->addRecord($pipeliner_module, $pipeliner_data);
            }
                        
            if ( isset( $response->data[0]->details->id ) ) {
                $record_id = $response->data[0]->details->id;
                $smart_pipeliner_relation[$pipeliner_module] = $record_id;
            }
        }

        if( $default_wp_module == 'orders' ||  $default_wp_module == 'products' ){
            update_post_meta( $id, 'smart_pipeliner_relation', $smart_pipeliner_relation );
        }else{
            update_user_meta( $id, 'smart_pipeliner_relation', $smart_pipeliner_relation );    
        }
        
    }
}

new WPSPLI_Smart_PipeLiner_Public();
?>