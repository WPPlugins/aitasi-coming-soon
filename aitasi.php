<?php
/**
 * Plugin Name: Aitasi Coming Soon
 * Plugin URI: https://wordpress.org/plugins/aitasi-coming-soon/
 * Description: Aitasi Coming Soon is a modern, beautiful, Responsive and Full width professional landing page that’ll help you create a stunning coming soon page or Maintenance Mode pages instantly without any coding or design skills. You can work on your site while visitors see a “Coming Soon” or “Maintenance Mode” page. It is very easy & quick to install in your WordPress installed website.
 * Author: ShapedPlugin
 * Author URI: http://shapedplugin.com
 * Version: 1.0.2
 */

if ( ! defined('ABSPATH')) exit;  // if direct access 

define('aitasi_coming_soon_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('aitasi_coming_soon_plugin_dir', plugin_dir_path( __FILE__ ) );
define('aitasi_coming_soon_wp_url', 'https://wordpress.org/plugins/aitasi-coming-soon/' );
define('aitasi_coming_soon_wp_reviews', 'http://wordpress.org/support/view/plugin-reviews/aitasi-coming-soon' );
define('aitasi_coming_soon_pro_url','http://shapedplugin.com/' );
define('aitasi_coming_soon_demo_url', 'http://shapedplugin.com' );
define('aitasi_coming_soon_support_url', 'http://shapedplugin.com/support' );
define('aitasi_coming_soon_plugin_name', 'Aitasi Coming Soon' );
define('aitasi_coming_soon_tutorial_video_url', '' );



require_once dirname( __FILE__ ) . '/admin/settings.php';
require_once dirname( __FILE__ ) . '/admin/options.php';

require_once dirname( __FILE__ ) . '/includes/functions.php';
require_once dirname( __FILE__ ) . '/includes/color-customize.php';


new ps_aitasi_settings();

if (shaped_plugin_option( 'aitasi_enable', 'aitasi_general_settings') == 'on') {

    if(!class_exists('AITASI_COMING_SOON'))
    {
        class AITASI_COMING_SOON
        {
            function __construct()
            {
                $this->plugin_includes();
            }
            function plugin_includes()
            {
                add_action('template_redirect', array( &$this, 'aitasi_redirect_mm'));
            }
            function is_valid_page() {
                return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
            }
            function aitasi_redirect_mm()
            {
                if(is_user_logged_in()){
                    //do not display maintenance page
                }
                else
                {
                    if( !is_admin() && !$this->is_valid_page()){  //show maintenance page
                        $this->load_sm_page();
                    }
                }
            }
            function load_sm_page()
            {
                header('HTTP/1.0 503 Service Unavailable');
                include_once("coming-soon.php");
                exit();
            }
        }
        $GLOBALS['aitasi_coming_soon'] = new AITASI_COMING_SOON();
    }

}

/**
* Plugin Action Links
**/
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'aitasi_coming_soon_action_links' );

function aitasi_coming_soon_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=sp_aitasi_settings') ) .'">Settings</a>';
   return $links;
}