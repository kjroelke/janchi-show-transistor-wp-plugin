<?php
/**
 * Plugin Name: Janchi Show x Transistor WP Plugin
 * Plugin URI: https://github.com/choctaw-nation/cno-template-plugin
 * Description: Keeps the Janchi Show website in sync with Transistor.fm episodes.
 * Version: 1.0.1
 * Author: K.J. Roelke
 * Author URI: https://www.kjroelke.online
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires PHP: 8.2
 * Requires at least: 6.7.0
 * Tested up to: 6.9.0
 *
 * @package JanchiShow
 */

use JanchiShow\Plugins\Podcast_API;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
if ( ! defined( 'TRANSISTOR_API' ) ) {
	_doing_it_wrong( __FILE__, 'TRANSISTOR_API constant not defined', '1.0.0' );
	return;
}

require_once __DIR__ . '/inc/class-podcast-api.php';

add_action(
	'wp_loaded',
	function () {
		$hook = 'janchi_show_sync_episodes';

		if ( ! wp_next_scheduled( $hook ) ) {
			$event_time = new DateTime( 'now', wp_timezone() );
			$event_time->setTime( 5, 0, 0 );
			if ( 'Wednesday' === $event_time->format( 'l' ) && $event_time > new DateTime( 'now', wp_timezone() ) ) {
				$first_event_timestamp = $event_time->getTimestamp();
			} else {
				$event_time->modify( 'next Wednesday' );
				$first_event_timestamp = $event_time->getTimestamp();
			}
			wp_schedule_event( $first_event_timestamp, 'weekly', $hook );
		}
	}
);

add_action(
	'janchi_show_sync_episodes',
	function () {
		$podcast_api = new Podcast_API();
		$podcast_api->get_latest_episodes();
	}
);

register_deactivation_hook(
	__FILE__,
	function () {
		wp_clear_scheduled_hook( 'janchi_show_sync_episodes' );
	}
);
