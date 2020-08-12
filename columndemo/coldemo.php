<?php
 /*
   Plugin Name: Column Demo
   Plugin URI: http://smartcoderbd.com/custom-plugin
   description: >-a plugin to create awesomeness and spread joy
   Version: 1.0
   Author: Mr. Sajib
   Author URI: http://mrtotallyawesome.com
   License:GPLv2 or later
   Text Domain: coloumn-demo
   Domain Path:/languages/
   */


 function coldemo_bootstrape(){

      load_plugin_textdomain( "coloumn-demo",false,dirname(__FILE__)."/languages" );
   }

add_action( 'plugins_loaded','coldemo_bootstrape' );


function coldemo_post_column($columns){
   print_r($columns);
   unset($columns['tags']);
   unset($columns['comments']);
   
   $columns['id']=__('Post ID','coloumn-demo');
   $columns['thumbnail']=__('Thumbnail','coloumn-demo');
   return $columns;
}
add_filter( 'manage_posts_columns','coldemo_post_column' );
add_filter( 'manage_pages_columns','coldemo_post_column' );
function coldemo_add_column($column,$post_id){
   if('id'==$column){
      echo $post_id;
   }elseif('thumbnail'==$column){
  $thumbnail=get_the_post_thumbnail($post_id,array(100,100));
  echo $thumbnail;
   }
   
}
 add_action( 'manage_posts_custom_column','coldemo_add_column',10,2 );
 add_action( 'manage_pages_custom_column','coldemo_add_column',10,2 );

?>