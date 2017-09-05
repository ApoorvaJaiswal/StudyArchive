<!doctype html>
<?php session_start();?>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="index.css"/>
	<script type="text/javascript" src="jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="index.js"></script>
	<script>
	function log(){
			jQuery.ajax({
			type: "POST",
			url: 'index.php',
			data: {func:'1'},
			success:function(data)
			{
			}
		});
	}
	</script>
</head>
<body>
	
	<div id="dia">Signup Successfull</div>
	<div id="logo">
	<img src="logo.png" width="50px" height="50px"/>
		<a href="index.php">Study Archive</a>
	</div>
	<div id="topPart">
		<a href="index.php"><div id="home">Home</div></a>
		<a href="#About Us"><div id="about">About Us</div></a>
		<a href="#Contact"><div id="contact">Contact</div></a>
		<?php
		if(isset($_SESSION['login']) && ($_SESSION['login']!=3))
		{
			$_SESSION['login']='2';
			?>
		<a href="second.php"><div id="dashboard">Dashboard</div></a>
		<?php
		}
		?>
		<?php
		if(isset($_SESSION['login']) && ($_SESSION['login']==3))
		{
			$_SESSION['login']='2';
			?>
		<a href="admin.php"><div id="dashboard">News</div></a>
		<?php
		}
		?>
		<?php
		if(isset($_SESSION['login']))
		{
			?>
		<a href="index.php"><div id="logout" onclick=log();>Logout</div></a>
		<?php
		}
		?>
		
	</div>	
	<?php
		if(isset($_POST['funcCallPreview']))
		{
			$_SESSION['link']=$_POST['valPreview'];
		}
	
		$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
		$paypal_id='jais.appy19960407-facilitator@gmail.com'; // Business email ID
	?>
	<a href="videoNpdf.php"><div id="preview" class="prev">Preview</div></a>
	<div id="member" class="prev">
		<div id="memberTitle">Membership Plans</div>
		
		<div id="yearly" class="year">Yearly Membership for $8 only</div>
		<form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal1" id="yearlyForm"class="year">
		<input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="item_name" value="Yearly Payment">
		<input type="hidden" name="item_number" value="1">
		<input type="hidden" name="credits" value="510">
		<input type="hidden" name="userid" value="1">
		<input type="hidden" name="amount" value="8">
		<input type="hidden" name="no_shipping" value="1">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="handling" value="0">
		<input type='hidden' name='rm' value='2'>
		<input type="hidden" name="cancel_return" value="http://localhost/Study%20Archive/cancel.php">
		<input type="hidden" name="return" value="http://localhost/Study%20Archive/return.php">
		<input type="hidden" name="notify_url" value="http://localhost/Study%20Archive/return.php">
		<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
	
		<div id="halfYearly" class="half">Half-Yearly Membership for $5 only</div>
		<form action="<?php echo $paypal_url; ?>" method="post" name="frmPayPal2" id="halfYearlyForm" class="half">
		<input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="item_name" value="Half-Yearly Payment">
		<input type="hidden" name="item_number" value="2">
		<input type="hidden" name="credits" value="510">
		<input type="hidden" name="userid" value="1">
		<input type="hidden" name="amount" value="5">
		<input type="hidden" name="no_shipping" value="1">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="handling" value="0">
		<input type='hidden' name='rm' value='2'>
		<input type="hidden" name="cancel_return" value="http://localhost/Study%20Archive/cancel.php">
		<input type="hidden" name="return" value="http://localhost/Study%20Archive/return.php">
		<input type="hidden" name="notify_url" value="http://localhost/Study%20Archive/return.php">
		<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
	
</body>
</html>