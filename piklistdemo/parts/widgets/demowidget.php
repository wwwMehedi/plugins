<?php
/*
Title: My Demo Widget
Description: A description of what my widget does
*/
?>

<?php echo $before_widget; ?>

<?php echo $before_title; ?>

<?php 
//echo "<h1>"."name is "."</h1>";
echo $settings['demo_text']; 
?>!

<?php echo $after_title; ?>

<?php echo $settings['demo_select']; ?>!

<?php echo $settings['demo_colorpicker']; ?>!

<?php echo $after_widget; ?>
