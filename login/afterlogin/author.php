<?php>
session_start();
?>
<?php
$choice=$_POST['choice'];
$paperid=$_SESSION['authorpaperid'];
$con=mysql_connect("localhost", "root","") or die("Can not Connect");
mysql_select_db('raecs_mk',$con) or die("Could not Connect");
switch($choice){
    case "1":{		
	$query=mysql_query("select status,decision,report from authors where paperid=$paperid");
	$nrows=mysql_num_rows($query);	
	$row= mysql_fetch_array($query);
	$status=$row['status'];	
	$decision=$row['decision'];	
	if($status=="active")
	{
	if($decision!="pending")
	{
	echo "<a href='downloadreport.php?id=$paperid'>Download Report</a>\n";		
	}
	else
	{
	echo ("Paper is under review, once reviewed results will be uploaded");		
	}
	}
	else
	{
	echo ("Paper is Withdrawn");	
	}
	break;
		}		
	case "2":{	
			$withdrawn="withdrawn";
			$query=mysql_query("UPDATE authors SET status='$withdrawn' WHERE paperid='$paperid';");	
			if(mysql_errno()){
			echo "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing <br>\n$query\n<br>";
							}						
			else die ("Your paper is withdrawn successfully");
			break;
			}		
	}			

?>
<?php
mysql_close($con);
?>
