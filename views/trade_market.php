<?php include_once 'views/header.php' ?>
<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span>Trade Successful!</h2>
   </div>
	<div id="service_pan">
	<p>Your transaction has been processed successfully. Here are the details:</p>
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
	</table>
</div>
</div>
 </div>
</div>	
<?php include_once 'views/footer.php' ?>
