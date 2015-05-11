=== Plugin Name ===
Contributors: Beee
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40rubber%2dlab%2ecom&lc=NL&item_name=TinyNav%20plugin&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest
Tags: navigation, menu, tinynav, mobile
Requires at least: 3.0
Tested up to: 4.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Release date: 12.10.14
This plugin changes your WordPress menu into a menu which is better readable on mobile devices.

== Description ==

This plugin adds TinyNav.js to your wp_head() so your menu(s) will be converted into a menu which is better readable on mobile screens.

== Installation ==

1. Upload the `tinynav` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure your menu id/class and margins (if necessary) by going to the `TinyNav` menu that appears in your settings menu

== Frequently Asked Questions ==

= Which class/ID gets changed ? =

Out of the box `#site-navigation ul` gets changed.

= Can I change which class/id gets changed ?

Yes, you can do this on the settings page.

= My menu shifts to the left/right, can I correct it ? =

Yes, you can add a margin (in pixels) on the settings page.

= I don't have a home button in my menu, can I get one ?

Yes, create a custom menu with a home button in WordPress menus

= Does it work on all templates ? =

No. It works on most templates, but some templates prevent the plugin from hiding the menu, which could end up in 2 menus and some themes prevent theplugin from showing the menu.
I can't change that (yet) unfortunately. For example, it doens't work properly on TwentyEleven and TwentyTwelve, but it does work on TwentyThirteen (and others).

For the plugin to work your template must have one of the following lines in the header (mostly right after 'charset'):
`<meta name="viewport" content="width=device-width" />`
or
`
<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
`

== Screenshots ==

1. iPhone menu
2. iPhone menu expanded with a child and grandchild page

== Changelog ==

= 1.4 =
* added an iphone 5 screensize/break points
* added an option to add a custom screen width
* updated tinynav.js to 1.2
* updated tinynav.min.js to 1.2

= 1.3 =
* ???

= 1.2 =
* added more screensizes/break points
* added option to load tinynav.min.js in wp_footer()

= 1.1 =
* updated the script which enqueues tinyman.min.js with a jquery dependency

= 1.0 =
* changed several variable names to prevent any clashing with other plugins
* changed which selector is used out of the box, change from #access ul to #site-navigation ul

= 0.9 =
* removed a function which loaded an outdated jquery, which caused some other plugins to stop working

= 0.8 =
* renamed all variables back to their original names because it caused a bug

= 0.7 =
* enqueued js files in a function
* added the option to add meta viewport to your header
* renamed all variables to a more unique name
* removed an absolete function which caused a bug with some templates
* styled css so it's better to read

= 0.6 =
* made some grammar corrections
* made the screenwidth activation customizable

= 0.5.1 =
* fixed a bug for when the site's core files are in a [subdirectory](http://http://codex.wordpress.org/Giving_WordPress_Its_Own_Directory/ "Install WP in a sub-directory")

= 0.5 =
* added an option to use a custom id/class
* checked if child/grandchild pages work (and they do ;) )
* fixed the broken donate image

= 0.4 =
* added an option to add a custom top-margin in pixels
* added an option to add a custom bottom-margin in pixels
* styled the admin side
* added a settings link on the plugin page

= 0.3 =
* added an option to add a custom right-margin in pixels

= 0.2 =
* updated the active menu class, so the menu sticks to its current page
* updated names of functions so they won't clash with any other plugin (hardly likely but just in case)
* added an option to add a custom left-margin in pixels

== Other notes ==

This plugin is based on Viljami Salminen's [tinynav.js](http://tinynav.viljamis.com/ "TinyNav.js").

A big thanks goes out to Emil Uzelac from [ThemeID](http://themeid.com/). Thanks to his Responsive theme I got the idea and with his help I got it working.