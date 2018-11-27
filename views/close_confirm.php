<?php include_once 'views/header.php'; ?>
<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span> Close Account</h2>
	<p>We're sorry to see you go. Enter your password below to close your account.
	<br />When you close your account, all your stocks will be sold at market value and your funds will be released to you.</p>
	<?php if ( $errors !== false ): ?>
	<?php foreach ($errors as $e ): ?>
	<p class="red"><?=$e?></p>
	<?php endforeach; ?>
	<?php endif; ?>
   </div>
   <div id="service_pan">
	<form action="index.php?c=accountmaintenance&e=close" method="post" name="close_account">
		<table class="portfolio">
			<tr>
				<td>Password:</td>
				<td><input class="txt" type="password" required name="password" /></td>
			</tr>
			<tr>
				<td><button class="btn" type="button" onclick="parent.location='index.php?c=accountmaintenance'">Cancel</button></td>
				<td><input class="btn" type="submit" name="close_submit" value="Close" /></td>
			</tr>
		</table>
	</form>
   </div>
  </div>
 </div>
</div>

<?php include_once 'views/footer.php'; ?>