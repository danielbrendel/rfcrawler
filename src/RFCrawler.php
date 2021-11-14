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
	 * Reddit URL
	 */
	 public const URL_REDDIT = "https://www.reddit.com";
	
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
	 * Constructor for instantiation
	 * 
	 * @return void
	 */
	public function __construct($url, $user_agent = '')
	{
		$this->url = self::URL_REDDIT . '/' . $url;

		if ($user_agent !== '') {
			ini_set('user_agent', $user_agent);
		}
	}
	
	/**
	 * Fetch subreddit posts from RSS
	 * 
	 * @param $type
	 * @return array
	 * @throws \Exception
	 */
	public function fetchFromRss($type = self::FETCH_TYPE_NEW)
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
	 * Fetch subreddit posts from JSON
	 * 
	 * @param $type
	 * @param $url_filter
	 * @return array
	 * @throws \Exception
	 */
	public function fetchFromJson($type = self::FETCH_TYPE_NEW, $url_filter = array())
	{
		try {
			$result = array();
			
			$data = json_decode(file_get_contents("{$this->url}{$type}/.json"));
			
			foreach ($data->data->children as $post) {
				$cont = false;
				
				foreach ($url_filter as $uf) {
					if (strpos($post->data->url, $uf) !== false) {
						$cont = true;
						break;
					}
				}
				
				if ($cont === true) {
					continue;
				}
				
				$item = new \stdClass();
				
				$item->title = $post->data->title;
				$item->link = self::URL_REDDIT . "{$post->data->permalink}";
				$item->media = $post->data->url;
				$item->author = $post->data->author;

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
