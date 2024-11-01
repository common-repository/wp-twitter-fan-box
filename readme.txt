=== Twitter Fan box ===
Contributors: Marcos Esperon
Tags: twitter, fan box, followers, widget
Requires at least: 2.5
Tested up to: 2.9
Stable tag: 0.1

Like the Facebook Fan Box, this plugins provides a widget to show then number of followers (and the profile pictures of some of them) on Twitter. Put the Twitter Fan Box in your sidebar using the widget mode or call the function inside your template.

== Description ==

If you have a page in Facebook about your blog and want to show the Facebook Fan Box with the recent updates and fans, just activate this widget or insert this line of code anywhere in your theme:

`<?php twitter_fan_box('USER'); ?>`

If you want to change updates other parameters like max. number of followers, width, height, lang or css properties, just do this:

`<?php twitter_fan_box('USER', 'FOLLOWERS', 'WIDTH', 'HEIGHT', 'LANG', 'CSS'); ?>`

Where:

- USER: Twitter user screen name.

- FOLLOWERS: The number of followers profile pictures to display in the Fan Box. Specifying 0 hides the list. You cannot display more than 100 fans (Default value is 10 pictures).

- WIDTH: The width of the Fan Box in pixels (Default value is 300 pixels).

- HEIGHT: The height of the Fan Box in pixels (Default value is 250 pixels).

- LANG: Language (en_US/es_ES).

- CSS: The URL to your own style sheet (Take a look at http://www.dolcebita.com/apps/tfb/style.css to replace the styles).


== Installation ==

1. Upload the entire wp-twitter-fan-box folder to your wp-content/plugins/ directory.

2. Activate the plugin through the 'Plugins' menu in WordPress.

3. Use this information to call the function inside your template or activate the widget.

== Screenshots ==
1. Twitter Fan Box

== Changelog ==  

= 0.1 =  
* Initial release.