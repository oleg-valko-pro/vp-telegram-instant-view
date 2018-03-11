<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:       VP+ Telegram Instant View
 * Plugin URI:        http://vp-plus.top/plugins/vp-plus-telegram-instant-view
 * Description:       This plugin automatically generates a link for each entry to view in Telegram Instant View
 * Version:           1.0.0
 * Author:            VP+ Oleg Valko
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
require_once plugin_dir_path( __FILE__ ) . 'admin/console-page.php';
require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';

//Display Telegram Link before the_content()
add_filter( 'the_content', 'vptiv_link' );
function vptiv_link( $content ) {
  $all_options = get_option( 'vptiv_options' );
  
  if ( current_user_can( 'manage_options' ) && ! empty( $all_options['id_vptiv_rhash_field'] ) ) {
    $rhash       = $all_options['id_vptiv_rhash_field'];
    $text        = __('Copy link and paste to Telegram', 'vptiv');
    $url         = get_permalink();
    $title       = get_the_title();
    $href        = "https://t.me/iv?url=$url&rhash=$rhash";
    
    $content = $content . "<a href='$href' class='vptiv-link' style='background:#0088cc; color:#ffffff; padding:5px; border-radius:5px; display:inline-block;'>$text</a>";
  }
  
  return $content;
}
