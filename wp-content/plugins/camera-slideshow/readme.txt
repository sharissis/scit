=== Camera slideshow ===
Contributors: manuelmasia
Donate link: http://www.pixedelic.com/plugins/camera
Tags: slideshow, jQuery, adaptive, responsive, lazy loading, mobile, drag and drop, admin panel, shortcode
Requires at least: 3.0.0
Tested up to: 4.0.0
Stable tag: trunk

A jQuery slideshow with a responsive layout, easy to use with an extended admin panel

== Description ==

If you're looking for an advanced Wordpress slideshow: [**Shortcodelic plugin bundle**](http://codecanyon.net/item/shortcodelic-wordpress-plugin-bundle/6076939?ref=pixedelic "Shortcodelic plugin bundle") (it also includes many other features: tabs, accordions, Google maps, pricing table, a page composer…).

A jQuery slideshow with an adaptive/responsive layout, easy to use with an extended admin panel. It already provides ColorBox, TimThumb, many effects. You can include it into your theme by using the shortcode (through a useful TinyMCE custom button) or through a meta-box by adding some lines of code to your theme.

Here is the demo page: [Camera slideshow](http://www.pixedelic.com/plugins/camera/wp.php "Camera slideshow")

== Installation ==

1. Upload `camera` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You can include Camera slideshow into your projects by using the TinyMCE custom button, by using the shortcode [camera slideshow='my-first-slideshow'] or by enabling the meta-box. In this case add these lines to your function.php file:
if (function_exists('camera_main_ss_add')) {
    add_action('admin_init','camera_main_ss_add');
}
A meta box will be available on your page/posts backend to select the slideshow you prefer. Just put this code into your loop to display the slideshow:
if (function_exists('camera_meta_slideshow')) {
    $meta_camera = get_post_custom( $post->ID );
    if(isset($meta_camera['camera_meta_slideshow'])){
        echo camera_meta_slideshow($meta_camera['camera_meta_slideshow'][0]);
    }
}

== Frequently Asked Questions ==

= No questions available =

...

== Screenshots ==

1. Camera admin panel
2. Camera admin panel (2)

== Changelog ==

= 1.4.0.1 =
* 2014.09.22 - Fixed mysql issues, always hoping to release Camera 2.0 soon

= 1.4.0.0 =
* 2014.09.22 - Fixed many issues, hoping to release Camera 2.0 soon

= 1.3.4.3 =
* 2012.07.18 - Fixed another issue with the database table

= 1.3.4.2 =
* 2012.07.18 - Fixed an issue with the database table

= 1.3.4.1 =
* 2012.07.11 - Fixed an issue with the shortcode button and the custom menu on WPMU when BBPress is installed (yes, a very strange bug), and fixed a bug with WPMU

= 1.3.4 =
* 2012.06.25 - Fixed (again) an issue with html direction attribute (if some rtl user wanted to help me to translate and create the correct stylesheet it would be great)

= 1.3.3.5 =
* 2012.06.25 - Fixed issues with html direction attribute (if some rtl user wanted to help me to translate and create the correct stylesheet it would be great)
= 1.3.3.4 =
* 2012.06.23 - Fixed some problems with WPMU and add the capabilities selection

= 1.3.3.3 =
* 2012.06.17 - Fixed a misprint

= 1.3.3.2 =
* 2012.06.01 - Fixed a problem with the next slide

= 1.3.3 =
* 2012.06.01 - Fixed a problem with the session

= 1.3.2 =
* 2012.06.01 - Fixed a problem with special characters

= 1.3.1 =
* 2012.05.28 - Fixed an issues with portrait mode

= 1.3.0 =
* 2012.05.23 - Added changes to the jQuery plugin not relevant for Wordpress

= 1.2.1 =
* 2012.05.10 - Changed the name of some global variables

= 1.1.1b =
* 2012.04.24 - Fixed some misprints, sorry

= 1.1.1 =
* 2012.04.23 - Fixed an issue with IE, and added some features to the admin panel

= 1.0.9 =
* 2012.04.13 - Fixed an issue with IE and Firefox, updated TimThumb

= 1.0.8 =
* 2012.04.05 - Fixed an issue with IE

= 1.0.4 =
* 2012.03.08 - Fixed a problem with the captions and multiple slideshows

= 1.0.3 =
* 2012.02.27 - Fixed minor bugs

= 1.0.2 =
* 2012.02.24 - Fixed a bug with the TinyMCS button

= 1.0.1 =
* 2012.02.23 - Tried to fix an ABSPATH problem

= 1.0.05 =
* 2012.02.22 - First adjustments, sorry

= 1.0.0 =
* 2012.02.22 - First release

== Upgrade Notice ==