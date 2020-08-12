<?php
/*
   Plugin Name: Demo Widget
   Plugin URI: http://smartcoderbd.com/custom-plugin
   description: >-a plugin to create awesomeness and spread joy
   Version: 1.0
   Author: Mr. Sajib
   Author URI: http://mrtotallyawesome.com
   License:GPLv2 or later
   Text Domain:demowidget
   Domain Path:/languages/
   */
   require_once plugin_dir_path( __FILE__ )."widgets/class.widgets.php";

   function demowidget_load_textdomain(){
      load_plugin_textdomain( 'demowidget',false,plugin_dir_path( __FILE__ )."languages/" );
   }
    add_action( 'plugins_loaded','demowidget_load_textdomain' );

     function demowidget_register(){
   register_widget('DemoWidget');
}
add_action('widgets_init','demowidget_register');



   ?>