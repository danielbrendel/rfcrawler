<?php

use PHPUnit\Framework\TestCase;
use RFCrawler\RFCrawler;

/**
 * TestCase for RFCrawler\RFCrawler
 */
final class RFCrawlerTest extends TestCase
{
    public function testFetchFromRss()
    {
        $obj = new RFCrawler('/r/gamedevscreens/');
        $posts = $obj->fetchFromRss();
        
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

    public function testFetchFromJson()
    {
        $obj = new RFCrawler('/r/gamedevscreens/');
        $posts = $obj->fetchFromJson();
        
        $this->assertTrue(is_array($posts));

        foreach ($posts as $post) {
            $this->assertTrue(isset($post->title));
            $this->assertTrue(isset($post->link));
            $this->assertTrue(isset($post->media));
            $this->assertTrue(isset($post->author));
            $this->assertTrue(isset($post->author));
        }
    }
}