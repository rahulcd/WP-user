<?php 
/*
Plugin Name: Wp-user 
Plugin URI: https://github.com/rahulcd/WP-user
Description: User listing and details plugin by rahul
Version: 1.0
Author: Rahul
Author URI: https://github.com/rahulcd/WP-user
*/

namespace WpUser;

if (!class_exists(WpUser::class) && is_readable(__DIR__.'/vendor/autoload.php')) {
    require_once __DIR__.'/vendor/autoload.php';
}

// instantiate classes
$WpUser    = new WpUser();

// initialise the plugin
$WpUser->init();

?>