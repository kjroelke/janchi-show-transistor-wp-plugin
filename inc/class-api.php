<?php
/**
 * API Class
 * Handles getting the Transistor data from their endpoint
 *
 *  @package JanchiShow
 */

namespace JanchiShow\Plugins;

use WP_Error;

/**
 * Class: API
 * The class that handles the actual API calls
 */
class API {
	/**
	 * The Janchi Show ID
	 *
	 * @var string $show_id
	 */
	protected string $show_id = '13827';

	/**
	 * The Base Transistor API endpoint
	 *
	 * @var $base_url
	 */
	protected string $base_url = 'https://api.transistor.fm/v1';

	/** Error Logging
	 *
	 * @param string $error_message the error message
	 */
	protected function log_error( string $error_message ): void {
		$now           = new DateTime( 'now', wp_timezone() );
		$error_message = $now->format( 'F j, Y g:i a' ) . ' ' . $error_message . "\n";
		wp_mail( array_unique( array( get_option( 'admin_email' ), 'kj.roelke@gmail.com' ) ), 'Transistor API Error', $error_message );
	}

	/**
	 * Gets the data.
	 *
	 * @return array The Episodes Data
	 */
	protected function get_episode_data(): array|WP_Error {
		$transistor_endpoint = $this->base_url . '/episodes' . "?show_id={$this->show_id}";
		$response            = wp_remote_get(
			$transistor_endpoint,
			array(
				'headers' => array( 'x-api-key' => TRANSISTOR_API ),
			)
		);
		if ( isset( $response['response']['message'] ) && 'OK' !== $response['response']['message'] ) {
			$response = new WP_Error( 'transistor_api', $response['response']['message'], $response['headers']['data'] );
		}

		if ( is_wp_error( $response ) ) {
			return $response;
		} else {
			$data = json_decode( wp_remote_retrieve_body( $response ), true );
			return $data;
		}
	}
}
