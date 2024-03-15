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
	// Chargement CSS/theme.css pour nos personnalisations
    wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/CSS/theme.css',array(), filemtime(get_stylesheet_directory() . '/CSS/theme.css'));	
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
