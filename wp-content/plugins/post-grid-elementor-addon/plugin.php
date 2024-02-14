<?php
namespace ElementorPostGrid;

/**
 * Class Elementor_Post_Grid_Main
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Elementor_Post_Grid_Main {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_style
	 *
	 * Load main style files.
	 *
	 * @since 1.0.0
	 * @access public
	 */

	public function widget_styles() {
		wp_register_style( 'post-grid-elementor-addon-main', plugins_url( '/assets/css/main.css', __FILE__ ) );
		wp_enqueue_style( 'post-grid-elementor-addon-main' );
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/post-grid.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Elementor_Post_Grid_Widget() );
	}

	public function register_widget_category( $elements_manager ) {

		$elements_manager->add_category(
			'wpcap-items',
			[
				'title' => __( 'WPC Elements', 'post-grid-elementor-addon' ),
				'icon' => 'fa fa-plug',
			]
		);
	}

	/**
	 * Add action links to the plugins page.
	 *
	 * @since 2.0.3
	 *
	 * @param array $links Links.
	 */
	public function add_action_links( $links ) {
	  $output =  array_merge(
	    array(
	      'welcome' => '<a href="' . esc_url( admin_url( 'admin.php?page=pgea-welcome' ) ) . '">' . esc_html__( 'Welcome', 'post-grid-elementor-addon' ) . '</a>',
	    ),
	    $links
	  );

	  $output = array_merge(
	  	$output,
	    array(
	      'go-pro' => '<a href="https://wphait.com/plugins/post-grid-elementor-addon/" target="_blank" style="font-weight:700;">' . esc_html__( 'Go Pro', 'post-grid-elementor-addon' ) . '</a>',
	    )
	  );

	  return $output;
	}


	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget style
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_category' ] );

		// Add an action links.
		add_filter( 'plugin_action_links_' . plugin_basename(__DIR__) . '/post-grid-elementor-addon.php', [ $this, 'add_action_links' ] );
	}
}

// Instantiate Plugin Class
Elementor_Post_Grid_Main::instance();
