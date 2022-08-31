<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'multivendor' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?y_pg21%Ngx<g_NJ!i[9*7W|69:ZhT&obPI%gYe!M 2:X<=]Fjl^WURj UNH(sQ}' );
define( 'SECURE_AUTH_KEY',  '~Zw)C-Lk^f+#v9R;]95nj*5^nzI+@tG{;IZ40=xhlz+5J/qn 9Ry<ON&a*1d#cnh' );
define( 'LOGGED_IN_KEY',    '5$!W?=_}~zJTBfOb}A=W%Ufiq2cL4aSkt0d)3UWJA>a?U~w||MSK0DJmV,xa#pt2' );
define( 'NONCE_KEY',        '4w_,/Y%ARLE3S8L:v@]VB49`v-d<i>}fX@H+h$)Oo:L@Ibg ]nU^8h1M[hF6Z$=c' );
define( 'AUTH_SALT',        '%N]C!i{8$0Xd )bxWp.o!LjHL+K03DSTsb20|#[/kxn}pK7ABNiaX<U*kE-%|a;3' );
define( 'SECURE_AUTH_SALT', '_le=v4)GEfSFCf~Q~sV,0Jtf0ztu|wX9U9K0zD`F }2UIv79jG:>KuX]E;D w[[`' );
define( 'LOGGED_IN_SALT',   'f_0uS!Ta|VL4(gnJp4W/i<R!1I1m8S_oF=U 93zmCBYx1#z!2g!Z5SukMrmjdIkj' );
define( 'NONCE_SALT',       '9S `r)GbvH]J$Yh]dKF,*/L%+XO=DX8a8^:%}95(.KWvcVi{##<HRE0(cE;.+|?#' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
