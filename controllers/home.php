<?php
	include_once 'controllers/controller.php';
	include_once 'models/news.php';

	class Home extends Controller
	{
		/*
		* This function will use an News model to retrieve the recent US market news and
		* pass it to the home page view. It should also use a home page view
		* (maybe views/home.php or something) to format the data.
		*/
		public function start()
		{
			$pageTitle = 'Ultimate STS';
			$homePage = true;
			$data = News::getHomePageNews(); 
			$errors = parent::getErrors();
			include_once 'views/home.php';
		}
	}
?>
