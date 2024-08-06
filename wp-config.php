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
define( 'DB_NAME', 'cobits' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'Zww1JUN$ob0ktvvWgwonD8ah>%^-TNShEQNPDV4mwYDZ[Ou6:1.)O */_*g9@6@d' );
define( 'SECURE_AUTH_KEY',  'u>8%4M~*e2k`2po(PnO!yH!5{;lUX&cIx;qq*S|@p^53~@pxB4Cl:nNrjo|texO:' );
define( 'LOGGED_IN_KEY',    'ANKbpOgvyhG82^-Xv|;mh:q1MWmP>54w_,aNl60:+V!2:MEb#yu]G`p xt1kQ)k5' );
define( 'NONCE_KEY',        'r7<a;Szn@Bbx2icSHQsrJ>ZFhizxRT>1*m&,$!;w`XwXn!w.HIY?Is?erpH(t,rR' );
define( 'AUTH_SALT',        '!!W1&d=t2}*r(uU8c<^HhTLQwW 88(%sm.-Z#MEp]5p=%:ctRus3,#Ghl_6bG1b[' );
define( 'SECURE_AUTH_SALT', 'CN9!/tj(<H;B*(JNI5?LzSj&eJUh/b5LvQ@OluXHNwCzEu1|Ec%;N<$]t,);?2rH' );
define( 'LOGGED_IN_SALT',   'O@0R[L3-qo%&h:TOxTQU`JuN})86uqfD3aWNEwqJp:-?>E^sd4DlR8<foCyI Fu6' );
define( 'NONCE_SALT',       'X,=d:V}db-0Z;>WHh]r4CqtC cJ@|D#Ew%VUm)zO0BIa4Zs7H<>c,0y{p+/?Hn/9' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
