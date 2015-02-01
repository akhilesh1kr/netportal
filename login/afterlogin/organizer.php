<?php>
session_start();
?>
<?php
$country=$_POST['country'];
$track=$_SESSION["track"];
if($country=="2") {$track=$_POST['track'];}
$choice=$_POST['idmethod'];
$con=mysql_connect("localhost", "root","") or die("Can not Connect");
mysql_select_db('raecs_mk',$con) or die("Could not Connect");
switch($choice)
{
    case "1":{
	$paperid=$_POST['idnumber'];	
	$query=mysql_query("select * from authors where paperid=$paperid");
	$nrows=mysql_num_rows($query);
	if($nrows==0)
	{
	die ("No such paper exist, try again with correct details");
	}
	else
	{			
	echo "<table border=\"1\">";
	
	echo " <tr>\n";
	echo "  <td>Paper-ID</td>\n";
	echo "  <td>First Name</td>\n";
	echo "  <td>e-mail ID</td>\n";
	echo "  <td>Track</td>\n";
	echo "  <td>Paper Submitted</td>\n";
	echo "  <td>Status</td>\n";	
	echo "  <td>Final Result</td>\n";	
	echo "  <td>Review Report</td>\n";
	echo " </tr>\n";
	
	while ($row= mysql_fetch_array($query)) {
		$fname=$row['fname'];
		$email=$row['email'];
		$status=$row['status'];	
		$decision=$row['decision'];	
		$trak=$row['track'];	
		echo " <tr>\n";
		echo "  <td>$paperid</td>\n";
		echo "  <td>$fname</td>\n";
		echo "  <td>$email</td>\n";		
		echo "  <td>$trak</td>\n";		
		echo "  <td><a href='download.php?id=$paperid'>Paper</a></td>\n";
		echo "  <td>$status</td>\n";	
		echo "  <td>$decision</td>\n";
		echo "  <td><a href='downloadreport.php?id=$paperid'>Review Report</a></td>\n";
		echo " </tr>\n";		
		$count++ ;
	} // end WHILE	
	echo "</table><br/><br/>";	
	}
	break;
	}
	
	case "2":{
	$paperid=$_POST['result'];	
	$decision=$_POST['decision'];	
	$query=mysql_query("select track from authors where paperid=$paperid");
	$nrows=mysql_num_rows($query);
	if($nrows==0)
	{
	echo ("No such paper exist, come again with correct details");
	}
	else{
			$row = mysql_fetch_row($query);
			$dbtrack=$row[0];
			if($dbtrack==$track || $country=="2")
			{
			if(isset($_POST['submit']) && $_FILES['userfile']['size'] > 0)
			{
				$rfileName = $_FILES['userfile']['name'];
				$rtmpName  = $_FILES['userfile']['tmp_name'];
				$rfileSize = $_FILES['userfile']['size'];
				$rfileType = $_FILES['userfile']['type'];
				$fp      = fopen($rtmpName, 'r');
				$rcontent = fread($fp, filesize($rtmpName));
				$rcontent = addslashes($rcontent);
				fclose($fp);

				if(!get_magic_quotes_gpc())
				{
				$rfileName = addslashes($rfileName);
				}
			}
			
			$query=mysql_query("UPDATE authors SET decision='$decision', report='$rcontent', rfilename='$rfileName', 
			rfilesize='$rfileSize', rfiletype='$rfileType' WHERE paperid='$paperid';");	
			if(mysql_errno()){
			echo "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing <br>\n$query\n<br>";}			
			else die ("Result posted for the paper");
			}	
			else die ("You are not authorized to take decision for this Paper");
			}	
	break;
	}	
	
	case "3":{
	if($track=="ALL")
	{	
	$query=mysql_query("SELECT * FROM authors");
	$nrows=mysql_num_rows($query);
	if($nrows==0)
	{		
	die ("User does not exist");
	}
	else
	{			
	echo "<table border=\"1\">";	
	echo " <tr>\n";
	echo "  <td>Paper-ID</td>\n";
	echo "  <td>First Name</td>\n";
	echo "  <td>e-mail ID</td>\n";
	echo "  <td>Track</td>\n";
	echo "  <td>Paper Submitted</td>\n";
	echo "  <td>Status</td>\n";	
	echo "  <td>Final Result</td>\n";	
	echo "  <td>Review Report</td>\n";
	echo " </tr>\n";	
	while ($row= mysql_fetch_array($query)) {
		$paperid=$row['paperid'];
		$fname=$row['fname'];
		$email=$row['email'];
		$trak=$row['track'];	
		$status=$row['status'];	
		$decision=$row['decision'];	
		echo " <tr>\n";
		echo "  <td>$paperid</td>\n";
		echo "  <td>$fname</td>\n";
		echo "  <td>$email</td>\n";	
		echo "  <td>$trak</td>\n";	
		echo "  <td><a href='download.php?id=$paperid'>Paper</a></td>\n";
		echo "  <td>$status</td>\n";	
		echo "  <td>$decision</td>\n";
		echo "  <td><a href='downloadreport.php?id=$paperid'>Review Report</a></td>\n";
		echo " </tr>\n";		
		$count++ ;
	} 	
	echo "</table><br/><br/>";	
	}
	}	
	else
	{
	$query=mysql_query("SELECT * FROM authors where track LIKE '$track'");
	$nrows=mysql_num_rows($query);
	if($nrows==0)
	{		
	die ("User does not exist");
	}
	else
	{			
	echo "<table border=\"1\">";	
	echo " <tr>\n";
	echo "  <td>Paper-ID</td>\n";
	echo "  <td>First Name</td>\n";
	echo "  <td>e-mail ID</td>\n";
	echo "  <td>Track</td>\n";
	echo "  <td>Paper Submitted</td>\n";
	echo "  <td>Status</td>\n";	
	echo "  <td>Final Result</td>\n";	
	echo "  <td>Review Report</td>\n";
	echo " </tr>\n";
	
	while ($row= mysql_fetch_array($query)) {
		$paperid=$row['paperid'];
		$fname=$row['fname'];
		$email=$row['email'];
		$status=$row['status'];	
		$decision=$row['decision'];	
		$trak=$row['track'];	
		echo " <tr>\n";
		echo "  <td>$paperid</td>\n";
		echo "  <td>$fname</td>\n";
		echo "  <td>$email</td>\n";		
		echo "  <td>$trak</td>\n";	
		echo "  <td><a href='download.php?id=$paperid'>Paper</a></td>\n";
		echo "  <td>$status</td>\n";	
		echo "  <td>$decision</td>\n";
		echo "  <td><a href='downloadreport.php?id=$paperid'>Review Report</a></td>\n";
		echo " </tr>\n";		
		$count++ ;
	} // end WHILE	
	echo "</table><br/><br/>";	
	}	
	}
	break;
	}
}	

?>
<?php
mysql_close($con);
?>
