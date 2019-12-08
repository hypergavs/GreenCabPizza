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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'greencab_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '<{O2T*Fg%a|kq=7$jm;qDZ6V@J >Mn$Zk-7MCwC8Iy`>0N}HM&A~{x98BI.Sd;J|');
define('SECURE_AUTH_KEY',  'Ip]?+S.|B2y.=0)4.`CJWtWkX1+WG4%_X+0-yx2ipjrNdhPX4gh:TP{O6)&Y$x9[');
define('LOGGED_IN_KEY',    'HEyory *FrCwvvlvRpFW{@QZ`>!?VfA8TYz!:, s@X9ur`3$>-/eei!>nq*A;^d#');
define('NONCE_KEY',        'tvOA3XeRYM}>2)b_n&2Bo4nRZZEP(c7l/lJZ-T9l[3,n-FlYKdIWy5`Ldcdl7t$+');
define('AUTH_SALT',        'nI.31V:_.YcN9V~1g8UpAx)hI&3^=9F8a=TV5ALO!RO0~xXyiH.5RcZxX)[&?%ry');
define('SECURE_AUTH_SALT', 'o2ZP&/=f:xW#yDgv*]|a@ryE)pG(YZF GE|MPHr!k>}Y}`)89U_+ZRy%(WzQ@k34');
define('LOGGED_IN_SALT',   'Gxj&ZR5vQ3}3r;1ej38){&^x?H$ob(2C}<.>Lr*h}i#eO,&Y ?P`I<78m.k!Y?1;');
define('NONCE_SALT',       'iybVP:DrCAP]V.nd#L>v0Andudz6nO2W?sC?oq?3WK7p}nWXraLhRKbN&]+:j~Ah');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'jd_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
