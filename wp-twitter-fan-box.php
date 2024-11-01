<?php 
/* 
Plugin Name: Twitter Fan Box
Plugin URI: http://www.dolcebita.com/wordpress/twitter-fan-box/
Description: Like the Facebook Fan Box, this plugins provides a widget to show then number of followers (and the profile pictures of some of them) on Twitter.
Version: 0.1
Author: Marcos Esperon
Author URI: http://www.dolcebita.com/
*/

/*  Copyright 2010  Marcos Esperon

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; 
*/

$tfb_options['widget_fields']['user'] = array('label'=>'User:', 'type'=>'text', 'default'=>'', 'class'=>'widefat', 'size'=>'', 'help'=>'');
$tfb_options['widget_fields']['fans'] = array('label'=>'Followers:', 'type'=>'text', 'default'=>'10', 'class'=>'', 'size'=>'3', 'help'=>'(Num. of pictures)');
$tfb_options['widget_fields']['width'] = array('label'=>'Width:', 'type'=>'text', 'default'=>'300', 'class'=>'', 'size'=>'3', 'help'=>'(Value in px)');
$tfb_options['widget_fields']['height'] = array('label'=>'Height:', 'type'=>'text', 'default'=>'270', 'class'=>'', 'size'=>'3', 'help'=>'(Value in px)');
$tfb_options['widget_fields']['lang'] = array('label'=>'Lang:', 'type'=>'text', 'default'=>'es_ES', 'class'=>'', 'size'=>'3', 'help'=>'(es_ES, en_US)');
$tfb_options['widget_fields']['css'] = array('label'=>'CSS:', 'type'=>'text', 'default'=>'', 'class'=>'widefat', 'size'=>'', 'help'=>'');

function tfb_init($user = '', $fans = '', $width = '', $height = '', $lang = '', $css = '') {
  
  $output = '';
  
  if ($user != '') {
        
    $fans = ($fans != '') ? $fans : '10';
    $width = ($width != '') ? $width : '500';
    $height = ($height != '') ? $height : '500';
    $lang = ($lang != '') ? $lang : 'es_ES';
    
    $output = '<script type="text/javascript" src="http://www.dolcebita.com/apps/tfb/tfb.js"></script>
               <script type="text/javascript">tfb("'.$user.'",'.$fans.','.$width.','.$height.',"'.$lang.'","'.$css.'");</script>';
             
  };
  
  return $output;
  
}

function twitter_fan_box($user = '', $fans = '', $width = '', $height = '', $lang = '', $css = '') {
  echo tfb_init($user, $fans, $width, $height, $lang, $css);
}

function tfb_shortcode($attr) {  
  $user = $attr[user];
  if($user != '') {
    $fans = $attr[fans];
    $width = $attr[width];
    $height = $attr[height];    
    $lang = $attr[lang];
    $css = $attr[css];
    tfb_init($user, $fans, $width, $height, $lang, $css);
  }
}

add_shortcode('tfb', 'tfb_shortcode');

function widget_tfb_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
	
	$check_options = get_option('widget_tfb');
  
	function widget_tfb($args) {

		global $tfb_options;
    
    // $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
    
		extract($args);
		
		$options = get_option('widget_tfb');
		
		// fill options with default values if value is not set
		$item = $options;
		foreach($tfb_options['widget_fields'] as $key => $field) {
			if (! isset($item[$key])) {
				$item[$key] = $field['default'];
			}
		}    
		    
    $user = $item['user'];
    $fans = $item['fans'];    
    $width = $item['width'];
    $height = $item['height'];    
    $lang = $item['lang'];
    $css = $item['css'];
    
		// These lines generate our output.
    echo $before_widget;// . $before_title . $title . $after_title;    
    twitter_fan_box($user, $fans, $width, $height, $lang, $css);
    echo $after_widget;
				
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_tfb_control() {
	
		global $tfb_options;

		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_tfb');
		if ( isset($_POST['tfb-submit']) ) {

			foreach($tfb_options['widget_fields'] as $key => $field) {
				$options[$key] = $field['default'];
				$field_name = sprintf('%s', $key);        
				if ($field['type'] == 'text') {
					$options[$key] = strip_tags(stripslashes($_POST[$field_name]));
				} elseif ($field['type'] == 'checkbox') {
					$options[$key] = isset($_POST[$field_name]);
				}
			}

			update_option('widget_tfb', $options);
		}
    
		foreach($tfb_options['widget_fields'] as $key => $field) {
			$field_name = sprintf('%s', $key);
			$field_checked = '';
			if ($field['type'] == 'text') {
				$field_value = (isset($options[$key])) ? htmlspecialchars($options[$key], ENT_QUOTES) : htmlspecialchars($field['default'], ENT_QUOTES);
			} elseif ($field['type'] == 'checkbox') {
				$field_value = (isset($options[$key])) ? $options[$key] :$field['default'] ;
				if ($field_value == 1) {
					$field_checked = 'checked="checked"';
				}
			}
      $jump = ($field['type'] != 'checkbox') ? '<br />' : '&nbsp;';
      $field_class = $field['class'];
      $field_size = ($field['class'] != '') ? '' : 'size="'.$field['size'].'"';
      $field_help = ($field['help'] == '') ? '' : '<small>'.$field['help'].'</small>';
			printf('<p class="tfb_field"><label for="%s">%s</label>%s<input id="%s" name="%s" type="%s" value="%s" class="%s" %s %s /> %s</p>',
		  $field_name, __($field['label']), $jump, $field_name, $field_name, $field['type'], $field_value, $field_class, $field_size, $field_checked, $field_help);
		}

		echo '<input type="hidden" id="tfb-submit" name="tfb-submit" value="1" />';
	}	
	
	function widget_tfb_register() {		
    $title = 'Twitter Fan Box';
    // Register widget for use
    register_sidebar_widget($title, 'widget_tfb');    
    // Register settings for use, 300x100 pixel form
    register_widget_control($title, 'widget_tfb_control');
	}

	widget_tfb_register();
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'widget_tfb_init');

?>