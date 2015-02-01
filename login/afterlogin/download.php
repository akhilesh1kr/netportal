<?php
if(isset($_GET['id'])) 
{
$con=mysql_connect("localhost", "root","") or die("Can not Connect");
mysql_select_db('raecs_mk',$con) or die("Could not Connect");
$id   = $_GET['id'];
$query = "SELECT filename, filetype, filesize, filecontent FROM authors WHERE paperid = '$id'";
$result = mysql_query($query) or die('Error, query failed');
list($name, $type, $size, $content) =  mysql_fetch_array($result);
header("Content-length: $size");
header("Content-type: $type");
header("Content-Disposition: attachment; filename=$name");
echo $content;
}
?>