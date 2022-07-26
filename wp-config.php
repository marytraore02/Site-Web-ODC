<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'odcsite' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '=c:o@?R+-%A*})Tr{nPwY)z]jpRZ4y,KeRTHoN?(&yz{{:F/D!#W]4C Abd/gJHc' );
define( 'SECURE_AUTH_KEY',  '5>Yb@C`{5cd79|~B2AqEY/WNS`QngIL|(<),3|ugo(>8)H8?xl:V;XKEds7m}8BF' );
define( 'LOGGED_IN_KEY',    'nc1KU*_&yhcbu_Rfc5[4X&`^0#MI6EA]u9v8l~Q<hZno{ZhRG&<Pmh~;EDfy9t[(' );
define( 'NONCE_KEY',        '0SGBc%yT1neX+0h89nyVb%xXmz.1nd!^{RF*e/%<uli>u_62%/SI!c=O?Ql~r HX' );
define( 'AUTH_SALT',        'y&bwEAp:`9Fm5LI)t-7?CW3LK1c5a25oc{$jY}Bc@Tct)$l[.&U/}`W#z5=*Ara/' );
define( 'SECURE_AUTH_SALT', '7ESqjv[XMx%<gR>1!F$SQe&d;!o^Lqq.YP-z1J&&nM/$V7[aS0Fstg+KvHmMwBT;' );
define( 'LOGGED_IN_SALT',   'QC6!-e4z;yc+Ccq+^iVTA@82I:b&S:i-I7{2QOg{s{*HN,soLDpG%N5^)a-paHJo' );
define( 'NONCE_SALT',       'Ti;fDtL^}Dk&zd%?#5-Yl$cyuC[:[Ub],p89l0VI^Qkvhu9?*65wl?)sc.PLTT| ' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
