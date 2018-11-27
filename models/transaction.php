<?php
	include_once 'models/model.php';
	include_once 'models/stock.php';
	
	class Transaction extends Model
	{
		public static function cancelPending($trans_id)
		{
			$dbo = parent::getDBO();
			
			$sql = "DELETE FROM transactions WHERE id = $trans_id";
			$res = $dbo->query($sql);
		}
		
		public static function getPending($account_id)
		{
			$dbo = parent::getDBO();
			
			$sql = "SELECT * FROM transactions WHERE account_id = $account_id AND time_completed IS NULL ORDER BY time_submitted ASC";
			$res = $dbo->query($sql);
			
			if ( !$res )
				exit('Could not get pending transactions: '.$dbo->error);
			
			$rows = array();
			while( ($row = $res->fetch_assoc()) !== NULL )
				$rows[] = $row;
			return $rows;
		}
		
		public static function marketOrder($account, $post)
		{
			$price = Stock::getLastTradePrice($post['stock']);
			$total = $price * $post['shares'];
			
			if ( $post['buy_sell'] === 'buy' )
				$account->balance -= $total;
			else
				$account->balance += $total;
			
			$time = date('Y-m-d H:i:s');
			
			$dbo = parent::getDBO();
			$sql = "INSERT INTO transactions
			(
				account_id,
				stock,
				shares,
				price,
				time_submitted,
				time_completed,
				buy_sell,
				trade_type
			)
			VALUES
			(
				".$account->id.",
				'".$post['stock']."',
				'".$post['shares']."',
				'".$price."',
				'".$time."',
				'".$time."',
				'".$post['buy_sell']."',
				'".$post['order_type']."'
			)";
			$res = $dbo->query($sql);
			
			if ( !$res )
				exit('Transaction failed. Please try again.'.$dbo->error);
			
			$sql = "SELECT *
					FROM portfolios
					WHERE account_id = ".$account->id."
						AND stock = '".$post['stock']."'";
			$res = $dbo->query($sql);
			if ( $res->num_rows == 1 )
			{
				$row = $res->fetch_assoc();
				$newShares = $row['shares'];
				
				if ( $post['buy_sell'] === 'buy' )
					$newShares += $post['shares'];
				else
					$newShares -= $post['shares'];
				
				$sql = "UPDATE portfolios
						SET shares = ".$newShares."
						WHERE account_id = ".$account->id."
							AND stock = '".$post['stock']."'";
			}
			else
				$sql = "INSERT INTO portfolios
				(
					account_id,
					stock,
					shares
				)
				VALUES
				(
					".$account->id.",
					'".$post['stock']."',
					'".$post['shares']."'
				)";
			
			
			$res = $dbo->query($sql);
			if ( !$res )
				exit('Portfolios failed. Please try again.');
		}
		
		public static function limitOrder($account, $post)
		{
			$time = date('Y-m-d H:i:s');
			$dbo = parent::getDBO();
			$sql = "INSERT INTO transactions
			(
				account_id,
				stock,
				shares,
				time_submitted,
				buy_sell,
				trade_type,
				trade_limit
			)
			VALUES
			(
				".$account->id.",
				'".$post['stock']."',
				".$post['shares'].",
				'".$time."',
				'".$post['buy_sell']."',
				'".$post['order_type']."',
				".$post['limit']."
			)";
			$res = $dbo->query($sql);
			
			if ( !$res )
				exit('Transaction failed. Please try again.');
		}
	}
?>