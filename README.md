# RFCrawler - A simple Reddit feed crawler

## Description
This package is a simple Reddit feed crawler that utilizes RSS feeds for subreddits in order to get the content

## Installation
To install the package run the following composer command:
```code
composer require danielbrendel/rfcrawler 
```
Then simply create an instance of the desired helper class, e.g.:
```php
<?php

require_once __DIR__ . '/../vendor/autoload.php'; //Don't forget to use Composer autoloader if not already

use RFCrawler\RFCrawler; //Require the package class you want to use

$obj = new RFCrawler('URL to subreddit or post here', 'optional user agent', array of optional URL parameters); //Instantiate a new object instance to your feed
$postsJson = $obj->fetchFromJson(...); //Fetch posts from JSON. Additionally pass one of the FETCH_TYPE_* constants in order to specify the sorting type, secondly an array with URLS of which to filter from the posts and thirdly an array of tokens that the media URL must contain at least one of
$postsRss = $obj->fetchFromRss(...); //Fetch posts from RSS. Additionally pass one of the FETCH_TYPE_* constants in order to specify the sorting type, secondly an array with URLS of which to filter from the posts and thirdly an array of tokens that the media URL must contain at least one of

foreach ($posts as $post) {
    //Access the following attributes from $post:
    // - $post->title contains the title
    // - $post->link contains the link to the Reddit post
    // - $post->media contains a link to an image if the post is an image or, if using JSON, may contain a link to a video if the post is a video
    // - $post->author contains the author information (either only name when fetching from JSON or name for username and uri for link to profile)
    // - $post->all All original data entries
}
```

Note: If you want to fetch a single post then use the fetch type constant FETCH_TYPE_IGNORE.

## Testing
In order to run the tests you need to install PHPUnit.

Then run the tests via the following command from the project root:
```
"vendor/bin/phpunit"
```
