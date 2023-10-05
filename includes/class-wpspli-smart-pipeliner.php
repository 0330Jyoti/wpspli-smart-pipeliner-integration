<?php
class WPSPLI_Smart_PipeLiner {

	protected $plugin_name;

	protected $version;

	public function __construct() {
		$this->version = '1.0.0';
		$this->plugin_name = 'wpspli-smart-pipeliner';
	}

	public function run() {
		/*
			Load all class files
		*/
		require_once WPSPLI_PLUGIN_PATH . 'includes/class-wpspli-smart-pipeliner-api.php';
        require_once WPSPLI_PLUGIN_PATH . 'admin/class.wpspli-smart-pipeliner-admin.php';
		require_once WPSPLI_PLUGIN_PATH . 'public/class.wpspli-smart-pipeliner-public.php';
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}
	
	public function get_version() {
		return $this->version;
	}

	public function get_wp_modules(){
		return array(
                'customers' => esc_html__('Customers','wpspli-smart-pipeliner'),
                'orders'    => esc_html__('Orders','wpspli-smart-pipeliner'),
                'products'  => esc_html__('Products','wpspli-smart-pipeliner'),
            );
	}

	public function get_pipeliner_modules(){

		$pipeliner_api_obj   = new WPSPLI_Smart_Pipeliner_API();
       
        /*get list modules*/
        $getListModules = $pipeliner_api_obj->getListModules();
        
        return $getListModules;
	}

	public static function get_customer_fields(){
    	
    	global $wpdb;
		$wc_fields = array(
		    'first_name'            => esc_html__('First Name', 'wpspli-smart-pipeliner'),
		    'last_name'             => esc_html__('Last Name', 'wpspli-smart-pipeliner'),
		    'user_email'            => esc_html__('Email', 'wpspli-smart-pipeliner'),
		    'billing_first_name'    => esc_html__('Billing First Name', 'wpspli-smart-pipeliner'),
		    'billing_last_name'     => esc_html__('Billing Last Name', 'wpspli-smart-pipeliner'),
		    'billing_company'       => esc_html__('Billing Company', 'wpspli-smart-pipeliner'),
		    'billing_address_1'     => esc_html__('Billing Address 1', 'wpspli-smart-pipeliner'),
		    'billing_address_2'     => esc_html__('Billing Address 2', 'wpspli-smart-pipeliner'),
		    'billing_city'          => esc_html__('Billing City', 'wpspli-smart-pipeliner'),
		    'billing_state'         => esc_html__('Billing State', 'wpspli-smart-pipeliner'),
		    'billing_postcode'      => esc_html__('Billing Postcode', 'wpspli-smart-pipeliner'),
		    'billing_country'       => esc_html__('Billing Country', 'wpspli-smart-pipeliner'),
		    'billing_phone'         => esc_html__('Billing Phone', 'wpspli-smart-pipeliner'),
		    'billing_email'         => esc_html__('Billing Email', 'wpspli-smart-pipeliner'),
		    'shipping_first_name'   => esc_html__('Shipping First Name', 'wpspli-smart-pipeliner'),
		    'shipping_last_name'    => esc_html__('Shipping Last Name', 'wpspli-smart-pipeliner'),
		    'shipping_company'      => esc_html__('Shipping Company', 'wpspli-smart-pipeliner'),
		    'shipping_address_1'    => esc_html__('Shipping Address 1', 'wpspli-smart-pipeliner'),
		    'shipping_address_2'    => esc_html__('Shipping Address 2', 'wpspli-smart-pipeliner'),
		    'shipping_city'         => esc_html__('Shipping City', 'wpspli-smart-pipeliner'),
		    'shipping_postcode'     => esc_html__('Shipping Postcode', 'wpspli-smart-pipeliner'),
		    'shipping_country'      => esc_html__('Shipping Country', 'wpspli-smart-pipeliner'),
		    'shipping_state'        => esc_html__('Shipping State', 'wpspli-smart-pipeliner'),
		    'user_url'              => esc_html__('Website', 'wpspli-smart-pipeliner'),
		    'description'           => esc_html__('Biographical Info', 'wpspli-smart-pipeliner'),
		    'display_name'          => esc_html__('Display name publicly as', 'wpspli-smart-pipeliner'),
		    'nickname'              => esc_html__('Nickname', 'wpspli-smart-pipeliner'),
		    'user_login'            => esc_html__('Username', 'wpspli-smart-pipeliner'),
		    'user_registered'       => esc_html__('Registration Date', 'wpspli-smart-pipeliner')
		);

		return $wc_fields;
    }


