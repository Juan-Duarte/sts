<?php
	include_once 'models/model.php';
	
	/*
	* This model interacts with the Yahoo! Financial RSS feeds
	* to retrieve news articles.
	*/
	class News extends Model
	{
		/*
		* Uses SimpleXMLElement class to parse an RSS feed (XML) and
		* return the data to the controller.
		*/
		public static function getHomePageNews()
		{
			// load URL, parse RSS, and build a DOM in memory
			$dom = simplexml_load_file("http://news.yahoo.com/rss/stock-markets");
 
			// returns RSS channel's items
			return $dom;
		}
	}
?>
