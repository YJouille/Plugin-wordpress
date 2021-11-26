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
define( 'DB_NAME', 'meteo' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'g4x@[/8W;%f-PM0XZ)LG@(xKdhaZ*Dc.W%8snZ(+`cqk5 .gO%_dprV98(jEId0K' );
define( 'SECURE_AUTH_KEY',  '@y%]/7}8(F~HmIhM,^RGCUr[,tJoQC`)N9b}Q)q3uP&=/;pec?}u88d[wL:!Zahk' );
define( 'LOGGED_IN_KEY',    'IKSfq|g58RKHOy[3ZQJ,yketDe`B|o$R,q,o/gyi`jGD[CfZ#{HL=`T)U;pHwht.' );
define( 'NONCE_KEY',        'r~B1PUd2:S6QU!C=6k/5]VV7O{0zzPe<=Wc~?eHIHx<SSPQghO(}bu5ekdNV&9rP' );
define( 'AUTH_SALT',        ';9QZ320t+AnDL&6&;9qBBj*j[fVoeJ[]NO;zr8M0QxMm&v.iV4.20OKta5:<*Po,' );
define( 'SECURE_AUTH_SALT', ']1yd$cPt[9-eE]e2;-BveI_v;tWpqt)(RjeT8QuqPQUzDt[~3%9DjmXW4;(vCs_~' );
define( 'LOGGED_IN_SALT',   'zK69?X^{R5=r<)~]OS*~kXhnY?z<2X[YI&3rfy7l.p*r~HHOFk%v^Iq#||K6DVo$' );
define( 'NONCE_SALT',       '@;slxyI= Gaf;3Ndmpv-ExzSr[|($h* .l0YG4n2NFbr>Suv(}bX68,epgu<m022' );
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