    public static  function get_order_fields(){
    	
    	global $wpdb;


        $wc_fields =  array(
                'get_id'                       => esc_html__('Order Number', 'wpspli-smart-pipeliner'),
                'get_order_key'                => esc_html__('Order Key', 'wpspli-smart-pipeliner'),
                'get_billing_first_name'       => esc_html__('Billing First Name', 'wpspli-smart-pipeliner'),
                'get_billing_last_name'        => esc_html__('Billing Last Name', 'wpspli-smart-pipeliner'),
                'get_billing_company'          => esc_html__('Billing Company', 'wpspli-smart-pipeliner'),
                'get_billing_address_1'        => esc_html__('Billing Address 1', 'wpspli-smart-pipeliner'),
                'get_billing_address_2'        => esc_html__('Billing Address 2', 'wpspli-smart-pipeliner'),
                'get_billing_city'             => esc_html__('Billing City', 'wpspli-smart-pipeliner'),
                'get_billing_state'            => esc_html__('Billing State', 'wpspli-smart-pipeliner'),
                'get_billing_postcode'         => esc_html__('Billing Postcode', 'wpspli-smart-pipeliner'),
                'get_billing_country'          => esc_html__('Billing Country', 'wpspli-smart-pipeliner'), 
                'get_billing_phone'            => esc_html__('Billing Phone', 'wpspli-smart-pipeliner'),
                'get_billing_email'            => esc_html__('Billing Email', 'wpspli-smart-pipeliner'),
                'get_shipping_first_name'      => esc_html__('Shipping First Name', 'wpspli-smart-pipeliner'),
                'get_shipping_last_name'       => esc_html__('Shipping Last Name', 'wpspli-smart-pipeliner'),
                'get_shipping_company'         => esc_html__('Shipping Company', 'wpspli-smart-pipeliner'),
                'get_shipping_address_1'       => esc_html__('Shipping Address 1', 'wpspli-smart-pipeliner'),
                'get_shipping_address_2'       => esc_html__('Shipping Address 2', 'wpspli-smart-pipeliner'),
                'get_shipping_city'            => esc_html__('Shipping City', 'wpspli-smart-pipeliner'),
                'get_shipping_state'           => esc_html__('Shipping State', 'wpspli-smart-pipeliner'),
                'get_shipping_postcode'        => esc_html__('Shipping Postcode', 'wpspli-smart-pipeliner'),
                'get_shipping_country'         => esc_html__('Shipping Country',  'wpspli-smart-pipeliner'),
                'get_formatted_order_total'     => esc_html__('Formatted Order Total', 'wpspli-smart-pipeliner'),
                'get_cart_tax'                  => esc_html__('Cart Tax', 'wpspli-smart-pipeliner'),
                'get_currency'                  => esc_html__('Currency', 'wpspli-smart-pipeliner'),
                'get_discount_tax'              => esc_html__('Discount Tax', 'wpspli-smart-pipeliner'),
                'get_discount_to_display'       => esc_html__('Discount to Display', 'wpspli-smart-pipeliner'),
                'get_discount_total'            => esc_html__('Discount Total', 'wpspli-smart-pipeliner'),
                'get_shipping_tax'              => esc_html__('Shipping Tax', 'wpspli-smart-pipeliner'),
                'get_shipping_total'            => esc_html__('Shipping Total', 'wpspli-smart-pipeliner'),
                'get_subtotal'                  => esc_html__('SubTotal', 'wpspli-smart-pipeliner'),
                'get_subtotal_to_display'       => esc_html__('SubTotal to Display', 'wpspli-smart-pipeliner'),
                'get_total'                     => esc_html__('Get Total', 'wpspli-smart-pipeliner'),
                'get_total_discount'            => esc_html__('Get Total Discount', 'wpspli-smart-pipeliner'),
                'get_total_tax'                 => esc_html__('Total Tax', 'wpspli-smart-pipeliner'),
                'get_total_refunded'            => esc_html__('Total Refunded', 'wpspli-smart-pipeliner'),
                'get_total_tax_refunded'        => esc_html__('Total Tax Refunded', 'wpspli-smart-pipeliner'),
                'get_total_shipping_refunded'   => esc_html__('Total Shipping Refunded', 'wpspli-smart-pipeliner'),
                'get_item_count_refunded'       => esc_html__('Item count refunded', 'wpspli-smart-pipeliner'),
                'get_total_qty_refunded'        => esc_html__('Total Quantity Refunded', 'wpspli-smart-pipeliner'),
                'get_remaining_refund_amount'   => esc_html__('Remaining Refund Amount', 'wpspli-smart-pipeliner'),
                'get_item_count'                => esc_html__('Item count', 'wpspli-smart-pipeliner'),
                'get_shipping_method'           => esc_html__('Shipping Method', 'wpspli-smart-pipeliner'),
                'get_shipping_to_display'       => esc_html__('Shipping to Display', 'wpspli-smart-pipeliner'),
                'get_date_created'              => esc_html__('Date Created', 'wpspli-smart-pipeliner'),
                'get_date_modified'             => esc_html__('Date Modified', 'wpspli-smart-pipeliner'),
                'get_date_completed'            => esc_html__('Date Completed', 'wpspli-smart-pipeliner'),
                'get_date_paid'                 => esc_html__('Date Paid', 'wpspli-smart-pipeliner'),
                'get_customer_id'               => esc_html__('Customer ID', 'wpspli-smart-pipeliner'),
                'get_user_id'                   => esc_html__('User ID', 'wpspli-smart-pipeliner'),
                'get_customer_ip_address'       => esc_html__('Customer IP Address', 'wpspli-smart-pipeliner'),
                'get_customer_user_agent'       => esc_html__('Customer User Agent', 'wpspli-smart-pipeliner'),
                'get_created_via'               => esc_html__('Order Created Via', 'wpspli-smart-pipeliner'),
                'get_customer_note'             => esc_html__('Customer Note', 'wpspli-smart-pipeliner'),
                'get_shipping_address_map_url'  => esc_html__('Shipping Address Map URL', 'wpspli-smart-pipeliner'),
                'get_formatted_billing_full_name'   => esc_html__('Formatted Billing Full Name', 'wpspli-smart-pipeliner'),
                'get_formatted_shipping_full_name'  => esc_html__('Formatted Shipping Full Name', 'wpspli-smart-pipeliner'),
                'get_formatted_billing_address'     => esc_html__('Formatted Billing Address', 'wpspli-smart-pipeliner'),
                'get_formatted_shipping_address'    => esc_html__('Formatted Shipping Address', 'wpspli-smart-pipeliner'),
                'get_payment_method'            => esc_html__('Payment Method', 'wpspli-smart-pipeliner'),
                'get_payment_method_title'      => esc_html__('Payment Method Title', 'wpspli-smart-pipeliner'),
                'get_transaction_id'            => esc_html__('Transaction ID', 'wpspli-smart-pipeliner'),
                'get_checkout_payment_url'      => esc_html__( 'Checkout Payment URL', 'wpspli-smart-pipeliner'),
                'get_checkout_order_received_url'   => esc_html__('Checkout Order Received URL', 'wpspli-smart-pipeliner'),
                'get_cancel_order_url'          => esc_html__('Cancel Order URL', 'wpspli-smart-pipeliner'),
                'get_cancel_order_url_raw'      => esc_html__('Cancel Order URL Raw', 'wpspli-smart-pipeliner'),
                'get_cancel_endpoint'           => esc_html__('Cancel Endpoint', 'wpspli-smart-pipeliner'),
                'get_view_order_url'            => esc_html__('View Order URL', 'wpspli-smart-pipeliner'),
                'get_edit_order_url'            => esc_html__('Edit Order URL', 'wpspli-smart-pipeliner'),
                'get_status'                    => esc_html__('Status', 'wpspli-smart-pipeliner'),
            );
        
        return $wc_fields;
    }


