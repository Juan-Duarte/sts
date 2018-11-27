<?php include 'views/header.php' ?>

<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
	<h2><span>USTS</span>Cash Management</h2>

<?php if ( $errors !== false ) : ?>
		<?php foreach ( $errors as $e ) : ?>
		<p class="red"><?=$e?></p>
		<?php endforeach; ?>
<?php endif; ?>
</div>
<div id="service_pan">
	<form action="index.php?c=cash&e=submit" method="post" name="cash_form">
		<table>
			<tr>
				<td>Action:</td>
				<td>
					<select class="txt" name="action">
						<option value="deposit">Deposit</option>
						<option value="withdraw">Withdraw</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Amount:</td>
				<td><input class="txt" type="text" name="amount" /></td>
			</tr>
			<tr>
				<td><input class="btn" type="submit" name="cash_submit" value="Submit" /></td>
				<td><button class="btn" type="button" onclick="parent.location='index.php?c=accountpage'">Cancel</button></td>
			</tr>
		</table>
	</form>
</div>
</div>
 </div>
 </div>
<?php include 'views/footer.php' ?>
