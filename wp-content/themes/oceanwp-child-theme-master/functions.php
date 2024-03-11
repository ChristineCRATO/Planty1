<?php
/**
 * OceanWP Child Theme Functions
 *
 * When running a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions will be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style() {

	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update the theme).
	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );

	// Chargement du style.css du thème parent OceanWP
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
	// Chargement css/theme.css pour nos personnalisations
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/css/theme.css',array(), filemtime(get_stylesheet_directory() . '/css/theme.css'));	
	// Chargement du /css/banniere.css pour le shortcode banniere accueil
	wp_enqueue_style('banniere-shortcode', get_stylesheet_directory_uri() . '/css/banniere.css', array(), filemtime(get_stylesheet_directory() . '/css/banniere.css'));
	// Chargement du /css/banniere-1.css pour le shortcode banniere contact
	wp_enqueue_style('banniere-1-shortcode', get_stylesheet_directory_uri() . '/css/banniere-1.css', array(), filemtime(get_stylesheet_directory() . '/css/banniere-1.css'));

}

// Thème enfant //
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );


// Ajouter le lien Admin dans menu pour les users connectés //
function add_admin_link($items, $args) {
    	if (is_user_logged_in() && isset ( $args->theme_location ) && $args->theme_location === 'main_menu' ) {

// Construction lien Admin //
		$admin_link = '<li><a href="'. admin_url() . '" class="main-menu-link">Admin</a></li>';

// Insérer le lien à la deuxième position dans le menu
		$menu_items = explode('</li>', $items);
		array_splice($menu_items, 1, 0, $admin_link);

// Reconstruire la liste des éléments de menu
		$items = implode('</li>', $menu_items);
}
		return $items;
}

// Ajout lien Admin dans Menu //
add_filter('wp_nav_menu_items', 'add_admin_link', 10, 2);
// Ajout ContactForm7 //
add_filter('wpcf7_autop_or_not', '__return_false');


// SHORTCODE //

// Chargement CSS Bannière de canette Planty Accueil //
add_shortcode('banniere_shortcode', 'banniere_func');

function banniere_func($atts)
{
    // Je récupère l'attributs pour shortcode //
    $atts = shortcode_atts(array(
        'src' => '',
		'alt' => 'ligne de canette energie',
    ), $atts, 'banniere');


// Récup flux d'info //
ob_start();

if($atts['src'] != ""){
	?>

	<div class="banniere" style="background-image: url(<?= $atts['src'] ?>)">
	</div>

	<?php
}

$output = ob_get_contents();
ob_end_clean();

return $output;
}

// Chargement CSS Bannière de canette Planty Contact //
add_shortcode('banniere_1_shortcode', 'banniere_1_func');

function banniere_1_func($atts)
{
    // Je récupère l'attributs pour shortcode //
    $atts = shortcode_atts(array(
        'src' => '',
		'alt' => 'ligne de canette energie'
    ), $atts, 'banniere_1');


// Récup flux d'info //
ob_start();

if($atts['src'] != ""){
	?>

	<div class="banniere-1" style="background-image: url(<?= $atts['src'] ?>)">
	</div>

	<?php
}

$output = ob_get_contents();
ob_end_clean();

return $output;
}
