<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'ormxgpmm_goelectric' );

/** MySQL database username */
define( 'DB_USER', 'ormxgpmm_goelectric' );

/** MySQL database password */
define( 'DB_PASSWORD', '/*goelectric*/' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Ehk:`EWPIp^8csCVQo#Q~c9%J4`6(?;0MG$rj[@ny9(}F6?GfZDB4o[hND/gAlXF' );
define( 'SECURE_AUTH_KEY',  'L!!fi!a/Cog,?[qfX6K7wzqGzM-HV3OMsn:6rB[Q~aI*ri8OG]f/;%$8/B#3|4QX' );
define( 'LOGGED_IN_KEY',    ']W=`{}0rZ0}AHguuHM}iNNvbS`L~NW4p_A$d305kMu=O@_# srlDF@F1HJ$gY~%{' );
define( 'NONCE_KEY',        'Xp-R,;56g1@,9u=]3bKQD9jZb/Ni6J]*5bF@@8I^Vj]!)EDa<(+6_@%p{3?/G|V ' );
define( 'AUTH_SALT',        'c[bTVLuAM*DB6|@T/Xy~h8`h0Gr_(.pi_i}H1z,_p5rI--<%nR<~A Sbt2|Z$T|c' );
define( 'SECURE_AUTH_SALT', '.FD:*+Chkwb9DT)!NOaky r=9 1r-E}uGm3Y#sK[Ty9A1DLJJ!?l:S(M)w wOID%' );
define( 'LOGGED_IN_SALT',   ')F,RNtW0uJfJp@*l#|GTagoIxn5_Llk*-_w RLAI6v)rC!P3h6}wyMx:23>M1!ze' );
define( 'NONCE_SALT',       'fMFq?k47VE+{tDe4|W3KgCmtE+`]?|G_2Q35P2tQ+M->=^IWjxc/_(Z0_u+Fb(r1' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'rsweb_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
