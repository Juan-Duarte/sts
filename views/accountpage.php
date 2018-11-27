<?php include_once 'views/header.php' ?>

<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>Account #</span><?=$account->account_number?></h2>
	<p>Balance: <?=$balance?></p>
   </div>
   <div id="service_pan">
		<h3><span>Your </span>Portfolio</h3>
		<table class="portfolio">
			 <tr>
				<th>Stocks</th>   
				<th>Shares</th>   
				<th>Price</th>   
				<th>Total</th>
			</tr>
			<?php
				$i = 0;
				foreach($portfolio as $stock):
				$stockName = $stock['stock'];
				$numShares = $stock['shares'];
				$stockPrice = $prices[$i++];
				$totalPrice = money_format('%i', $numShares * $stockPrice);
				$stockPrice = money_format('%i', $stockPrice);
				if($numShares != 0):
			?>
			<tr>
				<td><?=$stockName?></td>
				<td><?=$numShares?></td>
				<td><?=$stockPrice?></td>
				<td><?=$totalPrice?></td>
			</tr>	
			<?php endif;?>
			<?php endforeach;?>
		</table>
   </div>
   <div id="service_pan">
		<h3><span>Your </span>Pending Transactions</h3>
		<table class="portfolio">
			 <tr>
				<th>Stock</th>   
				<th>Shares</th>
				<th>Order Type</th>
				<th>Limit</th>   
				<th>Time Submitted</th>
				<th>Cancel</th>
			</tr>
			<?php
				foreach($pending as $trans):
				$stockName = $trans['stock'];
				$numShares = $trans['shares'];
				$stockPrice = $trans['trade_limit'];
				$stockPrice = money_format('%i', $stockPrice);
				
				$orderType = '';
				if ( $trans['trade_type'] == 'limit' )
				{
					$orderType = 'Limit';
					if ( $trans['buy_sell'] == 'buy' )
						$orderType .= ' Buy';
					else
						$orderType .= ' Sell';
				}
				else
					$orderType = 'Stop Loss';
				
				if($numShares != 0):
			?>
			<tr>
				<td><?=$stockName?></td>
				<td><?=$numShares?></td>
				<td><?=$orderType?></td>
				<td><?=$stockPrice?></td>
				<td><?=$trans['time_submitted']?></td>
				<td><a href="index.php?c=trade&e=cancel&t=<?=$trans['id']?>">Cancel</a></td>
			</tr>	
			<?php endif;?>
			<?php endforeach;?>
		</table>
   </div>
  </div>
 </div>
</div>

<?php include_once 'views/footer.php' ?>
