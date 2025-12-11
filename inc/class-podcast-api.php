<?php
/**
 * Podcast API
 *
 * The Class that handles the Transistor API Request
 *
 * @package JanchiShow
 */

/** Get Parent Class. */
require_once __DIR__ . '/class-api.php';

/** Get Podcast Attributes Data Type */
require_once __DIR__ . '/class-episode-attributes.php';

/**
 * This class protects and manages the API Request that a Cron job will make.
 */
class Podcast_API extends API {
	/**
	 * The episode data
	 *
	 * @var $episode
	 */
	protected Episode_Attributes $episode;

	/**
	 * The Janchi Show User ID on the Production Site
	 *
	 * @var $production_env_user_id
	 */
	private int $production_env_user_id = 4;

	/**
	 * The "Podcast" Category ID on the Production Site
	 *
	 * @var $production_env_category_id
	 */
	private int $production_env_category_id = 164;


	/**
	 * Creates new Post for each artist in the `artist_data` object with `wp_insert_post`
	 */
	public function get_latest_episode() {
		$data             = $this->get_episode_data();
		$latest_episode   = $data['data'][0];
		$this->episode    = new Episode_Attributes( $latest_episode['attributes'] );
		$new_episode_post = $this->wp_friendly_array( $this->episode );
		remove_filter( 'content_save_pre', 'wp_filter_post_kses' );
		remove_filter( 'content_filtered_save_pre', 'wp_filter_post_kses' );
		$episode_id = wp_insert_post( $new_episode_post, true );
		add_filter( 'content_save_pre', 'wp_filter_post_kses' );
		add_filter( 'content_filtered_save_pre', 'wp_filter_post_kses' );
		if ( is_wp_error( $episode_id ) ) {
			$error = $episode_id->get_error_message();
			$this->log_error( $error );
		} else {
			$this->set_artwork( $episode_id );

		}
	}

	/**
	 * Create a WordPress Friendly Array
	 *
	 * @param Episode_Attributes $episode the episode
	 */
	private function wp_friendly_array( Episode_Attributes $episode ): array {
		$content = $this->set_the_post_content( $episode );
		$excerpt = $this->get_the_post_excerpt( $episode->formatted_description );

		$new_episode_post = array(
			'post_title'    => $episode->title,
			'post_type'     => 'episodes',
			'post_status'   => 'publish',
			'post_author'   => $this->production_env_user_id,
			'post_date'     => $episode->published_at,
			'post_content'  => $content,
			'post_category' => array( $this->production_env_category_id ),
		);
		if ( $excerpt ) {
			$new_episode_post['post_excerpt'] = $excerpt;
		}
		return $new_episode_post;
	}

	/**
	 * Sets the Post Content to the Show Description & Embedded HTML Player
	 *
	 * @param Episode_Attributes $episode the Episode
	 */
	private function set_the_post_content( Episode_Attributes $episode ): string {

		$content = $episode->embed_html . $episode->formatted_description;
		return $content;
	}

	/**
	 * Gets the Post excerpt
	 *
	 * @param string $description the Episode_Attributes->formatted_description
	 * @return string|false returns the excerpt or false
	 */
	private function get_the_post_excerpt( string $description ) {
		$html_parts = explode( '---', $description );
		// Get the content before '---' (if it exists)
		if ( count( $html_parts ) > 0 ) {
			$html_before_dash = $html_parts[0];
			return $html_before_dash;
		} else {
			return false;
		}
	}

	/** Sets the Show Art
	 *
	 * @param int $id the Episode ID
	 * @return int|bool the ID or 0 if error
	 */
	private function set_artwork( int $id ): int {
		$image_data    = wp_upload_bits( basename( $this->episode->image_url ), null, file_get_contents( $this->episode->image_url, false, null, 0 ) );
		$attachment    = array(
			'post_mime_type' => $image_data['type'],
			'post_title'     => "Episode {$this->episode->number} artwork",
			'post_content'   => '',
			'post_status'    => 'inherit',
		);
		$attachment_id = wp_insert_attachment( $attachment, $image_data['file'], $id );

		if ( ! is_wp_error( $attachment_id ) ) {
			// Set the uploaded image as the featured image
			return set_post_thumbnail( $id, $attachment_id );
		}
		return 0;
	}
}
