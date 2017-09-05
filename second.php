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
	function linking(lin){
		jQuery.ajax({
			type: "POST",
			url: 'videoNpdf.php',
			data: { funcCallLink:'1', valLink : lin},
			success: function(data)
			{

			}
		});
	}
	function prev(preview){
		jQuery.ajax({
			type: "POST",
			url: 'member.php',
			data: { funcCallPreview:'1', valPreview : preview},
			success: function(data)
			{

			}
		});
	}
	
	function selectedBranch(){
		var e = document.getElementById("selectBranch");
		var branch = e.options[e.selectedIndex].value;
			jQuery.ajax({
			type: "POST",
			url: 'ret.php',
			data: {funcCall:'1', valBranch: branch},
			success:function(data)
			{				
			var data = $.parseJSON(data);
			var i;
				for(i=0;i<data.length;i++)
				{
					$(".selectCourse").append("<option id='op'"+i+" value='"+data[i]+"'>"+data[i]+"</option>");
				}
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
		<a href="second.php"><div id="dashboard">Dashboard</div></a>
		<a href="index.php"><div id="logout" onclick=log();>Logout</div></a>
	</div>
	<div id="titles"><?php echo $_SESSION['university'];?> University</div>
	<div class="container1"></div>
	<div id="latestNews" ><div class="headings">Latest News</div>
	<?php displayNews(); ?>
	</div>
	<div class="container2"></div>
	<div id="notes">
	<div class="headings">Notes</div>
	<form name="notesForm" id="formNotes" method="post" action="second.php" style="margin-top:10px; margin-bottom:20px;">
	<select required id="selectBranch" name="selectBranch" onchange=selectedBranch();>
					<option value="" selected disabled hidden>Select Your Branch</option>
					<option id="op1" value="cse">Computer Science and Engineering</option>
					<option id="op2" value="ece">Electronics and Communication Engineering</option>
	</select>
	<select required class="selectCourse" name="selectCourse">
					<option value="" selected disabled hidden>Select Your Course</option>
	</select>
	<input type="submit" id="notesButton" name="notesButton" value="Take Me There"/>
	</form>
	
	<?php
	
	if(isset($_POST['funcCall']))
	{
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '';
		$db='studyarchive';
		$university=$_SESSION['university'];
		$branch=$_POST['valBranch'];
		$conn = mysql_connect($dbhost, $dbuser, $dbpass);
		$response = array();
		$arr = array();
		$arr['res']="apple";
		echo "hello";
		$i=0;
		if(! $conn ) {
		die('Could not connect: ' . mysql_error());
		}
		$sql = "SELECT * FROM studymaterial WHERE University = '".$university."' AND Branch='".$branch."'";
		mysql_select_db($db);
		$retval = mysql_query( $sql, $conn );
		while($row=mysql_fetch_array($retval,MYSQL_ASSOC))
		{
			
			$course=$row['Course'];
			$response[$i]=$course;
			$i++;			
		}	
			echo json_encode($arr);
	}   
	function displayNews()
	{
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '';
		$db='studyarchive';
		$conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
		if(! $conn ) {
		die('Could not connect: ' . mysql_error());
		}
   
		$sql = "SELECT * FROM student WHERE University = '".$_SESSION['university']."'";
		mysql_select_db($db);
		$retval = mysql_query( $sql, $conn );
		$no=1;
		while($row=mysql_fetch_array($retval,MYSQL_ASSOC))
		{
			$news=$row['News'];
			echo $no.".  ".$news."</br>";
			$no++;
		}		
	}
	if(isset($_POST['notesButton']))
	{
		$branch=$_POST['selectBranch'];
		$course=$_POST['selectCourse'];
		$university=$_SESSION['university'];
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = '';
		$db='studyarchive';
		$flag=0;
		$i=1;
		$flag1=0;
		$conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
		if(! $conn ) {
		die('Could not connect: ' . mysql_error());
		}
   
		$sql = "SELECT * FROM studymaterial WHERE University = '".$university."' AND Branch='".$branch."' AND Course= '".$course."' ";
		mysql_select_db($db);
		$retval = mysql_query( $sql, $conn );
		?><div id="studyTitle">Study Materials</div><?php
		while($row=mysql_fetch_array($retval,MYSQL_ASSOC))
		{
			$flag=1;
			$link=$row['Link'];
			$preview=$row['Preview'];
			//$_SESSION['link']=$link;
			//$_SESSION['preview']=$preview;
			if($i<=2)
			{
			?>
			<a href="videoNpdf.php"><div class="notesDisplay"onclick="linking('<?php echo $link; ?>')">Study Material <?php echo $i;?></div></a>
			<?php
			}
			else
			{
				if($_SESSION['member']==0 && !(isset($_SESSION['time'])))
				{
				?>
				<a href="member.php"><div class="lockDisplay" onclick="prev('<?php echo $preview;?>')">Study Material <?php echo $i;?></div></a>
				<?php
				}
				else if(isset($_SESSION['time']) && ((($_SESSION['member']==2)&&((time()-$_SESSION['time'])<=15552000)) || (($_SESSION['member']==1)&&((time()-$_SESSION['time'])<=31504000))))
				{
				?>
				<a href="videoNpdf.php"><div class="notesDisplay" onclick="linking('<?php echo $link; ?>')">Study Material <?php echo $i;?></div></a>
				<?php
				}
				else { //membership expired
				$flag1=1;
					?>
				<a href="member.php"><div class="lockDisplay" onclick="prev('<?php echo $preview;?>')">Study Material <?php echo $i;?></div></a>
				<?php
				}
			}
			$i++;
			if($i%5==0)
			{
				echo "</br></br></br></br>";
			}
			
		}
		if($flag1==1)
		{
			echo"<script>
				$(document).ready(function(){
				document.getElementById('dia').innerHTML='Membership Expired!';
				$('#dia').fadeIn(2000);
				$('#dia').fadeOut(3000);
				});
				</script>";
				$_SESSION['preview']=$row['Preview'];
		}
		if($flag==0)
		{
			echo"<script>
		$(document).ready(function(){
		document.getElementById('dia').innerHTML='Notes Yet to be uploaded';
		$('#dia').fadeIn(2000);
		$('#dia').fadeOut(3000);
		});
		</script>";
		}
	}
	if($_SESSION['login']=='1')
	{
		echo"<script>
		$(document).ready(function(){
		document.getElementById('dia').innerHTML='Login Successfull!';
		$('#dia').fadeIn(2000);
		$('#dia').fadeOut(3000);
		});
		</script>";
		$_SESSION['login']='2';	//not just redirected.. already on the page so donot show this login successfull everytime!!			
	}
	
	
	?>
	</div>
</body>
</html>