<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'x>6Q0I57SA8Qa+FLW_K;70s; `@ B+wtOyu<Ah);.[1.fUY[OE`%zqs2`lEn[NpF');
define('SECURE_AUTH_KEY',  '`J]JqM*)K@T#GJJ!Ce:)*TbUdtYL7u*@zod{&x1=aHYk4zL4l3A-$<k&~D[mVu(b');
define('LOGGED_IN_KEY',    '|x&/~[g8)T~Z}ZEYuhzCWgxitL|@>Vgt[%MUwVna_0&ZtMxoi0nv z~il)AAHOtx');
define('NONCE_KEY',        'H$mr|U>yXL/gV9y.iYNo|IH!huBon{I+g[0ifaoHvW7uKqX33I>JP{O{oYs &M&C');
define('AUTH_SALT',        'm2BPAtKZhH/#%[+]V$PGApUii6=JJc!ne_Jw0}iqY6^AYJA@4:{J/@F@%7:{6!R{');
define('SECURE_AUTH_SALT', 'c<s{Xg8.K]_wq)&[CeepQo=>1d2ch7J;Hdc!lVmHzf~.zp%<6[#bslj{xq/!)<=n');
define('LOGGED_IN_SALT',   'A-5%~JjqX!UgZp[-X/>d2,u`Rp-xh12Z[Yw(gYAy,xX{XkTM8%[O|{7tijhlg`Ds');
define('NONCE_SALT',       'SzZ.Sn4cAS?wo]pT0N}.gReZziLn?y?oJU|i57@(U^jTv8Qpj]Qh$O rH&GjvjlR');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
