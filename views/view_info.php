<?php include_once 'views/header.php'; ?>
<div id="content">
 <div id="content_cen">
  <div id="content_sup" class="head_pad">
   <div id="welcom_pan">
    <h2><span>USTS</span> Account Maintenance</h2>
   </div>
   <div id="service_pan">
	<table class="portfolio">
		<tr>
			<th colspan="2">Personal Info - <a href="index.php?c=accountmaintenance&e=editpersonalinfo">Edit</a></th>
		</tr>
		<tr>
			<td>Name:</td>
			<td><?=$name?></td>
		</tr>
		<tr>
			<td>Date of Birth</td>
			<td><?=$dob?></td>
		</tr>
		<tr>
			<td>Address</td>
			<td>
				<?=$account->address?>
				<br />
				<?=$line2?>
			</td>
		</tr>
		<tr>
			<td>Home Phone</td>
			<td><?=$account->home_phone?></td>
		</tr>
		<tr>
			<td>Cell Phone</td>
			<td><?=$account->cell_phone?></td>
		</tr>
		<tr>
			<td>Marital Status</td>
			<td><?=$marital_status?></td>
		</tr>
	</table>
	
	<table class="portfolio">
		<tr>
			<th colspan="2">Beneficiary Info - <a href="index.php?c=accountmaintenance&e=editbeneficiaryinfo">Edit</a></th>
		</tr>
		<tr>
			<td>Beneficiary</td>
			<td><?=$account->beneficiary?></td>
		</tr>
	</table>
	
	<table class="portfolio">
		<tr><th>Account Password - <a href="index.php?c=accountmaintenance&e=editpassword">Edit</a></th></tr>
		<tr><td><a href="index.php?c=accountmaintenance&e=closeconfirm">Close Account</a></td></tr>
	</table>
   </div>
  </div>
 </div>
</div>

<?php include_once 'views/footer.php'; ?>