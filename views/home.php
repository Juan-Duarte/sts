<?php include_once 'header.php'; ?>


<div id="content">
 <div id="content_cen">
  <div id="content_sup">
   <div id="ct_pan">
    <p>Welcome the Ultimate Stock Trading System.
	<br />Already have an account? Login here:
	<br />Don't have an account? <a href="index.php?c=register">register now</a>
	<?php if ( $errors !== false ): ?>
	<?php foreach ($errors as $e ): ?>
	<span class="red"><?=$e?></span><br />
	<?php endforeach; ?>
	<?php endif; ?></p>
	<form method="post" action="index.php?c=accountpage">
			<table>
				<tr>
					<td><label>EMAIL</label></td>
					<td><input type="text" required name="email" /></td>
				</tr>
				<tr>
					<td><label>PASSWORD</label></td>
					<td><input type="password" required name="password" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="login_submit" value="Login" class="btn" /></td>
				</tr>
			</table>
		</form>
   </div>
   <div id="welcom_pan">
    <h2><span>USTS</span>Market News</h2>
    <div>
    <p>&nbsp;</p>
   </div>
   <div id="blog">
   <div>
                <form action="http://finance.search.yahoo.com/search" target="_blank">
                        <input name="p" type="text">
                        <input type="submit" value="Search Finance">
                </form>
        </div> 
	<ul>
   <?php 
	$count = 0;			
	foreach ($data->channel->item as $item):
		if ($count > 9) break;
	?>
	<li>
		<h5><a href="<?=$item->link ?>"><?=$item->title?></a></h5>
		<?php
			// clean out the image and bullshit
			$pieces = explode('</a>', $item->description);
			if ( count($pieces) > 1 )
				$text = $pieces[1];
			else
				$text = $item->description;
		?>
		<p><?=$text?>
		<!--<p><?=$item->description ?></p>-->
	</li>
	<?php 
		$count+= 1;
	endforeach; 
	?>
	</ul>
   </div>
  </div>
 </div>
</div>

<?php include_once 'footer.php'; ?>
