<?php
/**
 * Plugin Name:       WPSPLI Smart PipeLiner Integration
 * Plugin URI:        https://profiles.wordpress.org/iqbal1486/
 * Description:       WP Smart Pipeliner help you to manage and synch possible WordPress data like customers, orders, products to the Pipeliner modules as per your settings options.
 * Version:           2.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Geekerhub
 * Author URI:        https://profiles.wordpress.org/iqbal1486/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wpspli-smart-pipeliner
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit( 'restricted access' );
}

define( 'WPSPLI_VERSION', '1.0.0' );

if (! defined('WPSPLI_ADMIN_URL') ) {
    define('WPSPLI_ADMIN_URL', get_admin_url());
}

if (! defined('WPSPLI_PLUGIN_FILE') ) {
    define('WPSPLI_PLUGIN_FILE', __FILE__);
}

if (! defined('WPSPLI_PLUGIN_PATH') ) {
    define('WPSPLI_PLUGIN_PATH', plugin_dir_path(WPSPLI_PLUGIN_FILE));
}

if (! defined('WPSPLI_PLUGIN_URL') ) {
    define('WPSPLI_PLUGIN_URL', plugin_dir_url(WPSPLI_PLUGIN_FILE));
}

if (! defined('WPSPLI_REDIRECT_URI') ) {
    define('WPSPLI_REDIRECT_URI', admin_url( 'admin.php?page=wpspli_smart_pipeliner_process' ));
}

if (! defined('WPSPLI_SETTINGS_URI') ) {
    define('WPSPLI_SETTINGS_URI', admin_url( 'admin.php?page=wpspli-smart-pipeliner-integration' ));
}

if (! defined('WPSPLI_PIPELINERAPIS_URL') ) {
    $tld = "com";
    // $wpspi_smart_pipedrive_settings  = get_option( 'wpspi_smart_pipedrive_settings' );
    // if( !empty($wpspi_smart_pipedrive_settings['data_center'])){
    //     $tld = end(explode(".", parse_url( $wpspi_smart_pipedrive_settings['data_center'], PHP_URL_HOST)));
    // }
    define('WPSPLI_PIPELINERAPIS_URL', 'https://www.pipelinerapis.'.$tld);
}

function wpspli_smart_pipeliner_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class.activator.php';
	$WPSPLI_Smart_PipeLiner_Activator = new WPSPLI_Smart_PipeLiner_Activator();
    $WPSPLI_Smart_PipeLiner_Activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpspli-smart-pipeliner-deactivator.php
 */
function wpspli_smart_pipeliner_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class.deactivator.php';
    WPSPLI_Smart_PipeLiner_Deactivator::deactivate();
}


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpspli-smart-pipeliner.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function wpspli_smart_pipeliner_run() {
    $plugin = new WPSPLI_Smart_PipeLiner();
	$plugin->run();
}

register_activation_hook( __FILE__, 'wpspli_smart_pipeliner_activate' );
register_deactivation_hook( __FILE__, 'wpspli_smart_pipeliner_deactivate' );

wpspli_smart_pipeliner_run();

function wpspli_smart_pipeliner_textdomain_init() {
    load_plugin_textdomain( 'wpspli-smart-pipeliner', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'wpspli_smart_pipeliner_textdomain_init');
?>