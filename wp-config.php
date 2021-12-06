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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'podcast3' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         '2VJdNw<>XRoF0s7us}x-`T4+OVq>j5$o.Y*+<({q^(&uM;EWw@~+jeY0uES=YBTO' );
define( 'SECURE_AUTH_KEY',  '=[rD}C3Ze[Y)AjnYgFVQa)[y*R,H=SkGpWDt]@I:$UNX.ZeR[wOA[})7R}-|Tz)k' );
define( 'LOGGED_IN_KEY',    '*3N9>oN5O?Wg>*|:Bto;I,X#4694)8yu{fQUZJ#4K>n}oLZJlaQKBbpM$4htyEMq' );
define( 'NONCE_KEY',        '%.9ZnG{n_|Q0YtlmVzG:AHEL Tr>6zs0{+ @-Xl>Tj[t;hYz9uiiWdqi^)_,My.A' );
define( 'AUTH_SALT',        '9dC8@)V|(glkY5y)R5,p>Ausat$)%Yf0CK8FWfa! 9;|hyg_Eg+(RPM%Ru;=b>X8' );
define( 'SECURE_AUTH_SALT', 'hg%gSy#<kg6^%BJ[k=L?C]ua:X1!@V>YH4#}XxAel9;~X,Pv0a<=AP63JnjMA]f|' );
define( 'LOGGED_IN_SALT',   'p)|jt];]y{(OtpcJ[dc/R9xwSO|!+RqDP8**H5fRyaVT7qCn=!B;KVF<KU:qOFl1' );
define( 'NONCE_SALT',       'z9<XmOH}a_2+V$P{SK#;Ndq=kf(L%4o=60y0/dBe+peAY`8lL`1Dj)jEY[,MbXeU' );

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
