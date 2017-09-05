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
				location.reload();
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
	<div id="sign">
	<table border="0">
		<form name="signForm" id="formSign" method="post" action="index.php">
		
		
			<tr><td><div class="signUp" onclick=signup(); ><p>SignUp</p></div></td><td><div class="logIns" onclick=login();><p>LogIn</p></div></td></tr> 
			<tr><td colspan="2"><input id="first" type="text" name="first" placeholder="First Name" required /></td></tr>
			<tr><td colspan="2"><input id="last" type="text" name="last" placeholder="Last Name" required /></td></tr>
			<tr><td colspan="2"><input id="email1" type="text" name="e-mail" placeholder="E-mail" required /></td></tr>
			<tr><td colspan="2"><input id="password1" type="password" name="password" placeholder="Password" required /></td></tr>
			<tr><td colspan="2">
				<select required id="selects" name="selectName" >
					<option value="" selected disabled hidden>Select Your University</option>
					<option id="op1" value="VTU">VTU</option>
					<option id="op2" value="VIT">VIT</option>
					<option id="op3" value="NIT">NIT</option>
				</select>
				</td></tr>
			<tr><td colspan="2"><input id="button1" type="submit" name="button1" value="SignUp" required /></td></tr>
					
		</form>
	</table>
	</div>
	
	<div id="login">
	<table border="0">
		<form name="loginForm" method="post" action="index.php">
			<tr><td><div class="signUp" onclick=signup(); ><p>SignUp</p></div></td><td><div class="logIns" onclick=login();><p>LogIn</p></div></td></tr> 
			<tr><td colspan="2"><input id="email2" type="text" name="e-mail" placeholder="E-mail" required /></td></tr>
			<tr><td colspan="2"><input id="password2" type="password" name="password" placeholder="Password" required /></td></tr>
			<tr><td colspan="2"><input id="button2" type="submit" name="button2" value="Login" required /></td></tr>
		</form>
	</table>
	</div>
	<!--php-->
	<?php		
		//logout request from ajax
		if(isset($_POST['func']))
		{
			session_destroy();	
			header("Refresh:0");			
		}
		if(isset($_POST['button1']))
		{		
			$first=$_POST["first"];
			$last=$_POST["last"];
			$email=$_POST["e-mail"];
			$password=$_POST['password'];
			$option=$_POST['selectName'];
			
			//insetion
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpass = '';
			$db='studyarchive';
			$conn = mysql_connect($dbhost, $dbuser, $dbpass);
			mysql_select_db($db);
			if(! $conn ) {
			die('Could not connect: ' . mysql_error());
			}
			
			$sqlCheck = "SELECT * FROM signup WHERE E_mail='".$email."'";
			$retvalCheck= mysql_query( $sqlCheck, $conn);
	
			if($row=mysql_fetch_array($retvalCheck,MYSQL_ASSOC))
			{
				echo"<script>
				$(document).ready(function(){
				document.getElementById('dia').innerHTML='Email Already present!';
				$('#dia').fadeIn(2000);
				$('#dia').fadeOut(3000);
				});
				</script>";
			}
			else
			{
				//verify email
				$atpos=strpos($email,"@");
				$dotpos=strpos($email,".");
					if ($atpos<1 || $dotpos<$atpos+2 || $dotpos+2>=strlen($email)) {
					echo"<script>
					$(document).ready(function(){
					document.getElementById('dia').innerHTML='Email Invalid!';
					$('#dia').fadeIn(2000);
					$('#dia').fadeOut(3000);
					});
					</script>";
					
					}
					else
					{
						if(strpos($email,'.com')===false && (strpos($email,".in")===false))
						{
						echo"<script>
						$(document).ready(function(){
						document.getElementById('dia').innerHTML='Email format not accepted!';
						$('#dia').fadeIn(2000);
						$('#dia').fadeOut(3000);
						});
						</script>";
						}
						else
						{
						$sql = "INSERT INTO signup(First,Last,E_mail,Password,University) VALUES( '$first', '$last' , '$email' , '$password' , '$option' )";     
						$retval = mysql_query( $sql, $conn );
   
						if(! $retval ) {
						echo"<script>
						$(document).ready(function(){
						document.getElementById('dia').innerHTML='Signup UnSuccessfull';
						$('#dia').fadeIn(2000);
						$('#dia').fadeOut(3000);
						});
						</script>";
						}
						else{
						echo"<script>
						$(document).ready(function(){
						document.getElementById('dia').innerHTML='Done! Login To Continue';
						$('#dia').fadeIn(2000);
						$('#dia').fadeOut(3000);
						});
						</script>";
						}
						}
					}
			}
 			mysql_close($conn);

		}
		if(isset($_POST['button2']))
		{
			$email=$_POST["e-mail"];
			$password=$_POST["password"];
				
			//insertion
			$dbhost = 'localhost';
			$dbuser = 'root';
			$dbpass = '';
			$db='studyarchive';
			$conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
			if(! $conn ) {
			die('Could not connect: ' . mysql_error());
			}
   
			$sql = "SELECT * FROM signup WHERE E_mail='".$email."' AND Password='".$password."' ";
			mysql_select_db($db);
			$retval = mysql_query( $sql, $conn );
   
		if(! $retval ) {
				echo"<script>
				$(document).ready(function(){
				document.getElementById('dia').innerHTML='Login UnSuccessfull!';
				$('#dia').fadeIn(2000);
				$('#dia').fadeOut(3000);
				});
				</script>";

			}
		else{
				$flag=0;
				//fetch values
				while($row=mysql_fetch_array($retval,MYSQL_ASSOC))
				{
						$flag=1;		
					
					$mail=$row['E_mail'];
					$pass=$row['Password'];
					$option=$row['University'];
					if($mail==="admin@gmail.com")
					{
						$_SESSION['login']='1';
						header("Location:http://localhost/Study%20Archive/admin.php");
					}
					else if($row)
					{
						$_SESSION['login']='1';
						$_SESSION['university']=$option;
						$_SESSION['email']=$mail;
						$_SESSION['member']=$row['Member'];
						if($row['TimeOfMembership'])
						{	
						$_SESSION['time']=$row['TimeOfMembership'];
						if((($_SESSION['member']==2)&&((time()-$_SESSION['time'])>15552000)) || (($_SESSION['member']==1)&&((time()-$_SESSION['time'])>31504000)))
							{
							$sql = "UPDATE signup SET Member=0 WHERE E_mail='".$_SESSION['email']."'";  
							$retval = mysql_query( $sql, $conn );
							$_SESSION['member']=0;
						}
						}
						header("Location:http://localhost/Study%20Archive/second.php");
					}	
				}
				if($flag==0)
				{
					echo"<script>
					$(document).ready(function(){
					document.getElementById('dia').innerHTML='Login UnSuccessfull';
					$('#dia').fadeIn(2000);
					$('#dia').fadeOut(3000);
					});
					</script>";		
				}
				

			}
 			mysql_close($conn);

		}	
    ?> 	
</body>	
</html>