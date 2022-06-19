<?php
/**
 * This is the class for this plugin.
 */

namespace WpUser;

use UserInfo;

require_once dirname( __FILE__ ) .'\UserInfo.php';


class WpUser
{
    

    public function __construct()
    {
    }
    
    private function registerShortcodes()
    {
        add_shortcode('WpUserList', array($this, 'wp_user_listing'));
    }

     // load all Styles and Scripts
     public function enqueue_scripts() {
        $plugin_url = plugin_dir_url( __FILE__ );

        wp_enqueue_style( 'style-css', $plugin_url . 'assets/css/style.css');
    
        wp_enqueue_script( 'script-js', $plugin_url . 'assets/js/script.js');
       
        // Pass ajax_url to script.js
        wp_localize_script( 'script-js', 'plugin_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    public function wp_user_listing($atts){
        $userinfo = new UserInfo();
        $userinfo->user_listing($atts);
    }

    public function wp_user_details($atts){
        $userinfo = new UserInfo();
        $userinfo->userdetails($atts);
    }


    public function init()
    {
        // Register shortcodes
        $this->registerShortcodes();

        // Register Stylesheets and Js
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_nopriv_userdetails', array($this, 'wp_user_details'));
    }
}

?>