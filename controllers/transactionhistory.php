<?php
	include_once 'controllers/controller.php';
	include_once 'models/transactionhistory.php';
	
	class TransactionHistory extends Controller
	{
		public function start()
		{
			$account = parent::requireLogin();
			
			$transactionArraySize = TransactionHistoryModel::getNumberOfTransactions($account->id);
			$transactionSize= (int)($transactionArraySize/10)+1;
			$pageTitle = 'Transaction History Page';
			if(isset($_GET['p']))
			{
				$page = $_GET['p'];
				if($page > $transactionSize)
				{
					$page =  $transactionSize;
				}
				if($page<=0)
				{
					$page = 1;
				}
			}
			else
			{
				$page = 1;
			}
			
			if(!is_numeric($page))
			{
				$page = 1;
			}
			$transactions = TransactionHistoryModel::getLastTenTransactions($account->id, $page);
			
			
			include_once 'views/transaction_history.php';
		}
	}
?>