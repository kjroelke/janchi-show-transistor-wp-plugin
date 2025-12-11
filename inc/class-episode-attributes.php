<?php //phpcs:disable Squiz.Commenting.VariableComment.Missing
/**
 * Episode Attributes
 *
 * @package JanchiShow
 */

namespace JanchiShow\Plugins;

/** The Episode Attributes from Transistor */
class Episode_Attributes {
	public int $transistor_id;
	public ?string $title;
	public ?int $number;
	public ?int $season;
	public ?string $status;
	public ?string $published_at;
	public ?int $duration;
	public ?bool $explicit;
	public ?string $keywords;
	public ?string $alternate_url;
	public ?string $media_url;
	public ?string $image_url;
	public ?string $video_url;
	public ?string $author;
	public ?string $summary;
	public ?string $description;
	public ?string $slug;
	public ?string $created_at;
	public ?string $updated_at;
	public ?string $formatted_published_at;
	public ?string $duration_in_mmss;
	public ?string $share_url;
	public ?string $transcript_url;
	public ?string $formatted_summary;
	public ?string $formatted_description;
	public ?string $embed_html;
	public ?string $embed_html_dark;
	public ?bool $audio_processing;
	public ?string $type;
	public ?string $email_notifications;

	/**
	 * Add array items to class props
	 *
	 * @param array $data the Episode attributes data
	 */
	public function __construct( array $data ) {
		$this->transistor_id          = absint( $data['id'] );
		$this->title                  = $data['title'] ?? null;
		$this->number                 = $data['number'] ?? null;
		$this->season                 = $data['season'] ?? null;
		$this->status                 = $data['status'] ?? null;
		$this->published_at           = $data['published_at'] ?? null;
		$this->duration               = $data['duration'] ?? null;
		$this->explicit               = $data['explicit'] ?? null;
		$this->keywords               = $data['keywords'] ?? null;
		$this->alternate_url          = $data['alternate_url'] ?? null;
		$this->media_url              = $data['media_url'] ?? null;
		$this->image_url              = $data['image_url'] ?? null;
		$this->video_url              = $data['video_url'] ?? null;
		$this->author                 = $data['author'] ?? null;
		$this->summary                = $data['summary'] ?? null;
		$this->description            = $data['description'] ?? null;
		$this->slug                   = $data['slug'] ?? null;
		$this->created_at             = $data['created_at'] ?? null;
		$this->updated_at             = $data['updated_at'] ?? null;
		$this->formatted_published_at = $data['formatted_published_at'] ?? null;
		$this->duration_in_mmss       = $data['duration_in_mmss'] ?? null;
		$this->share_url              = $data['share_url'] ?? null;
		$this->transcript_url         = $data['transcript_url'] ?? null;
		$this->formatted_summary      = $data['formatted_summary'] ?? null;
		$this->formatted_description  = $data['formatted_description'] ?? null;
		$this->embed_html             = $data['embed_html'] ?? null;
		$this->embed_html_dark        = $data['embed_html_dark'] ?? null;
		$this->audio_processing       = $data['audio_processing'] ?? null;
		$this->type                   = $data['type'] ?? null;
		$this->email_notifications    = $data['email_notifications'] ?? null;
	}
}