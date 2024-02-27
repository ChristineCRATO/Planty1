<?php
define('WP_CACHE', true); // WP-Optimize Cache
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link https://fr.wordpress.org/support/article/editing-wp-config-php/ Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'Planty1' );
/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );
/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'root' );
/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );
/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );
/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');
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
define( 'AUTH_KEY',         'VSETP(kJ$N.MZ DhzoZNz$=1#5O!A [?E@&AD017DqAg:T0BEKuXYYW.Yu9k;]=G' );
define( 'SECURE_AUTH_KEY',  ';xFrn-e4&EqZr*`<K0RabM; AivK]I)NFJCDC@ZIY%V|B4[w-F;<E[AUW:bQ*dH!' );
define( 'LOGGED_IN_KEY',    '@j.{BDZ=e9%G(CX#>=@W8UdQ?ne/F2FPfcvJ)`>pT|O 5f1uo+Sy!*}u#<5.y`0.' );
define( 'NONCE_KEY',        'j1RX<oHI(}Ram7L<bw4F%RK!kuwV&,7@>zY5MZg>NgY2OSI[vVx!hZr+Ovi#BWGE' );
define( 'AUTH_SALT',        '_L[!/^>#OkA;.hiQUSR`rZaDaWmv/p:3Kn$9!@#j?O&!ep< B0V1AW(%31$.1e+`' );
define( 'SECURE_AUTH_SALT', '>um)g3IL|n^H/$_/P^_DAgtS7t[w^AqMUmWo7,5E(]cd(: Q|f*:g-ZMgw-UI4nT' );
define( 'LOGGED_IN_SALT',   'LaCRSo|b%rof: 18tr-C48U][l%2HAQ,B.t UCJN@oq/<?8-W`t>O+`NN.AnmDc,' );
define( 'NONCE_SALT',       'H8WqEgA!x/K%/;Rf+pta=j-nZ9y9fA6P+Q:>[Mu5bt7mi2k0p!;i[z~{`EjG9hX~' );
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
 * Pour les développeurs et développeuses : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs et développeuses d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur la documentation.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('QM_HIDE_CORE_ACTIONS', true);
/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */
/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');