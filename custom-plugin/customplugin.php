<?php
   /*
   Plugin Name: custom plugin
   Plugin URI: http://smartcoderbd.com/custom-plugin
   description: >-a plugin to create awesomeness and spread joy
   Version: 1.0
   Author: Mr. Sajib
   Author URI: http://mrtotallyawesome.com
   
   */
   
/*
   add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )*/
   define("PLUGIN_DIR_PATH",plugin_dir_path(__FILE__));
   define("PLUGINS_URL",PLUGINS_URL());

function add_custom_menu(){
	add_menu_page(
	'customplugin',
	'Custom Plugin',
	'manage_options',
	'custom-plugin',   //slug
	'custom_plugin_func',
    'dashicons-share-alt',
    9);
    add_submenu_page(
    	'custom-plugin',
    	'Add new',
    	'Add new',
    	'manage_options',
    	'custom-plugin',
         'custom_plugin_func');
    add_submenu_page(
    	'custom-plugin',
    	'Add pages',
    	'All pages',
    	'manage_options',
    	'all page',
      'custom_plugin_func2');
}

add_action('admin_menu','add_custom_menu');

function custom_plugin_func(){
	include_once PLUGIN_DIR_PATH.'/views/addnewpage.php';
	
}

function custom_plugin_func2(){
	include_once PLUGIN_DIR_PATH.'/views/allpage.php';
}
function custom_plugin_assets(){
  wp_enqueue_style('style',PLUGINS_URL."/custom-plugin/assets/css/mystyle.css",'','1.0');
  wp_enqueue_script('script',PLUGINS_URL."/custom-plugin/assets/js/script.js",'','1.0',
    false);
 $translation_array = array(
    'some_string' => __( 'Some string to translate', 'plugin-domain' ),
    'a_value' => '10'
);

wp_localize_script('script','smart_coder',$translation_array);
}
//js 


add_action('admin_enqueue_scripts','custom_plugin_assets');
//if i write wp then it will work in fornt end
function myplugin_activate(){
global $wpdb;
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
$sql="CREATE TABLE `wp_custom_table` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(100) NOT NULL,
 `email` varchar(32) NOT NULL,
 `address` varchar(100) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";
dbDelta($sql);
}

function myplugin_deactivate(){
  global $wpdb;
  $wpdb->query("DROP  Table IF Exists wp_custom_table");
}

function myplugin_delete(){
  global $wpdb;
  $wpdb->query("DROP  Table IF Exists wp_custom_table");
}

register_activation_hook( __FILE__, 'myplugin_activate' );

register_deactivation_hook( __FILE__, 'myplugin_deactivate');

register_uninstall_hook( __FILE__, 'myplugin_delete');
//create post
function myplugin_create_post(){
  $page=array();
  $page['post_type']='page';
  $page['post_title']='custompluginpage_post';
  $page['post_content']='custompluginpage post';
  $page['post_status']='publish';
  $page['post_slug']='custom-plugin';
  wp_insert_post($page);
}
register_activation_hook( __FILE__, 'myplugin_create_post' );
