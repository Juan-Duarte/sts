<?php
	include_once 'models/model.php';
	
	class Stock extends Model
	{
		public static function getLastTradePrice($stock)
		{
			$url = 'http://finance.yahoo.com/d/quotes.csv?s='.$stock.'&f=l1';
			$price = trim(file_get_contents($url));
			return $price;
		}
	}
?>