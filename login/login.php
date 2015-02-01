<?php
session_start();
$type=$_POST['type'];
$username=$_POST['username'];
$password=$_POST['password'];
//if($type=="1")
$con=mysql_connect("localhost", "root","") or die("Can not Connect");
mysql_select_db('raecs_mk',$con) or die("Could not Connect");
switch($type)
{
case "1":
{
if($username && $password )
{

$query=mysql_query("SELECT password FROM loginauthor WHERE loginid='$username'");
$nrows=mysql_num_rows($query);
if($nrows!=1)
{
die ("User does not exist");
}
else
{	
$row = mysql_fetch_row($query);
//$dbname=$row[0];
$dbpswd=$row[0];
if($password==$dbpswd)
{
echo "Login success";
$_SESSION['authorpaperid']=$username;
include 'authorchoice.html';
}
else
die ("Incorrect password");
}
}
else
die ("enter a username and password");
break;
}
case "2":
{ 
if($username && $password )
{

$query=mysql_query("SELECT password, track FROM loginorganizer WHERE loginid='$username'");
$nrows=mysql_num_rows($query);
if($nrows!=1)
{
die ("User does not exist");
}
else
{	
$row = mysql_fetch_row($query);
//$dbname=$row[0];
$dbpswd=$row[0];
$trak=$row[1];
echo $trak;echo "  ";
if($password==$dbpswd)
{
echo "Login success";
	$_SESSION["track"] = $trak;
    //header("Location: choice.html");
	if ($trak!="ALL")include 'choicetrack.html';
	else include 'choicechair.html';
//$_SESSION['username']=$dbusername;
}
else
die ("Incorrect password");
}
}
else
die ("enter a username and password");
break;
}
}
?>