<?php include 'views/header.php' ?>

<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span> Trade</h2>
	<p>Balance: <?=$balance?></p>
	<?php if ( $errors !== false ): ?>
	<?php foreach ($errors as $e ): ?>
	<p class="red"><?=$e?></p>
	<?php endforeach; ?>
	<?php endif; ?>
   </div>
   <div id="service_pan">
	<form action="index.php?c=trade&e=submit" method="post">
		<table>
			<tr>
				<td>Trade Type</td>
				<td>
					<select class="txt" name="buy_sell" id="trade_type" onchange="changeTradeType()">
						<option value="buy">Buy</option>
						<option value="sell">Sell</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Stock Symbol</td>
				<td><input class="txt" type="text" required name="stock" id="stock" onchange="getStockPrice()"/></td>
				<td id="price">&nbsp;</td>
			</tr>
			<tr>
				<td>Shares</td>
				<td><input class="txt" type="number" required name="shares" id="shares" onchange="getTotalPrice()"/></td>
				<td id="total">&nbsp;</td>
			</tr>
			<tr>
				<td>Order Type</td>
				<td>
					<select class="txt" name="order_type" id="order_type" onchange="changeOrderType()">
						<option value="market">Market</option>
						<option value="limit">Limit</option>
						<option value="stop" id="stop_loss" disabled>Stop Loss</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Limit/Stop</td>
				<td><input class="txt" type="text" name="limit" id="limit" disabled /></td>
			</tr>
			<tr>
				<td><input class="btn" type="submit" name="trade_submit" onclick="return confirmTrade()" value="Trade" /></td>
				<td><button class="btn" type="button" onclick="parent.location='index.php?c=accountpage'">Cancel</button></td>
			</tr>
		</table>
	</form>
   </div>
  </div>
 </div>
</div>
	
<?php include 'views/footer.php' ?>
