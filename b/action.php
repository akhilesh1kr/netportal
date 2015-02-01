<?php>
session_start();
$title=$_POST['Title'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$affli=$_POST['affli'];
$edu=$_POST['edu'];
$keywords=$_POST['keywords'];
$paptitle=$_POST['paptitle'];
$track=$_POST['track'];
$authnames=$_POST['names'];
$password=$_POST['password'];

if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
$fileName = $_FILES['userfile']['name'];
$tmpName  = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];

$fp      = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

if(!get_magic_quotes_gpc())
{
    $fileName = addslashes($fileName);
}
$con=mysql_connect("localhost", "root","") or die("Can not Connect");
mysql_select_db('raecs_mk',$con) or die("Could not Connect");
$query=mysql_query("INSERT INTO authors (title,fname,lname,email,mobile,affli,edu,keywords,track,authnames,paptitle,filename, filesize, filetype, filecontent)
VALUES ('$title','$fname','$lname','$email','$mobile','$affli','$edu','$keywords','$track','$authnames','$paptitle','$fileName', '$fileSize', '$fileType', '$content')");
$primary=mysql_insert_id();
$query=mysql_query("INSERT INTO loginauthor(loginid,password,email)
VALUES ('$primary','$password','$email')");
/*switch ($track) {
    case "CSE":
        $query=mysql_query("INSERT INTO cse (paperid,keywords,filename, filesize, filetype, filecontent)
		VALUES ('$primary','$keywords','$fileName', '$fileSize', '$fileType', '$content')");
        break;
    case "ECE":
        $query=mysql_query("INSERT INTO ece (paperid,keywords,filename, filesize, filetype, filecontent)
		VALUES ('$primary','$keywords','$fileName', '$fileSize', '$fileType', '$content')");
        break;
    case "MECH":
        $query=mysql_query("INSERT INTO mech (paperid,keywords,filename, filesize, filetype, filecontent)
		VALUES ('$primary','$keywords','$fileName', '$fileSize', '$fileType', '$content')");
        break;
	case "EE":
        $query=mysql_query("INSERT INTO ee (paperid,keywords,filename, filesize, filetype, filecontent)
		VALUES ('$primary','$keywords','$fileName', '$fileSize', '$fileType', '$content')");
        break;	
	case "SCI":
        $query=mysql_query("INSERT INTO sciences (paperid,keywords,filename, filesize, filetype, filecontent)
		VALUES ('$primary','$keywords','$fileName', '$fileSize', '$fileType', '$content')");
        break;    
}*/
//if(!$query) echo "Error, query failed"; 
if(mysql_affected_rows()!=1) echo "Error, query failed"; 
else {
	echo "<br>File $fileName uploaded, paper submitted successfully<br>";
	echo "<br>Username (Paper-ID): $primary<br>";
	echo "<br>Password is: $password<br>";
	echo "<br>Remember your details for future use, as you will be able to see the decision of your paper after login only<br>";
	}

}
?>


