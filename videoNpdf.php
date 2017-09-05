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
	function clicks()
	{
		var ele= document.getElementById("disp");
		if(ele.paused)
			ele.play();
		else
			ele.pause();
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
	if(isset($_POST['funcCallLink']))
	{
		$_SESSION['link']= $_POST['valLink'];
		if(strpos($_SESSION['link'],".pdf"))
			$_SESSION['type']=1;
		else
			$_SESSION['type']=0;
	}
	?>
	<?php
	if(strpos($_SESSION['link'],".pdf"))
	{
		?>
		<object id="disp" data="<?php echo $_SESSION['link'];?>" width="1000px" height="750px" style="margin-top:20px; margin-left:130px; float:left; clear:both; color:#ffffff">
	</object>
		<?php
	}
	else
	{
		?>
		<video id="disp" onclick=clicks(); src="<?php echo $_SESSION['link'];?>" width="1000px" height="700px" style="margin-top:20px; margin-left:130px; float:left; clear:both; color:#ffffff" controls>
	</video>
	<?php
	}
	?>
	
	</body>
	</html>