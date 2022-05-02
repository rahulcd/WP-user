<?php
/*
Plugin Name: Wp-user 
Plugin URI: https://github.com/rahulcd/WP-user
Description: User listing and details plugin by rahul
Version: 1.0
Author: Rahul
Author URI: https://github.com/rahulcd/WP-user
*/
class WpUser {

    protected $pluginPath;
    protected $pluginUrl;

    // url to user api
    protected $apiUrl = 'https://jsonplaceholder.typicode.com/';
     
    // user data
    protected $user;

    // Constructor
    public function __construct() {

        // Set Plugin Path
        $this->pluginPath = dirname(__FILE__);
     
        // Set Plugin URL
        $this->pluginUrl = WP_PLUGIN_URL . '/wp-user';
        
        add_action('init', array($this, 'registerShortcodes'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        
        add_action('wp_ajax_userdetails', array($this, 'userdetails'));
        add_action('wp_ajax_nopriv_userdetails', array($this, 'userdetails'));
    }
    
    // load all Styles and Scripts
    public function enqueue_scripts() {
        wp_enqueue_style( 'style-css', plugins_url( '/assets/css/style.css', __FILE__ ));
    
        wp_enqueue_script( 'script-js', plugins_url( '/assets/js/script.js', __FILE__ ),array('jquery'));
       
        // Pass ajax_url to script.js
        wp_localize_script( 'script-js', 'plugin_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    public function getUsers($id='')
    {
        $user = $this->user;
         
        if(isset($id) && !empty($id)){
            $json = wp_remote_get($this->apiUrl . 'users/'.$id);
        }else{
            $json = wp_remote_get($this->apiUrl . 'users');
        }
        
        
        $userArray = json_decode($json['body']);
        
        //$shots = $array->shots;
         
        return $userArray;
    }

    public function registerShortcodes() {
        // regestering shortcodes here
        add_shortcode('WpUserList', array($this, 'wp_user_listing'));
    }
    
    public function wp_user_listing($atts) {
        $usersList = $this->getUsers();        
        $Content = "<table class='table'>";
        $Content .= "<thead class='thead-light'>";
        $Content .= "<tr>";
        $Content .= "<th>User Name</th>";
        $Content .= "<th>User Id</th>";
        $Content .= "<th>Email</th>";
        $Content .= "</tr>";
        $Content .= "</thead>";
        foreach($usersList as $user){
            $Content .= "<tr>";
            $Content .= "<td><a class='get-user-details' userid='".$user->id."'>".$user->id."</a>   </td>";
            $Content .= "<td><a class='get-user-details' userid='".$user->id."'>".$user->username."</a></td>";
            $Content .= "<td><a class='get-user-details' userid='".$user->id."'>".$user->email."</a></td>";
            $Content .= "</tr>";
        }
        $Content .= "</table>";
        
        // add model content for loading the user details
        $Content .=  '<div id="myModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-modal-close">&times;</span>
            <div class="userdetails-content-area"></div>
        </div>
        </div>';
        return $Content;
    }
    
   public function userdetails() {
        ob_clean();
        
        $id = intval( $_POST['id'] );
        $usersDetails = $this->getUsers($id);

        $Content = "<div class='row'>";
        $Content .= "<div class='column'>";
        $Content .= "<h1>User Details</h1>";
        $Content .= "<h5><b>User id :</b> ".$usersDetails->id.'</h5>';
        $Content .= "<h5><b>User Name :</b> ".$usersDetails->username.'</h5>';
        $Content .= "<h5><b>Email :</b> ".$usersDetails->email.'</h5>';
        $Content .= "<h5><b>Phone :</b> ".$usersDetails->phone.'</h5>';
        $Content .= "<h5><b>Website :</b> ".$usersDetails->website.'</h5>';
        $Content .= "</div>";
        $Content .= "<div class='column'>";
        $Content .= "<h1>Address</h1>";
        $Content .= "<h5><b>Street :</b> ".$usersDetails->address->street.'</h5>';
        $Content .= "<h5><b>Suite :</b> ".$usersDetails->address->suite.'</h5>';
        $Content .= "<h5><b>City :</b> ".$usersDetails->address->city.'</h5>';
        $Content .= "<h5><b>Zipcode :</b> ".$usersDetails->address->zipcode.'</h5>';
        $Content .= "<h5><b>Latitude :</b> ".$usersDetails->address->geo->lat.'</h5>';
        $Content .= "<h5><b>Longitude :</b> ".$usersDetails->address->geo->lng.'</h5>';
        $Content .= "</div></div>";
        $Content .= "<div class='row'><div class='column'>";
        $Content .= "<h1>Company</h1>";
        $Content .= "<h5><b>Name :</b> ".$usersDetails->company->name.'</h5>';
        $Content .= "<h5><b>CatchPhrase :</b> ".$usersDetails->company->catchPhrase.'</h5>';
        $Content .= "<h5><b>Bs :</b> ".$usersDetails->company->bs.'</h5>';
        $Content .= "</div></div>";
        
        echo $Content;
        wp_die(); // this is required to terminate immediately and return a proper response 
    }
    
    }
    
    // Add a Global variable if you need to use outside of instantiated scope
    Global $WpUser;
    
    // Instantiate
    $WpUser = new WpUser();




?>