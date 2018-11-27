<?php
	set_include_path(get_include_path().PATH_SEPARATOR.'../');
	
	include_once '../models/model.php';
	include_once '../models/stock.php';
	include_once '../models/portfolio.php';
	
	$dbo = Model::getDBO();
	
	$sql = "SELECT *
			FROM transactions
			WHERE (trade_type = 'limit' OR trade_type = 'stop')
				AND time_completed IS NULL";
	$res1 = $dbo->query($sql);
	
	while ( ($row = $res1->fetch_assoc()) != NULL )
	{
		echo 'Processing: ';
		var_dump($row);
		echo'<br />';
		$id = $row['id'];
		
		$price = Stock::getLastTradePrice($row['stock']);
		
		$sql = "SELECT *
				FROM accounts
				WHERE id = $row[account_id]";
		$res = $dbo->query($sql);
		if ( !$res )
		{
			echo 'Could not check balance: '.$dbo->error;
			break;
		}
		
		$acct = $res->fetch_assoc();
		$total = $price * $row['shares'];
		$time = date('Y-m-d H:i:s');
		$newBal = $acct['balance'];
		
		if ( $row['buy_sell'] === 'buy' )
		{
			if ( $price <= $row['trade_limit'] )
			{
				
				$newBal = $acct['balance'] - $total;
				echo 'total: '.$total.'<br />'.'old bal: '.$acct['balance'].'<br />new bal: '.$newBal.'<br /><br />';
				
				if ( $total > $acct['balance'] )
					break;

				// update the transaction row
				$sql = "UPDATE transactions
						SET time_completed = '$time',
							price = '$price'
						WHERE id = $id";
				$res = $dbo->query($sql);
				echo "updated transaction at time $time and price $price<br />";
				if ( !$res )
					echo 'Failed to update transaction row: '.$dbo->error;
				
				// check if stock in portfolio
				$newShares = Portfolio::getShares($row['account_id'], $row['stock']);
				
				if ( $newShares == 0 )
				{
					$sql = "INSERT INTO portfolios
					(
						account_id,
						stock,
						shares
					)
					VALUES
					(
						$row[account_id],
						'$row[stock]',
						'$row[shares]'
					)";
					$res = $dbo->query($sql);
				}
				else
				{
					$newShares += $row['shares'];
					$sql = "UPDATE portfolios
							SET shares = $newShares
							WHERE account_id = $row[account_id]
								AND stock = '$row[stock]'";
					$res = $dbo->query($sql);
					
					if ( !$res )
						echo 'Failed to update portfolio: '.$dbo->error;
				}
			}
		}
		else
		{
			// check stocks
			$shares = Portfolio::getShares($row['account_id'], $row['stock']);
			
			if ( ($row['trade_type'] === 'limit' && $price >= $row['limit'])
				|| ($row['trade_type'] === 'stop' && $price <= $row['limit']) )
			{
				$newBal = $acct['balance'] + $total;
				
				
				// update the transaction row
				$sql = "UPDATE transactions
						SET time_completed = '$time',
							price = '$price'
						WHERE id = $id";
				$res = $dbo->query($sql);
				echo "updated transaction at time $time and price $price<br />";
				if ( !$res )
					echo 'Failed to update transaction row: '.$dbo->error;
				
				// if acct does not own those shares, sell what they have
				if ( $shares < $row['shares'] )
					$row['shares'] = $shares;
				
				$newShares = $shares - $row['shares'];
				$sql = "UPDATE portfolios
						SET shares = $newShares
						WHERE account_id = $row[account_id]
							AND stock = '$row[stock]'";
				$res = $dbo->query($sql);
				
				if ( !$res )
				{
					echo 'Could not update portfolio: '.$dbo->error;
					break;
				}
			}
		}
		
		
		// update balance
		$sql = "UPDATE accounts
				SET balance = $newBal
				WHERE id = $row[account_id]";
		$res = $dbo->query($sql);
		echo "updated balance to $newBal from $acct[balance]<br /><br />";
		
		if ( !$res )
		{
			echo 'Could not update balance: '.$dbo->error;
			break;
		}
		

	}
?>