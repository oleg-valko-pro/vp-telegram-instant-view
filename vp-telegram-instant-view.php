<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       VALKO.PRO - Instant View for Telegram
 * Plugin URI:        http://valko.pro/plugins/vp-plus-telegram-instant-view
 * Description:       This plugin automatically generates a link for each entry to view in Telegram Instant View
 * Version:           1.2.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Oleg Valko
 * Author URI:        https://valko.pro/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vptiv
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
};

add_action( 'plugins_loaded', 'vptiv_load_plugin_textdomain' );
function vptiv_load_plugin_textdomain() {
	load_plugin_textdomain( 'vptiv', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

// Require files
require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';

class vptiv_Render_Link {
	/*
	 * Plugin options
	 */
	private $options;

	/*
	 * Class construct
	 */
	public function __construct() {
		$this->options = get_option( 'vptiv_options' );
	}

	/*
	 * Hooks
	 */
	public function hooks() {
		add_filter( 'post_row_actions', [ $this, 'add_action_row' ], 10, 2 );
		add_filter( 'page_row_actions', [ $this, 'add_action_row' ], 10, 2 );
	}


	public function render_link( $id ) {
		$link = get_permalink( $id );
		$hash = $this->options['id_vptiv_rhash_field'];

		return "https://t.me/iv?url=$link&rhash=$hash";
	}

	public function add_action_row( $actions, $page_object ) {
		$actions['vptiv'] = '<input value=' . $this->render_link( $page_object->ID ) . '>';

		return $actions;
	}
}

$vptiv = new vptiv_Render_Link();
$vptiv->hooks();