<?php
session_start();
	
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
		$i=0;
		if(! $conn ) {
		die('Could not connect: ' . mysql_error());
		}
		$sql = "SELECT DISTINCT Course FROM studymaterial WHERE University = '".$university."' AND Branch='".$branch."'";
		mysql_select_db($db);
		$retval = mysql_query( $sql, $conn );
		while($row=mysql_fetch_array($retval,MYSQL_ASSOC))
		{
			$course=$row['Course'];
			$response[$i]=$course;
			$i++;			
		}	
			echo json_encode($response);
	}   
	?>