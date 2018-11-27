<?php include_once 'views/header.php' ?>
<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span>Order Successful!</h2>
   </div>
   <div id="service_pan">
	<p>Your limit order has been placed. Here are the details:</p>
	<table>
		<tr>
			<td>Trade Type:</td>
			<td><?=$tradeType?></td>
		</tr>
		<tr>
			<td>Stock:</td>
			<td><?=$_POST['stock']?></td>
		</tr>
		<tr>
			<td>Shares</td>
			<td><?=$_POST['shares']?></td>
		</tr>
		<tr>
			<td>Order Type:</td>
			<td><?=$orderType?></td>
		</tr>
		<tr>
			<td>Limit:</td>
			<td><?=$_POST['limit']?></td>
		</tr>
	</table>
</div>
</div>
 </div>
</div>	
<?php include_once 'views/footer.php' ?>
