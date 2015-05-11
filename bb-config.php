<?php
/** 
 * The base configurations of bbPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys and bbPress Language. You can get the MySQL settings from your
 * web host.
 *
 * This file is used by the installer during installation.
 *
 * @package bbPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for bbPress */
define( 'BBDB_NAME', 'scit-01-dev' );

/** MySQL database username */
define( 'BBDB_USER', 'u1130493_network' );

/** MySQL database password */
define( 'BBDB_PASSWORD', 'fimk[5epile|ogcad' );

/** MySQL hostname */
define( 'BBDB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'BBDB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'BBDB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/bbpress/ WordPress.org secret-key service}
 *
 * @since 1.0
 */
define( 'BB_AUTH_KEY', 'RFXzGl(f6 }lkv;|ca/4 |YfZ,|*0z*KK70}.-J),n:YdU=5a.%onPql#=k={`r+' );
define( 'BB_SECURE_AUTH_KEY', 'wqT9cO8@)gY7)C3BAMC#ZbzzH?U[o37I~k{p)9et)s-!P>YbP:BA4B+m/`vB$Jxr' );
define( 'BB_LOGGED_IN_KEY', 'rQhKm9O ,BtDA+oMEi;phvD{/+|+H*Y/T7&5mY0{DUX)y_ G!TTk`j@llWBPQE&>' );
define( 'BB_NONCE_KEY', 'aZ[L~8imYc&r&oWY=}dW_Fcz-T?5bA_kF)f>45vz.#*b)]VV9CIib7.$Z((iw d/' );
/**#@-*/

/**
 * bbPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$bb_table_prefix = 'wp_bb_';

/**
 * bbPress Localized Language, defaults to English.
 *
 * Change this to localize bbPress. A corresponding MO file for the chosen
 * language must be installed to a directory called "my-languages" in the root
 * directory of bbPress. For example, install de.mo to "my-languages" and set
 * BB_LANG to 'de' to enable German language support.
 */
define( 'BB_LANG', 'en_US' );
$bb->custom_user_table = 'wp_users';
$bb->custom_user_meta_table = 'wp_usermeta';

$bb->uri = 'http://scit.com/wp-content/plugins/buddypress//bp-forums/bbpress/';
$bb->name = 'Forum Forums';
$bb->wordpress_mu_primary_blog_id = 2;

define('BB_AUTH_SALT', '4T!yC@6VeyX@{[ov|r{O@R8>-da@2<aC]Tx)EB &|hhXFWj/,CjKhmJjLth`$8|~');
define('BB_LOGGED_IN_SALT', 'D6x>I}Ozpf0*)rmu!3t/_x4MA]]GAz]pRG59CnofX*eZPMgS1lJNcGyb9+u~ZuY7');
define('BB_SECURE_AUTH_SALT', 'g_GXlj<g.!-ys0qb%C/)x(Dc)jLp^$-tNXeQA,[Lu%q!eQd*TB7 ;M[PQ4#+Bb-o');

define('WP_AUTH_COOKIE_VERSION', 2);

?>