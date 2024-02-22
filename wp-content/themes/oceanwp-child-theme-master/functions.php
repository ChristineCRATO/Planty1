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
	// Chargement du /css/banniere.css pour le shortcode banniere
	wp_enqueue_style('banniere-shortcode', get_stylesheet_directory_uri() . '/css/banniere.css', array(), filemtime(get_stylesheet_directory() . '/css/banniere.css'));
	// Chargement Admin Link //

}
// Thème enfant //
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );

// Ajout lien Admin dans Menu //
add_filter( 'wp_nav_menu_items', 'add_extra_item_to_nav_menu', 10, 2 );
function add_extra_item_to_nav_menu( $items, $args ) {
    if (is_user_logged_in() && $args->menu == 3) {
        $items .= '<li><a href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'">My Account</a></li>';
    }
    elseif (!is_user_logged_in() && $args->menu == 3) {
        $items .= '<li><a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '">Sign in  /  Register</a></li>';
    }
    return $items;
}

add_filter('wpcf7_autop_or_not', '__return_false');


// SHORTCODE //
// Chargement CSS Bannière de canette Planty  //
add_shortcode('banniere_shortcode', 'banniere_func');

function banniere_func($atts)
{
    // Je récupère l'attributs pour shortcode //
    $atts = shortcode_atts(array(
        'src' => '',
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
