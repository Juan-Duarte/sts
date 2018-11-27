<?php include_once 'header.php'; ?>


<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span> Personal Information</h2>
	<p>Fields marked with a <span class="red">*</span> are required.</p>
	<?php if ( $errors !== false ): ?>
	<?php foreach ($errors as $e ): ?>
	<p class="red"><?=$e?></p>
	<?php endforeach; ?>
	<?php endif; ?>
   </div>
   <div id="service_pan">
	<form action="index.php?c=register&e=beneficiaryinfo" method="post" name="register_personal_info">
	<table>
		<tr>
			<td>Email<span class="red">*</span></td>
			<td><input class="txt" name="email" required type="email" value="<?=$data['pi']['email']?>" /></td>
		</tr>
		<tr>
			<td>First name<span class="red">*</span></td>
			<td><input class="txt" name="first_name" required type="text" value="<?=htmlspecialchars($data['pi']['first_name'])?>" /></td>
		</tr>
		<tr>
			<td>Middle name</td>
			<td><input class="txt" name="middle_name" type="text" value="<?=htmlspecialchars($data['pi']['middle_name'])?>" /></td>
		</tr>
		<tr>
			<td>Last name<span class="red">*</span></td>
			<td><input class="txt" name="last_name" required type="text" value="<?=htmlspecialchars($data['pi']['last_name'])?>" /></td>
		</tr>
		<tr>
			<td>Date of birth<span class="red">*</span><br /><span class="small">Enter this in MM/DD/YYYY format please</span></td>
			<td><input class="txt" name="dob" required type="text" value="<?=htmlspecialchars($data['pi']['dob'])?>" /></td>
		</tr>
		<tr>
			<td>Address<span class="red">*</span></td>
			<td><input class="txt" name="address" required type="text" value="<?=htmlspecialchars($data['pi']['address'])?>" /></td>
		</tr>
		<tr>
			<td>City<span class="red">*</span></td>
			<td><input class="txt" name="city" required type="text" value="<?=htmlspecialchars($data['pi']['city'])?>" /></td>
		</tr>
		<tr>
			<td>State<span class="red">*</span><br /><span class="small">Enter the two character abbreviation</span></td>
			<td><input class="txt" name="state" required type="text" value="<?=htmlspecialchars($data['pi']['state'])?>" /></td>
		</tr>
		<tr>
			<td>Zip Code<span class="red">*</span></td>
			<td><input class="txt" name="zip" required type="text" value="<?=htmlspecialchars($data['pi']['zip'])?>" /></td>
		</tr>
		<tr>
			<td>Home Phone</td>
			<td><input class="txt" name="home_phone" type="tel" value="<?=htmlspecialchars($data['pi']['home_phone'])?>" /></td>
		</tr>
		<tr>
			<td>Cell Phone</td>
			<td><input class="txt" name="cell_phone" type="tel" value="<?=htmlspecialchars($data['pi']['cell_phone'])?>" /></td>
		</tr>
		<tr>
			<td>Marital Status<span class="red">*</span></td>
			<td>
				<select class="txt" name="marital_status">
					<option value="single" <?=($data['pi']['marital_status'] == 'single' ? 'selected' : '')?>>Single</option>
					<option value="married" <?=($data['pi']['marital_status'] == 'married' ? 'selected' : '')?>>Married</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><input class="btn" type="submit" name="pi_submit" value="Save" /></td>
			<td><button class="btn" type="button" onclick="parent.location='index.php?c=register&e=cancel'">Cancel</button></td>
		</tr>
	</table>
	</form>
   </div>
  </div>
 </div>
</div>

<?php include_once 'footer.php'; ?>
