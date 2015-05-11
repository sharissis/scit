<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'steelcityimprov_v_2_0');

/** MySQL database username */
define('DB_USER', 'sci_admin_b9j3d6');

/** MySQL database password */
define('DB_PASSWORD', 'R33RAdujqqYd6eK4');

/** MySQL hostname */
define('DB_HOST', 'mysql.steelcityimprov.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** The Wordpress Network URL. */
define('DOMAIN_CURRENT_SITE', 'steelcityimprov.com');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'jo&+T@,P+HcA[Al-@A3PahS}A!yFp#pqAuR[pI>~^~6|/}~# M>FTP0L~Jwb9$,N');
define('SECURE_AUTH_KEY',  'JA^U(g:iDx5{XN;O--jM%My_>~PZ[[jp;/(WM .[<T_m-M&TMIWI:fFRd+T5M!*b');
define('LOGGED_IN_KEY',    '/HMF=$fuB{c7$C?w.k{ }V,.`sTYI`0x[?KQ5-N<l~ZS{mV|=6^hobVd=tKy_nN-');
define('NONCE_KEY',        'U4=MS~|ZW]EP#.!D={KCh4vZH(xM?&rY&yrzPsRu^7U|gWW8*/zQ%16OyOFQH?SM');
define('AUTH_SALT',        'v v6bpm~);+R?2|5AB2!$`G%?&K<,h|]+v|DRA/qNcHzN5F|sEf4z_&o:a4}qdiU');
define('SECURE_AUTH_SALT', 'mLS1Z+FL8MAz!y`<+@;anXGt#c|.r|AnCQ~)#qv%X eT4QUM_V]o%+2d.-z+SH8v');
define('LOGGED_IN_SALT',   'Hvwi,1:&.[|G,>~Dp7yCK.-n{>e-Lt?_@-,N3NV-t~*(s+wMm@.qf|B1Y`d,4-o`');
define('NONCE_SALT',       'Sz,%0Xr$47}bYvo<ivhXZiAYV2=2y[M{=+{CwpGM0M_5}C>@eZ|K;!S`q |h{c?C');

/**
* WordPress Database Table prefix.
*
* You can have multiple installations in one database if you give each a unique
* prefix. Only numbers, letters, and underscores please!
*/

/*	$table_prefix = 'wp_';	*/
$table_prefix = 'wp_8ec04f1s_';

/**
* WordPress Localized Language, defaults to English.
*
* Change this to localize WordPress. A corresponding MO file for the chosen
* language must be installed to wp-content/languages. For example, install
* de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
* language support.
*/

define( 'WPLANG', '' );

/**
* For developers: WordPress debugging mode.
*
* Change this to true to enable the display of notices during development.
* It is strongly recommended that plugin and theme developers use WP_DEBUG
* in their development environments.
*/


if ( WP_LOCAL_SERVER || WP_DEV_SERVER ) {

	define( 'WP_DEBUG', false );
	define( 'WP_DEBUG_LOG', false ); // Stored in wp-content/debug.log
	define( 'WP_DEBUG_DISPLAY', false );
	
	define( 'SCRIPT_DEBUG', false );
	define( 'SAVEQUERIES', false );

} else if ( WP_STAGING_SERVER ) {

	define( 'WP_DEBUG', true );
	define( 'WP_DEBUG_LOG', true ); // Stored in wp-content/debug.log
	define( 'WP_DEBUG_DISPLAY', false );

} else {
	define( 'WP_DEBUG', false );
}

/**
 * Multi-Site Information
 */

define('WP_ALLOW_MULTISITE', true);
define('SUNRISE', 'on');
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
$base = '/';
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
/*
#define ('WP_LOAD_IMPORTERS', true);
#define('WP_POST_REVISIONS', 3);

define('WP_POST_REVISIONS', false);
*/
define ( 'BP_ROOT_BLOG', 2 );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
