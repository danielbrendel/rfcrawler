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

$obj = new RFCrawler('URL to subreddit here'); //Instantiate a new object instance to your feed
$posts = $obj->fetchPosts(); //Fetch posts. Additionally pass one of the FETCH_TYPE_* constants in order to specify the sorting type

foreach ($posts as $post) {
    //Access the following attributes from $post:
    // - $post->title contains the title
    // - $post->link contains the link to the Reddit post
    // - $post->media contains an image if the post is an image
    // - $post->author contains the author information (name for username and uri for link to profile)
}
```

## Testing
In order to run the tests you need to install PHPUnit.

Then run the tests via the following command from the project root:
```
"vendor/bin/phpunit"
```
