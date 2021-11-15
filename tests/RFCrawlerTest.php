<?php

use PHPUnit\Framework\TestCase;
use RFCrawler\RFCrawler;

/**
 * TestCase for RFCrawler\RFCrawler
 */
final class RFCrawlerTest extends TestCase
{
    private const TEST_USER_AGENT = 'RFCrawler';

    protected static function getMethod($name)
    {
        $class = new ReflectionClass('RFCrawler\\RFCrawler');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testConstruct()
    {
        $obj = new RFCrawler('/r/gamedevscreens/');
        $this->assertNotNull($obj);
    }

    public function testUserAgent()
    {
        $oldUserAgent = ini_get('user_agent');

        $obj = new RFCrawler('/r/gamedevscreens/', self::TEST_USER_AGENT);
        $storeUserAgent = self::getMethod('storeUserAgent');
        $resetUserAgent = self::getMethod('resetUserAgent');

        $storeUserAgent->invoke($obj);
        $this->assertEquals(ini_get('user_agent'), self::TEST_USER_AGENT);

        $resetUserAgent->invoke($obj);
        $this->assertEquals(ini_get('user_agent'), $oldUserAgent);
    }

    public function testFetchFromJson()
    {
        $obj = new RFCrawler('/r/gamedevscreens/', self::TEST_USER_AGENT);
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

    public function testFetchFromRss()
    {
        $obj = new RFCrawler('/r/gamedevscreens/', self::TEST_USER_AGENT);
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
}