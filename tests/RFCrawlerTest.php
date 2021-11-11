<?php

use PHPUnit\Framework\TestCase;
use RFCrawler\RFCrawler;

/**
 * TestCase for RFCrawler\RFCrawler
 */
final class RFCrawlerTest extends TestCase
{
    public function testGetPosts()
    {
        $obj = new RFCrawler('https://www.reddit.com/r/gamedevscreens/');
        $posts = $obj->fetchPosts();
        
        $this->assertTrue(is_array($posts));

        foreach ($posts as $post) {
            $this->assertTrue(isset($post->title));
            $this->assertTrue(isset($post->link));
            $this->assertTrue(isset($post->media));
            $this->assertTrue(isset($post->author));
            $this->assertTrue(isset($post->author->name));
            $this->assertTrue(isset($post->author->uri));
        }
    }
}