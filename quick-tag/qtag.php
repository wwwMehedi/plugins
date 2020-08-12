<?php
 /*
   Plugin Name: Qicktags Demo
   Plugin URI: http://smartcoderbd.com/custom-plugin
   description: >-a plugin to create awesomeness and spread joy
   Version: 1.0
   Author: Mr. Sajib
   Author URI: http://mrtotallyawesome.com
   License:GPLv2 or later
   Text Domain:quicktag-demo
   Domain Path:/languages/
   */
   
    function qtsd_assets($screen){
      if('post.php'==$screen){
         wp_enqueue_script( 'qtmain-js',plugin_dir_url( __FILE__ )."/assets/js/qtagmain.js",
            array('quicktags','thickbox'));
         wp_localize_script( 'qtmain-js','qtsd',
            array('preview'=>plugin_dir_url( __FILE__ )."/fap.php"));
      }
    }
   add_action( 'admin_enqueue_scripts','qtsd_assets' );

   ?>