    public static function get_product_fields(){
    	global $wpdb;
		$wc_fields = array(
		    'get_id'              		=> esc_html__('Product Id', 'wpspli-smart-pipeliner'),
            'get_type'       			=> esc_html__('Product Type', 'wpspli-smart-pipeliner'),
            'get_name'       			=> esc_html__('Name', 'wpspli-smart-pipeliner'),
            'get_slug'          		=> esc_html__('Slug', 'wpspli-smart-pipeliner'),
            'get_date_created'      	=> esc_html__('Date Created', 'wpspli-smart-pipeliner'),
            'get_date_modified'     	=> esc_html__('Date Modified', 'wpspli-smart-pipeliner'),
            'get_status'            	=> esc_html__('Status', 'wpspli-smart-pipeliner'),
            'get_featured'          	=> esc_html__('Featured', 'wpspli-smart-pipeliner'),
            'get_catalog_visibility'	=> esc_html__('Catalog Visibility', 'wpspli-smart-pipeliner'),
            'get_description'       	=> esc_html__('Description', 'wpspli-smart-pipeliner'),
            'get_short_description' 	=> esc_html__('Short Description', 'wpspli-smart-pipeliner'),
            'get_sku'            		=> esc_html__('Sku', 'wpspli-smart-pipeliner'),
            'get_menu_order'      		=> esc_html__('Menu Order', 'wpspli-smart-pipeliner'),
            'get_virtual'       		=> esc_html__('Virtual', 'wpspli-smart-pipeliner'),
            'get_permalink'         	=> esc_html__('Product Permalink', 'wpspli-smart-pipeliner'),
            'get_price'       			=> esc_html__('Price', 'wpspli-smart-pipeliner'),
            'get_regular_price'       	=> esc_html__('Regular Price', 'wpspli-smart-pipeliner'),
            'get_sale_price'            => esc_html__('Sale Price', 'wpspli-smart-pipeliner'),
            'get_date_on_sale_from'     => esc_html__('Date on Sale From', 'wpspli-smart-pipeliner'),
            'get_date_on_sale_to'       => esc_html__('Date on Sale To', 'wpspli-smart-pipeliner'),
            'get_total_sales'         	=> esc_html__('Total Sales', 'wpspli-smart-pipeliner'),
            'get_tax_status'     		=> esc_html__('Tax Status', 'wpspli-smart-pipeliner'),
            'get_tax_class'           	=> esc_html__('Tax Class', 'wpspli-smart-pipeliner'),
            'get_manage_stock'          => esc_html__('Manage Stock', 'wpspli-smart-pipeliner'),
            'get_stock_quantity'        => esc_html__('Stock Quantity', 'wpspli-smart-pipeliner'),
            'get_stock_status'          => esc_html__('Stock Status', 'wpspli-smart-pipeliner'),
            'get_backorders'       		=> esc_html__('Backorders', 'wpspli-smart-pipeliner'),
            'get_sold_individually'     => esc_html__('Sold Individually', 'wpspli-smart-pipeliner'),
            'get_purchase_note'         => esc_html__('Purchase Note', 'wpspli-smart-pipeliner'),
            'get_shipping_class_id'     => esc_html__('Shipping Class ID', 'wpspli-smart-pipeliner'),
            'get_weight'               	=> esc_html__('Weight', 'wpspli-smart-pipeliner'),
            'get_length'              	=> esc_html__('Length', 'wpspli-smart-pipeliner'),
            'get_width'            		=> esc_html__('Width', 'wpspli-smart-pipeliner'),
            'get_height'            	=> esc_html__('Height', 'wpspli-smart-pipeliner'),
            'get_categories'            => esc_html__('Categories', 'wpspli-smart-pipeliner'),
            'get_category_ids'          => esc_html__('Categories IDs', 'wpspli-smart-pipeliner'),
            'get_tag_ids'            	=> esc_html__('Tag IDs', 'wpspli-smart-pipeliner'),
		);
        
		return $wc_fields;
    }

