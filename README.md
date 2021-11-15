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

$obj = new RFCrawler('URL to subreddit here', 'optional user agent'); //Instantiate a new object instance to your feed
$postsRss = $obj->fetchFromJson(); //Fetch posts from JSON. Additionally pass one of the FETCH_TYPE_* constants in order to specify the sorting type, and secondly an array with URLS of which to filter from the posts
$postsRss = $obj->fetchFromRss(); //Fetch posts from RSS. Additionally pass one of the FETCH_TYPE_* constants in order to specify the sorting type, and secondly an array with URLS of which to filter from the posts

foreach ($posts as $post) {
    //Access the following attributes from $post:
    // - $post->title contains the title
    // - $post->link contains the link to the Reddit post
    // - $post->media contains an image if the post is an image
    // - $post->author contains the author information (either only name when fetching from JSON or name for username and uri for link to profile)
}
```

## Testing
In order to run the tests you need to install PHPUnit.

Then run the tests via the following command from the project root:
```
"vendor/bin/phpunit"
```
