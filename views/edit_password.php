<?php include_once 'header.php'; ?>

<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span> Change Password</h2>
	<?php if ( $errors !== false ): ?>

			<?php foreach ($errors as $e ): ?>
			<p class="red"><?=$e?></p>
			<?php endforeach; ?>
	<?php endif; ?>
	</div>
	<div id="service_pan">
	<form action="index.php?c=accountmaintenance&e=viewinfo" method="post" name="edit_password">
	<table>
		<tr>
			<td>Current Password</td>
			<td><input class="txt" type="password" required name="current" /></td>
		</tr>
		<tr>
			<td>New Password</td>
			<td><input class="txt" type="password" required name="password" /></td>
		</tr>
		<tr>
			<td>Confirm Password</td>
			<td><input class="txt" type="password" required name="confirm"/></td>
		</tr>
		<tr>
			<td><button class="btn" type="button" onclick="parent.location='index.php?c=accountmaintenance'">Cancel</button></td>
			<td><input class="btn" name="pw_submit" type="submit" value="Save" /></td>
		</tr>
	</table>
	</form>
</div>
 </div>
 </div>
</div>

<?php include_once 'footer.php'; ?>
