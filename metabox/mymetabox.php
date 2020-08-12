<?php
/*
Plugin Name: Our Metabox
Plugin URI:
Description: Metabox API Demo
Version: 1.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain: our-metabox
Domain Path: /languages/
*/
class MetaboxClass{

	public function __construct(){
		add_action( 'plugins_loaded',array($this,'omb_load_textdomain'));
		add_action( 'admin_menu',array($this,'omb_add_metabox'));
		add_action( 'save_post', array( $this, 'omb_save_location'));
		add_action( 'admin_enqueue_scripts',array($this,'omb_admin_assets'));
	}

function omb_admin_assets(){
	wp_enqueue_style( 'omb-admin-style',plugin_dir_url( __FILE__ )."assets/admin/css/stl.css",null,
		time());
	wp_enqueue_script( 'omb_admin_js', plugin_dir_url( __FILE__ )."assets/admin/js/main.js",
		array('jquery','jquery-ui-datepicker'),
		time(),true);

	wp_enqueue_style( 'jquery_ui_css', '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css'
		,null,time());
}

   private function is_secured( $nonce_field, $action, $post_id ) {
		$nonce = isset( $_POST[ $nonce_field ] ) ? $_POST[ $nonce_field ] : '';

		if ( $nonce == '' ) {
			return false;
		}
		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			return false;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}

		if ( wp_is_post_autosave( $post_id ) ) {
			return false;
		}

		if ( wp_is_post_revision( $post_id ) ) {
			return false;
		}

		return true;

	}



	function omb_save_location($post_id){

if ( ! $this->is_secured( 'omb_location_field', 'omb_location', $post_id ) ) {
			return $post_id;
		}

    $location=isset ($_POST['omb_location']) ?  $_POST['omb_location']:'';
    $country=isset ($_POST['omb_country']) ?  $_POST['omb_country']:'';
     $is_favourite=isset ($_POST['omb_is_favourite']) ?  $_POST['omb_is_favourite']:0;

    if($location=='' || $country==''){
    	return $post_id;
    }
    
    	update_post_meta( $post_id,'omb_location',$location);
    	update_post_meta( $post_id,'omb_country',$country);
    	update_post_meta( $post_id,'omb_is_favourite',$is_favourite);
    
 
	}
function omb_load_textdomain(){
		load_plugin_textdomain( 'our-metabox',false,dirname(__FILE__)."/languages" );
	}




	function omb_add_metabox(){
		add_meta_box(
			'omb_post_location',
			__( 'Location Info', 'our-metabox' ),
			array( $this, 'omb_display_post_location' ),
			'post'
			
		);
	}
	function omb_display_post_location($post){
   $location=get_post_meta( $post->ID,'omb_location',true );
   $country=get_post_meta( $post->ID,'omb_country',true );
   $is_favourite=get_post_meta( $post->ID,'omb_is_favourite',true );
   //echo "is fav".$is_favourite;
   $checked=$is_favourite==1?'checked':'';

   $label1=__('Location','our-metabox');
	$label2=__('Country','our-metabox');
	$label3=__('Is Favourite','our-metabox');
wp_nonce_field( 'omb_location', 'omb_location_field' );
		
		$metabox_html = <<<EOD

<p class="l1">
<div class="ab"> <h1> Hellow </h1> </div>
<label for="omb_location" class="n">{$label1}: </label>
<input type="text" name="omb_location" id="omb_location" value="{$location}"/>
<br>
<label for="omb_country"  class="l2">{$label2}: </label>
<input type="text" name="omb_country" id="omb_country" value="{$country}"/>
<br>
<label for="omb_is_favourite"  class="l3">{$label3}: </label>
<input type="checkbox" name="omb_is_favourite" id="omb_is_favourite" value="1" {$checked} />
</p>
<br>
<p>Date: <input type="text" id="datepicker"></p>
EOD;
		echo $metabox_html;
	}
	
}



new MetaboxClass();


?>