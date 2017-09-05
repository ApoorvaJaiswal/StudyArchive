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
	$item_no = $_POST['item_number'];
	$item_transaction = $_POST['txn_id']; // Paypal transaction ID
	$item_price = $_POST['mc_gross']; // Paypal received amount
	$item_currency = $_POST['mc_currency']; // Paypal received currency type
	$subject="Payment Recieved";
	$headers = "From: studyarchive.com";
	$mess1="We have received your payment of $8. Congractulations on becoming our Yearly member. Enjoy Learning!";
	$mess2="We have received your payment of $5. Congractulations on becoming our Half-yearly member. Enjoy Learning!";
	$price1 = '8.00';
	$price2 = '5.00';
	$currency='USD';
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$db='studyarchive';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	mysql_select_db($db);
	if(! $conn ) {
	die('Could not connect: ' . mysql_error());
	}
	//Rechecking the product price and currency details
	if($item_price==$price1 && $item_no== '1' && $item_currency==$currency)
	{
			echo"<script>
			$(document).ready(function(){
			document.getElementById('dia').innerHTML='Subscribed for a year ';
			$('#dia').fadeIn(2000);
			$('#dia').fadeOut(3000);
			});
			</script>";
			$_SESSION['time']=time();
			$sql = "UPDATE signup SET Member=1 , TimeOfMembership='".$_SESSION['time']."' WHERE E_mail='".$_SESSION['email']."'";  //1 for yearly    
			$retval = mysql_query( $sql, $conn );
			$_SESSION['member']=1;
			mail($_SESSION['email'],$subject,$mess1,$headers);
			
	}
	else if($item_price==$price2 && $item_no== '2' && $item_currency==$currency)
	{
			echo"<script>
			$(document).ready(function(){
			document.getElementById('dia').innerHTML='Subscribed for half-year';
			$('#dia').fadeIn(2000);
			$('#dia').fadeOut(3000);
			});
			</script>";
			$_SESSION['time']=time();
			$sql = "UPDATE signup SET Member=2, TimeOfMembership='".$_SESSION['time']."' WHERE E_mail='".$_SESSION['email']."'";   //2 for half yearly
			$retval = mysql_query( $sql, $conn );
			$_SESSION['member']=2;
			mail($_SESSION['email'],$subject,$mess2,$headers);
	}
	else
	{
			echo"<script>
			$(document).ready(function(){
			document.getElementById('dia').innerHTML='Transaction UnSuccessfull';
			$('#dia').fadeIn(2000);
			$('#dia').fadeOut(3000);
			});
			</script>";
			
	}
	?>
	
	</body>
	</html>