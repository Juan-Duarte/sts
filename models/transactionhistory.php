<?php
	include_once 'models/model.php';
	
	class TransactionHistoryModel extends Model
	{
		private $data;
		public static function getLastTenTransactions($account_id, $pageNumber)
		{
			$start = ($pageNumber-1)* 10;
			$dbo = parent::getDBO();
			$sql = "SELECT *
						FROM transactions
						WHERE account_id = '".$account_id."'
						ORDER BY time_completed DESC
						LIMIT ".$start.",10";
			$res = $dbo->query($sql);
			$rows = array();
			echo $dbo->error;
			while(($row = $res->fetch_assoc()) !== NULL)
			{
				$rows[] = $row;
			}
			return $rows;
		}
		public static function getNumberOfTransactions($account_id)
		{
			$dbo = parent::getDBO();
			$sql = "SELECT *
						FROM transactions
						WHERE account_id = '".$account_id."'";
			$res = $dbo->query($sql);
			$rows = array();
			echo $dbo->error;
			while(($row = $res->fetch_assoc()) !== NULL)
			{
				$rows[] = $row;
			}
			$count = count($rows);
			return $count;
		}
	}