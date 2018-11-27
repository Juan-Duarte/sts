<?php
	include_once 'controllers/controller.php';
	include_once 'models/portfolio.php';
	include_once 'models/stock.php';
	include_once 'models/transaction.php';
	
	class AccountPage extends Controller
	{
		public function start()
		{
			$account = parent::requireLogin();
			setlocale(LC_MONETARY, 'en_US');
			$balance = money_format('%i', $account->balance);
			
			
			$pageTitle = 'Account Page';
			$portfolio = Portfolio::getPortfolio($account->id);
			
			$stocks = '';
			$max = count($portfolio);
			for ( $i = 0; $i < $max; $i++ )
			{
				$stocks .= $portfolio[$i]['stock'];
				if ( $i != $max - 1 )
					$stocks .= ',';
			}
			
			$prices = Stock::getLastTradePrice($stocks);
			$prices = str_replace("\r\n", "\n", $prices);
			$prices = explode("\n", $prices);
			$pending = Transaction::getPending($account->id);
			
			include_once 'views/accountpage.php';
		}
	}
?>