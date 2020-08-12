<?php
 /*
   Plugin Name: AssetNinja
   Plugin URI: http://smartcoderbd.com/custom-plugin
   description: >-a plugin to create awesomeness and spread joy
   Version: 1.0
   Author: Mr. Sajib
   Author URI: http://mrtotallyawesome.com
   License:GPLv2 or later
   Text Domain:assetninja
   Domain Path:/languages/
   */

define('AssetsMainJs', plugin_dir_url( __FILE__ )."/assets/public");
define('AssetninjaAnother', plugin_dir_url( __FILE__ )."/assets/admin");
define('AsnCss', plugin_dir_url( __FILE__ )."/assets/public");
define('AssetAdmin', plugin_dir_url( __FILE__ )."/assets/admin");

class AssetNinja{
	private $version;
	function __construct(){
		$this->version=time();
		add_action( 'plugins_loaded',array($this,'load_textdomain'));
		add_action('wp_enqueue_scripts',array($this,'load_front_assets'));
		add_action('admin_enqueue_scripts',array($this,'load_frontadmin_assets'));
	}
	//constructorfinished 

    function load_frontadmin_assets($screen){
    	$_screen=get_current_screen();
    	//if('edit.php'==$screen){}
    	//if('edit-tags.php'==$screen && 'category'==$_screen->taxonomy)
    	if('edit.php'==$screen && 'page'==$_screen->post_type){

    	wp_enqueue_script( 'AssetAdminjs',AssetAdmin."/jst2/admin.js",array('jquery'),$this->version,true);
    }
}
	function load_front_assets(){
     wp_enqueue_script( 'assetninja-main',AssetsMainJs."/js/main.js",array('jquery'),$this->version,true);
	
    wp_enqueue_script( 'assetninja-anoher',AssetninjaAnother."/js/another.js",array('jquery'),$this->version,true);


    wp_enqueue_style('assetninja-main-css',AsnCss."/css/main.css",null,$this->version);

    $data=array(
     'name'=>'sajib',
     'url'=>'www.sajib.com'
    );
    $translation_string=array(
    'gretings'=>'Hellow worldsss'
    );
    wp_localize_script( 'assetninja-anoher', 'sitedata',$data );
    wp_localize_script( 'assetninja-anoher', 'translation',$translation_string );
	}

	
	function load_textdomain(){
		load_plugin_textdomain( 'assetninja',false, plugin_dir_url( __FILE__ )."/languages");
	}
}
new AssetNinja();

?>