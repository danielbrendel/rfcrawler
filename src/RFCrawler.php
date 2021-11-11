<?php 

/*
    RFCrawler developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
*/

namespace RFCrawler;

/**
 * Class RFCrawler
 * 
 * Interface to subreddit feed content
 */
class RFCrawler {
	/**
	 * Fetch types
	 */
	public const FETCH_TYPE_NEW = 'new';
	public const FETCH_TYPE_HOT = 'hot';
	public const FETCH_TYPE_TOP = 'top';
	
	/**
	 * @var string
	 * 
	 * URL to subreddit
	 */
	public string $url;
	
	/**
	 * Constructor to save URL
	 * 
	 * @return void
	 */
	public function __construct($url)
	{
		$this->url = $url;
	}
	
	/**
	 * Fetch subreddit posts
	 * 
	 * @param $type
	 * @return array
	 * @throws \Exception
	 */
	public function fetchPosts($type = self::FETCH_TYPE_NEW)
	{
		try {
			$result = array();
			
			$xml = simplexml_load_file("{$this->url}{$type}/.rss");
			
			foreach ($xml->entry as $x) {
				$item = new \stdClass();
				
				$item->title = $x->title;
				$item->link = $x->link['href'];
				$item->media = $this->extractImage($x->content);
				$item->author = $x->author;

				$result[] = $item;
			}
			
			return $result;
		} catch (\Exception $e) {
			throw $e;
		}
	}
	
	/**
	 * Extract image from image post
	 * 
	 * @param string $content
	 * @return string
	 * @throws \Exception
	 */
	private function extractImage($content)
	{
		try {
			$strp = strpos($content, '<img src="');
			
			if ($strp != -1) {
				$strp += strlen('<img src="');
				
				$result = '';
				
				for ($i = $strp; $i < strlen($content); $i++) {
					if (substr($content, $i, 1) === '"') {
						break;
					}
					
					$result .= substr($content, $i, 1);
				}
				
				if (substr($result, 0, 8) !== 'https://') {
					return '';
				}
				
				return $result;
			}
			
			return '';
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
