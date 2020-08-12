<?php
 /*
   Plugin Name: Word Count
   Plugin URI: http://smartcoderbd.com/custom-plugin
   description: >-a plugin to create awesomeness and spread joy
   Version: 1.0
   Author: Mr. Sajib
   Author URI: http://mrtotallyawesome.com
   License:GPLv2 or later
   Text Domain:word-count
   Domain Path:/languages/
   */
/*function wordcount_activation_hook(){}

register_activation_hook( __FILE__, "wordcount_activation_hook");

function wordcount_deactivation_hook(){}

register_deactivation_hook(_FILE__, "wordcount_deactivation_hook");*/
function wordcount_load_textdomain(){
	load_plugin_textdomain( 'word-count',false,dirname(__FILE__)."/languages");
}
add_action("plugins_loaded","wordcount_load_textdomain");

function wordcount_count_words($content){
$stripped_content=strip_tags($content);
$wordn=str_word_count($stripped_content);
$label=__('Total number of words','word-count');
$label=apply_filters( "wordcount_heading",$label);
$tag=apply_filters( 'wordcount_tag','h2');
$content.=sprintf('<%s>%s: %s</%s>',$tag,$label,$wordn,$tag);
return $content;
}
add_filter('the_content','wordcount_count_words');


function wordcount_count_read($content){
$stripped_content=strip_tags($content);
$wordn=str_word_count($stripped_content);
$wordn=700;
$reading_min=floor($wordn/200);
$reading_sec=floor($wordn%200/(200/60));
$is_visible=apply_filters( 'wordcount_display_readingtime', 1 );
if($is_visible){
$label=__('Total time:','word-count');
$label=apply_filters( "wordcount_heading",$label);
$tag=apply_filters( 'wordcount_tag','h2');
$content.=sprintf('<%s>%s: %s minutes %s seconds</%s>',$tag,$label,$reading_min,$reading_sec,
	$tag);
}
return $content;
}
add_filter('the_content','wordcount_count_read');







