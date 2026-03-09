<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rarepenny.com.au' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'tklau' );

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
define( 'AUTH_KEY',         '/zq2GNWuZXcYMDAPwV!S><{h2LTCMt@?ZueDq5x|}.ESJ+}9NKs_2tqfC&e(H&RG' );
define( 'SECURE_AUTH_KEY',  '?:HzP8>c3z}y[YIv>Xs1GketpHZO`On$DX9_`jqb>xy<?UC_N]xMAYq$Vk8. Vu#' );
define( 'LOGGED_IN_KEY',    'PBA9b@FIo`h1+(5}{$j>=^{]RIxx9JUXZrb`{sxX)r4:QMf}00oY+I|GXHUf+3~G' );
define( 'NONCE_KEY',        'oHQx(x;}}!aVur-5DJ7Le5lh0<+Jb)s4o(u{g|]D$;?-Ws9w7&A|3J$T2E?Q&sMP' );
define( 'AUTH_SALT',        'hrbV#F;{zDyqQTEt,YSC55_%4hs~S;8`&?D#b(DGzGSRnergq+{xoEfEXAQ834nc' );
define( 'SECURE_AUTH_SALT', '.N*(e`e`f.etem<B9%4NS/JhplFU]LmF%z v^,}?)aWoTs4gEmw@<Jv[H 0Hlya4' );
define( 'LOGGED_IN_SALT',   '[X OU+npS^Sn0}n,T`I;MSjO]m*fN.2A5t%gy|r@?LOtm2#_mz#)fJ1Y4s|:A}h)' );
define( 'NONCE_SALT',       '!qDP4:&n-UPGM4YALtc]Jp2w1iTfsfr^sX=[h#sBst}{0w()$Bt{.|s##.B8|Xp7' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
