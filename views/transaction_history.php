<?php include_once 'views/header.php'; ?>
<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span>Transaction History</h2>
	 </div>
	<div style="float: right">
		<p><?="Page ".$page." out of ".$transactionSize?></p>
	</div>
	<div id="service_pan">
		<table class="portfolio">
			<tr>
				<th>Date/Time</th>   
				<th>Stock</th>   
				<th>Shares</th>   
				<th>Price</th>
				<th>Transaction Type</th>
			</tr>
			<?php
				foreach($transactions as $transaction):
					$date = $transaction['time_completed'];
					$stock = $transaction['stock'];
					$shares = $transaction['shares'];
					$price = $transaction['price'];
					$transactionType = $transaction['buy_sell'];
				
			?>
			<tr>
				<td><?=$date?></td>
				<td><?=$stock?></td>
				<td><?=$shares?></td>
				<td><?=$price?></td>
				<td><?=$transactionType?></td>
			</tr>	
			<?php endforeach;?>
		</table>
	</div>
	<div id="service_pan">
		<table>
			<tr>
				<td><button class="btn" type="button" onclick="parent.location='index.php?c=transactionhistory&p=<?=$page-1?>'">Previous</button></td>
				<td><button style="float: right" class="btn" type="button" onclick="parent.location='index.php?c=transactionhistory&p=<?=$page+1?>'">Next</button></td>
			</tr>
		</table>
	</div>
	</div>
 </div>
</div>	
<?php include_once 'views/footer.php'; ?>
