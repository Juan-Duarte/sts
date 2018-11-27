<?php
	include_once 'controllers/controller.php';
	include_once 'models/stock.php';
	include_once 'models/account.php';
	include_once 'models/transaction.php';
	include_once 'models/portfolio.php';
	include_once 'lib/communication.php';
	
	class Trade extends Controller
	{
		public function start()
		{
			$account = parent::requireLogin();
			
			setlocale(LC_MONETARY, 'en_US');
			$balance = money_format('%i', $account->balance);
			$pageTitle = 'Trade';
			$tradePage = true;
			
			$errors = parent::getErrors();
			
			include_once 'views/trade_form.php';
		}
		
		public function cancel()
		{
			$account = parent::requireLogin();
			
			if ( isset($_GET['t']) && is_numeric($_GET['t']) )
			{
				$result = Transaction::cancelPending($_GET['t']);
				include_once 'views/cancel_pending.php';
			}
		}
		
		public function submit()
		{
			$account = parent::requireLogin();
			
			$check = $this->checkTradeForm($_POST);
			
			if ( $check === true )
			{
				$_POST['stock'] = strtoupper($_POST['stock']);
				
				if ( $_POST['buy_sell'] === 'buy' )
					$tradeType = 'Buy';
				else
					$tradeType = 'Sell';
				
				if ( $_POST['order_type'] === 'market' )
					$orderType = 'Market';
				else if ( $_POST['order_type'] === 'limit' )
					$orderType = 'Limit';
				else
					$orderType = 'Stop Loss';
			
				if ( $_POST['order_type'] === 'market' )
				{
					Transaction::marketOrder($account, $_POST);
					market_transaction($tradeType, $_POST['stock'], $_POST['shares'], $account->email);
					include_once 'views/trade_market.php';
				}
				else
				{
					Transaction::limitOrder($account, $_POST);
					limit_transaction($tradeType, $_POST['stock'], $_POST['shares'], $orderType, $_POST['limit'], $account->email);
					include_once 'views/trade_limit.php';
				}
			}
			else
			{
				parent::addErrors($check);
				header('Location: index.php?c=trade');
				exit();
			}
		}
		
		private function checkTradeForm($post)
		{
			$account = parent::getAccount();
			$errors = array();
			
			if ( !isset($post['trade_submit']) )
				$errors[] = 'Invalid input.';
			
			$price = Stock::getLastTradePrice($post['stock']);
			
			if ( $price === '0.00' )
				$errors[] = 'Invalid stock symbol.';
			
			if ( $post['buy_sell'] !== 'buy' && $post['buy_sell'] !== 'sell' )
				$errors[] = 'Invalid trade type.';
			
			if ( $post['order_type'] !== 'market' && $post['order_type'] !== 'limit' && $post['order_type'] !== 'stop' )
				$errors[] = 'Invalid order type.';
				
			if ( $post['buy_sell'] === 'buy' && $post['order_type'] === 'stop' )
				$errors[] = 'You cannot do that.';
				
			if ( $post['buy_sell'] === 'sell' )
			{
				$sharesOwned = Portfolio::getShares($account->id, $post['stock']);
				if ( $post['shares'] > $sharesOwned )
					$errors[] = 'You only own '.$sharesOwned.' shares of '.$post['stock'].' stock.';
			}
			
			$sharesMatch = '/^[[:digit:]]+$/';
			if ( !preg_match($sharesMatch, $post['shares']) )
				$errors[] = 'Invalid number of shares.';
				
			$total = $price * $post['shares'];
			if ( $total > $account->balance && $post['buy_sell'] === 'buy' )
				$errors[] = 'You do not have enough balance to purchase this number of stocks.';
			
			$limitMatch = '/^[[:digit:]]+(\.[[:digit:]]{1,4})?$/';
			if ( ($post['order_type'] === 'limit' || $post['order_type'] === 'stop') && !preg_match($limitMatch, $post['limit']) )
				$errors[] = 'Invalid dollar amount for limit/stop.';
			
			if ( count($errors) )
				return $errors;
			
			return true;
		}
		
		public function price()
		{
			if ( isset($_GET['s']) )
			{
				echo Stock::getLastTradePrice($_GET['s']);
			}
		}
	}
?>
