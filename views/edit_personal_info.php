<?php include_once 'header.php'; ?>

<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span>Edit Personal Information</h2>
		<?php if ( $errors !== false ) : ?>
			<?php foreach ( $errors as $e ) : ?>
			<p class="red"><?=$e?></p>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<div id="service_pan">
	<form action="index.php?c=accountmaintenance&e=viewinfo" method="post" name="edit_personal_info">
		<table>
			<tr>
				<td>Email</td>
				<td><input class="txt" name="email" required type="email" value="<?=htmlspecialchars($account->email)?>" /></td>
			</tr>
			<tr>
				<td>First name</td>
				<td><input class="txt" name="first_name" required type="text" value="<?=htmlspecialchars($account->first_name)?>" /></td>
			</tr>
			<tr>
				<td>Middle name</td>
				<td><input class="txt" name="middle_name" type="text" value="<?=htmlspecialchars($account->middle_name)?>" /></td>
			</tr>
			<tr>
				<td>Last name</td>
				<td><input class="txt" name="last_name" required type="text" value="<?=htmlspecialchars($account->last_name)?>" /></td>
			</tr>
			<tr>
				<td>Date of birth</td>
				<td><input class="txt" name="dob" required type="text" value="<?=htmlspecialchars($dob)?>" /></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><input class="txt" name="address" required type="text" value="<?=htmlspecialchars($account->address)?>" /></td>
			</tr>
			<tr>
				<td>City</td>
				<td><input class="txt" name="city" required type="text" value="<?=htmlspecialchars($account->city)?>" /></td>
			</tr>
			<tr>
				<td>State</td>
				<td><input class="txt" name="state" required type="text" value="<?=htmlspecialchars($account->state)?>" /></td>
			</tr>
			<tr>
				<td>Zip Code</td>
				<td><input class="txt" name="zip" required type="text" value="<?=htmlspecialchars($account->zip)?>" /></td>
			</tr>
			<tr>
				<td>Home Phone</td>
				<td><input class="txt" name="home_phone" type="tel" value="<?=htmlspecialchars($account->home_phone)?>" /></td>
			</tr>
			<tr>
				<td>Cell Phone</td>
				<td><input class="txt" name="cell_phone" type="tel" value="<?=htmlspecialchars($account->cell_phone)?>" /></td>
			</tr>
			<tr>
				<td>Marital Status</td>
				<td>
					<select class="txt" name="marital_status">
						<option value="single" <?=($account->marital_status == 0 ? 'selected' : '')?>>Single</option>
						<option value="married" <?=($account->marital_status == 1 ? 'selected' : '')?>>Married</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><button class="btn" type="button" onclick="parent.location='index.php?c=accountmaintenance'">Cancel</button></td>
				<td colspan="2"><input class="btn" type="submit" name="pi_submit" value="Save" /></td>
			</tr>
			</table>
		</form>
		</div>
	</div>
 </div>
</div>

<?php include_once 'footer.php'; ?>
