# Janchi Show Transistor WordPress Plugin

Keeps the WordPress site in sync with the Transistor.fm episode releases. Syncs artwork

[Read the changelog here.](/CHANGELOG.md)

## What it Does

1. Creates a cron event to sync episodes every week on Wednesdays

## How it Does

-   Explicitly sets Podcast category type to 164
-   Explicitly posts new episodes with the author id of 4
-   Explicitly creates a new `episodes` post
-   Creates a post excerpt by parsing the episode description and looking for `---`
-   Uploads artwork to the media library and sets it as the featured image

## Contributing

Maybe don't? But feel free to fork it! Reach out to me @kjroelke wherever I want to be found on the internet.