    public function store_required_field_mapping_data(){

        global $wpdb;
        $pipeliner_api_obj   = new WPSPLI_Smart_Pipeliner_API();
        $wp_modules     = $this->get_wp_modules();
        $getListModules = $this->get_pipeliner_modules();

        if($getListModules['modules']){
            foreach ($getListModules['modules'] as $key => $singleModule) {
                if( $singleModule['deletable'] &&  $singleModule['creatable'] ){
        
                    $pipeliner_fields = $pipeliner_api_obj->getFieldsMetaData( $singleModule['api_name'] );
        
                    if($pipeliner_fields){
                        foreach ($pipeliner_fields['fields'] as $pipeliner_field_key => $pipeliner_field_data) {
                            if($pipeliner_field_data['field_read_only'] == NULL){
                                if( $pipeliner_field_data['system_mandatory'] == 1 ){
                                    if($wp_modules){
                                        foreach ($wp_modules as $wpModuleSlug => $wpModuleLabel) {
        
                                            switch ( $wpModuleSlug ) {
                                                case 'customers':
                                                    $wp_field = "first_name";
                                                    break;
                                                
                                                case 'orders':
                                                    $wp_field = "get_id";
                                                    break;

                                                case 'products':
                                                    $wp_field = "get_name";
                                                    break;

                                                default:
                                                    $wp_field = "";
                                                    break;
                                            }

                                            $status         = 'active';
                                            $description    = '';

                                            $record_exists = $wpdb->get_row( 
                                                $wpdb->prepare(
                                                    "
                                                    SELECT * FROM ".$wpdb->prefix ."smart_pipeliner_field_mapping  WHERE wp_module = %s AND wp_field = %s  AND pipeliner_module = %s AND pipeliner_field = %s
                                                    " ,
                                                    $wpModuleSlug, $wp_field, $singleModule['api_name'], $pipeliner_field_data['api_name']
                                                    )
                                                
                                            );

                                            if ( null !== $record_exists ) {
                                                
                                              $reccord_id       = $record_exists->id;
                                              $is_predefined    = $record_exists->is_predefined;
                                              

                                                $wpdb->update(
                                                    $wpdb->prefix . 'smart_pipeliner_field_mapping', 
                                                    array( 
                                                        'wp_module'     => sanitize_text_field($wpModuleSlug),
                                                        'wp_field'      => sanitize_text_field($wp_field),
                                                        'pipeliner_module'   => sanitize_text_field($singleModule['api_name']),
                                                        'pipeliner_field'    => sanitize_text_field($pipeliner_field_data['api_name']), 
                                                        'status'        => sanitize_text_field($status),
                                                        'description'   => sanitize_text_field($description), 
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
                                                        'wp_module'     => sanitize_text_field($wpModuleSlug),
                                                        'wp_field'      => sanitize_text_field($wp_field),
                                                        'pipeliner_module'   => sanitize_text_field($singleModule['api_name']),
                                                        'pipeliner_field'    => sanitize_text_field($pipeliner_field_data['api_name']), 
                                                        'status'        => sanitize_text_field($status),
                                                        'description'   => sanitize_text_field($description), 
                                                        'is_predefined' => 'yes', 
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
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
?>