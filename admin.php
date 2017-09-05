<!DOCTYPE HTML>	
<?php session_start(); ?>
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
		<a href="admin.php"><div id="news">News</div></a>
		<a href="index.php"><div id="logout" onclick=log(); >Logout</div></a>
	</div>
	<form id="enterNews" method="POST" action="admin.php" name="enterNews">
	<div id="titleNews" >Enter the News</div>
	<input type="text" name="universityName" id="universityName"placeholder="Enter University" style=" margin-top:20px; width=100px; height:30px; margin-left:80px;"/>
	<textarea id="news" name="newsText" style="color:black; margin-top:30px;display:block; width:600px; height:500px; margin-left:80px;">
	</textarea>
	<input type="submit" name="newsButton" id="newsButton" style="background:white; margin-left:350px; margin-top:20px; width:80px; heigth:100px;"/>
	</form>
	<?php
	$_SESSION['login']=3;
	if(isset($_POST['newsButton']))
	{
		$uni=$_POST['universityName'];
		$news=$_POST['newsText'];
		
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '';
		$db='studyarchive';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
		if(! $conn ) {
		die('Could not connect: ' . mysql_error());
		}
   
		$sql = "INSERT INTO student VALUES( '$uni', '$news')";
		mysql_select_db($db);
		$retval = mysql_query( $sql, $conn );
		if($retval)
		{
			echo"<script>
						$(document).ready(function(){
						document.getElementById('dia').innerHTML='News inserted in database';
						$('#dia').fadeIn(2000);
						$('#dia').fadeOut(3000);
						});
						</script>";
		}	
		else
		{
			echo"<script>
						$(document).ready(function(){
						document.getElementById('dia').innerHTML='Could not insert in database';
						$('#dia').fadeIn(2000);
						$('#dia').fadeOut(3000);
						});
						</script>";
		}	
			
	}
	?>
	
	
</body>
</html>