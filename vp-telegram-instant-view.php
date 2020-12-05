<?php
/**
 *
 * @wordpress-plugin
 * Plugin Name:       VP Instant View for Telegram
 * Plugin URI:        http://valko.pro/plugins/vp-plus-telegram-instant-view
 * Description:       This plugin automatically generates a link for each entry to view in Telegram Instant View
 * Version:           1.1.2
 * Author:            Oleg Valko
 * Author URI:        http://valko.pro/
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

// Display Telegram Link before the_content()
add_filter( 'the_content', 'vptiv_link' );
function vptiv_link( $content ) {
	$all_options = get_option( 'vptiv_options' );
	
	if ( current_user_can( 'manage_options' ) && ! empty( $all_options['id_vptiv_rhash_field'] ) ) {
		$rhash = $all_options['id_vptiv_rhash_field'];
		$text  = __( 'Copy link and paste to Telegram', 'vptiv' );
		$url   = get_permalink();
		$href  = "https://t.me/iv?url=$url&rhash=$rhash";
		$style = 'style="background:#000; color:#fff; padding:5px; border-radius:5px; display:inline-block;"';
		$style = apply_filters( 'vptiv_btn_style', $style );
		
		$content = $content . sprintf( '<a href="%s" class="vptiv-link"%s>%s</a>', $href, $style, $text );
	}
	
	return $content;
}
