<?php
/**
 * Plugin Name: Janchi Show x Transistor WP Plugin
 * Plugin URI: https://github.com/choctaw-nation/cno-template-plugin
 * Description: Keeps the Janchi Show website in sync with Transistor.fm episodes.
 * Version: 1.0.0
 * Author: K.J. Roelke
 * Author URI: https://www.kjroelke.online
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires PHP: 8.2
 * Requires at least: 6.7.0
 * Tested up to: 6.8.3
 *
 * @package JanchiShow
 */



if ( ! defined( 'ABSPATH' ) ) {
	die;
}
if ( ! defined( 'TRANSISTOR_API' ) ) {
	_doing_it_wrong( __FILE__, 'TRANSISTOR_API constant not defined', '1.0.0' );
	return;
}

require_once __DIR__ . '/inc/class-podcast-api.php';
$podcast_api = new Podcast_API();
