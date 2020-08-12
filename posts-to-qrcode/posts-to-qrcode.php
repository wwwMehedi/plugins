<?php
 /*
   Plugin Name: Posts To QR Code
   Plugin URI: http://smartcoderbd.com/custom-plugin
   description: display qr code every posts
   Version: 1.0
   Author: Mr. Sajib
   Author URI: https://hasin.me
   License:GPLv2 or later
   Text Domain:posts-to-qrcode
   Domain Path:/languages/
   */
/*function wordcount_activation_hook(){}

register_activation_hook( __FILE__, "wordcount_activation_hook");

function wordcount_deactivation_hook(){}

register_deactivation_hook(_FILE__, "wordcount_deactivation_hook");*/
function wordcount_load_textdomain(){
	load_plugin_textdomain( 'posts-to-qrcode',false,dirname(__FILE__)."/languages");
}


function pqrc_display_or_qrcode($content){
  $current_post_id=get_the_ID();
  $current_post_title=get_the_title( $current_post_id);
  $current_post_url=urldecode(get_the_permalink($current_post_id));
  $current_post_type=get_post_type( $current_post_id);
  /**
check post 
  **/
$excluded_post_types=apply_filters( 'pqrc_excluded_post_type',array());
if(in_array($current_post_type, $excluded_post_types)){
   return $content;
}
 //Dimension Hook
    $height    = get_option( 'pqrc_height' );
    $width     = get_option( 'pqrc_width' );
    $height    = $height ? $height : 25;
    $width     = $width ? $width : 25;
    echo "$height";
    $dimension = apply_filters( 'pqrc_qrcode_dimension', "{$width}x{$height}" );

  $image_source=sprintf('https://api.qrserver.com/v1/create-qr-code/?size=%s&data=%s', 
   $dimension,$current_post_url);                         

  $content.=sprintf("<img src='%s' alt='%s'/>",$image_source,$current_post_title);
return $content;
}



add_filter('the_content','pqrc_display_or_qrcode');
//add_action("plugins_loaded","pqrc_display_or_qrcode");

//create setttings field

function pqrc_settings_init(){

add_settings_section( 'pqrc_section',__('posts to qr code','posts-to-qrcode'),'pqrc_section_callback','general');
 add_settings_field( 'pqrc_height', __( 'QR Code Height', 'posts-to-qrcode' ), 'pqrc_display_field', 'general',
   'pqrc_section',array('pqrc_height'));
 add_settings_field( 'pqrc_width', __( 'QR Code Width', 'posts-to-qrcode' ), 'pqrc_display_field', 'general','pqrc_section',array('pqrc_width'));
 // add_settings_field( 'pqrc_extra', __( 'QR Code Extra', 'posts-to-qrcode' ), 'pqrc_display_field', 'general',
      //'pqrc_section',array('pqrc_extra'));

  add_settings_field( 'pqrc_select', __( 'QR Code Select', 'posts-to-qrcode' ), 'pqrc_display_select', 'general',
      'pqrc_section');

add_settings_field( 'pqrc_check', __( 'QR Code Checkbox', 'posts-to-qrcode' ), 'pqrc_display_checkgroup', 'general',
      'pqrc_section');

   register_setting( 'general', 'pqrc_height', array( 'sanitize_callback' => 'esc_attr' ) );
    register_setting( 'general', 'pqrc_width', array( 'sanitize_callback' => 'esc_attr' ) );
    //register_setting( 'general', 'pqrc_extra', array( 'sanitize_callback' => 'esc_attr' ) );
    register_setting( 'general', 'pqrc_select', array( 'sanitize_callback' => 'esc_attr' ) );
     register_setting( 'general', 'pqrc_check');
}
function pqrc_display_checkgroup(){
    $option=get_option( 'pqrc_check' );
    $countries=array(
    'ban',
    'nep',
    'ind',
    'sri',
    'vu'
    );
  
     foreach ($countries as $country) {

        $selected='';

        if(is_array($option) && in_array($country,$option)) {
         $selected='checked';
      }
        printf('<input type="checkbox" name="pqrc_check[]" value="%s" %s>%s <br>',$country,$selected,$country);
     }
    

}

function pqrc_display_select(){
   $option=get_option( 'pqrc_select' );
    $countries=array(
    'none',
    'ban',
    'nep',
    'ind',
    'sri',
    'vu'
    );
   printf('<select id="%s" name="%s">','pqrc_select','pqrc_select');
     foreach ($countries as $country) {
        $selected='';
        if($option==$country) $selected='selected';
        printf('<option value="%s" %s>%s</option>',$country,$selected,$country);
     }
     echo "</select>";
}


function pqrc_section_callback(){
   echo "<p>".__('Settings for Posts to QR Plugin','posts-to-qrcode'). "</p>";
}
function pqrc_display_field($args){
 $option=get_option($args[0]); 
 printf( "<input type='text' id='%s' name='%s' value='%s'/>", $args[0],$args[0],$option);
}

function pqrc_display_height() {
    $height = get_option( 'pqrc_height' );
    printf( "<input type='text' id='%s' name='%s' value='%s'/>", 'pqrc_height', 'pqrc_height', $height );
}

function pqrc_display_width() {
    $width = get_option( 'pqrc_width' );
    printf( "<input type='text' id='%s' name='%s' value='%s'/>", 'pqrc_width', 'pqrc_width', $width );
}




add_action( "admin_init",'pqrc_settings_init');

function btn_func($attributes,$content=''){
  return strtoupper($content);
}

add_shortcode( 'uc', 'btn_func' );





