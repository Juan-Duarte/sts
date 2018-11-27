<?php include_once 'header.php'; ?>

<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span> Account Password</h2>
	<?php if ( $errors !== false ): ?>
	<?php foreach ($errors as $e ): ?>
	<p class="red"><?=$e?></p>
	<?php endforeach; ?>
	<?php endif; ?>
   </div>
   <div id="service_pan">
	<form action="index.php?c=register&e=submit" method="post" name="register_password">
	<table>
		<tr>
			<td>Account Password</td>
			<td><input class="txt" type="password" required name="password" /></td>
		</tr>
		<tr>
			<td>Confirm Password</td>
			<td><input class="txt" type="password" required name="confirm"/></td>
		</tr>
		<tr>
			<td><button class="btn" type="button" onclick="parent.location='index.php?c=register&e=deposit'">Back</button></td>
			<td><input class="btn" name="password_submit" type="submit" value="Create" /></td>
			<td><button class="btn" type="button" onclick="parent.location='index.php?c=register&e=cancel'">Cancel</button></td>
		</tr>
	</table>
	</form>
   </div>
  </div>
 </div>
</div>

<?php include_once 'footer.php'; ?>