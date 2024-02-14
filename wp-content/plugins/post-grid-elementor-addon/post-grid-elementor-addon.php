<?php
/**
 * Plugin Name: Post Grid Elementor Addon
 * Description: Elementor page builder addon to display posts in a grid. Useful for generating post grid from your blog posts with multiple options.
 * Plugin URI: https://wphait.com/plugins/post-grid-elementor-addon/
 * Version: 2.0.16
 * Author: WP Hait
 * Author URI: https://wphait.com/
 * Text Domain: post-grid-elementor-addon
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'PGEA_VERSION', '2.0.16' );
define( 'PGEA_SLUG', 'post-grid-elementor-addon' );
define( 'PGEA_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
define( 'PGEA_URI', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'PGEA_UPGRADE_URL', 'https://checkout.freemius.com/mode/dialog/plugin/6007/plan/9846/' );


if ( ! defined( 'WP_WELCOME_DIR' ) ) {
	define( 'WP_WELCOME_DIR', PGEA_URI . '/vendor/ernilambar/wp-welcome' );
}

if ( ! defined( 'WP_WELCOME_URL' ) ) {
	define( 'WP_WELCOME_URL', PGEA_URL . '/vendor/ernilambar/wp-welcome' );
}

// Include autoload.
if ( file_exists( PGEA_URI . '/vendor/autoload.php' ) ) {
	require_once PGEA_URI . '/vendor/autoload.php';
	require_once PGEA_URI . '/vendor/ernilambar/wp-welcome/init.php';
}

/**
 * Main Post Grid Elementor Addon Class
 *
 * The init class that runs the Post Grid plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.2.0
 */
final class Elementor_Post_Grid {

	/**
	 * Plugin Version
	 *
	 * @since 1.2.0
	 * @var string The plugin version.
	 */
	const VERSION = PGEA_VERSION;

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6.20';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'post-grid-elementor-addon' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		add_action( 'admin_init', array( $this, 'setup_custom_notice' ) );

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
		require_once( 'inc/admin.php' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'post-grid-elementor-addon' ),
			'<strong>' . esc_html__( 'Post Grid Elementor Addon', 'post-grid-elementor-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'post-grid-elementor-addon' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'post-grid-elementor-addon' ),
			'<strong>' . esc_html__( 'Post Grid Elementor Addon', 'post-grid-elementor-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'post-grid-elementor-addon' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'post-grid-elementor-addon' ),
			'<strong>' . esc_html__( 'Post Grid Elementor Addon', 'post-grid-elementor-addon' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'post-grid-elementor-addon' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Add admin notice.
	 *
	 * @since 2.0.8
	 */
	public function setup_custom_notice() {
		// Setup notice.
		\Nilambar\AdminNotice\Notice::init(
			array(
				'slug' => PGEA_SLUG,
				'name' => esc_html__( 'Post Grid Elementor Addon', 'post-grid-elementor-addon' ),
			)
		);
	}
}

// Instantiate Elementor_Post_Grid.
new Elementor_Post_Grid();