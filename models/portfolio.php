<?php
	include_once 'models/model.php';
	
	class Portfolio extends Model
	{
		private $data;
		public static function getPortfolio($account_id)
		{
			$dbo = parent::getDBO();
			$sql = "SELECT stock, shares
						FROM portfolios
						WHERE account_id = '".$account_id."'";
			$res = $dbo->query($sql);
			$rows = array();
			while(($row = $res->fetch_assoc()) !== NULL)
			{
				$rows[] = $row;
			}
			return $rows;
		}
		
		public static function getShares($account_id, $stock)
		{
			$dbo = parent::getDBO();
			$sql = "SELECT shares
						FROM portfolios
						WHERE account_id = '".$account_id."'
						AND stock = '".$stock."'";
			$res = $dbo->query($sql);
			
			if ( $res->num_rows == 0 )
				return 0;
			
			$row = $res->fetch_assoc();
			return $row["shares"];
		}
	}
	
?>