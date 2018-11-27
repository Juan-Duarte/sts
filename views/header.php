<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$pageTitle?></title>
<link href="css/styles.css" rel="stylesheet" type="text/css" media="all" />
<?php if ( isset($tradePage) ) :?>
<script type="text/javascript" src="views/scripts/trade_form.js"></script>
<?php endif; ?>
<?php if ( isset($homePage) ) : ?>
<!--  STEP ONE: insert path to SWFObject JavaScript -->
<script type="text/javascript" src="js/swfobject/swfobject.js"></script>

<!--  STEP TWO: configure SWFObject JavaScript and embed CU3ER slider -->
<script type="text/javascript">
		var flashvars = {};
		flashvars.xml = "config.xml";
		flashvars.font = "font.swf";
		var attributes = {};
		attributes.wmode = "transparent";
		attributes.id = "slider";
		swfobject.embedSWF("cu3er.swf", "cu3er-container", "800", "360", "9", "expressInstall.swf", flashvars, attributes);
</script>
<?php endif; ?>
</head>

<body>
<div id="head">
 <div id="head_cen">
   <?php $headClass = isset($homePage) ? 'head_height' : 'head_pad' ?>
  <div id="head_sup" class="<?=$headClass?>">
  <?php if ( isset($homePage) ): ?>
  <img src="images/bannerBg.png" alt="" class="ban_bg" />
  <?php endif; ?>
  <form action="http://finance.yahoo.com/q" target="_blank">
   <p class="search">
    <label>QUOTES</label>
    <input name="s" type="text" class="txt" />
    <input type="submit" class="btn" value="GET QUOTES" />
   </p>
  </form>
    <h1 class="logo"><a href="index.php">Ultimate STS</a></h1>
    <ul>
	 <?php if ( isset($homePage) ): ?>
	 <li><a class="active" href="index.php">Home</a></li>
	 <li><a class="active" href="index.php?c=register">Register</a></li>
	 <?php elseif ( isset($account) ): ?>
	 <li><a class="active" href="index.php?c=accountpage">Account</a></li>
	 <li><a class="active" href="index.php?c=accountmaintenance">Maintenance</a></li>
	 <li><a class="active" href="index.php?c=transactionhistory">History</a></li>
	 <li><a class="active" href="index.php?c=trade">Trade</a></li>
	 <li><a class="active" href="index.php?c=cash">Cash</a></li>
	 <li><a title="Market News" href="http://finance.yahoo.com/news/category-stocks/" target="_blank" class="active">News</a></li>
	 <li><a class="active" href="index.php?c=logout">Logout</a></li>

	 <?php endif; ?>
   </ul>
   <?php if ( isset($homePage) ) : ?>
   <div id="cu3er-container">
    <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>
   </div>
   <?php endif; ?>
  </div>
 </div>
</div>
