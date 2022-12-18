<?php
session_start();
?>
<?php


include('config/koneksi.php');


$db = get_db_conn();

$qr = mysql_query("SELECT count(*) FROM users");
$r = mysql_fetch_array($qr);
if($r[0] < 1){ $qr = mysql_query("INSERT INTO users (Employee_id,Name,Password,level) values('38394','Alfarizi','12345','admin') "); }

if(isset($_GET['action']) && $_GET['action']=='logout'){ setcookie('uid','');  setcookie('level',''); }

if(isset($_POST['Employee_id']) && isset($_POST['Password'])){
	$usr = $_POST['Employee_id'];
	$pass= $_POST['Password'];
	$qr = '';
	
	$qr = mysql_query("SELECT count(*) FROM users WHERE Employee_id='".$usr."' and Password = '".$pass."' ");
	$r = mysql_fetch_array($qr);	
	if($r[0] > 0){ setcookie('uid','admin'); setcookie('level','admin'); header('location:index.php'); }
	
	// $qr = mysql_query("SELECT count(*) FROM kasir WHERE kode_kasir='".$usr."' and pass = '".$pass."' ");
	// $r = mysql_fetch_array($qr);
	// if($r[0] > 0){ setcookie('uid',$usr);  setcookie('level','kasir'); header('location:index.php'); }
	
	
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGIN</title>
<link type="text/css" rel="stylesheet" href="css/style-login.css" />
<link type="text/css" rel="stylesheet" href="css/font-face.css" />
<link type="text/css" rel="stylesheet" href="css/1.css" />
<link type="text/css" rel="stylesheet" href="css/animate.css" />

</head>

<body>


<div class="lif">
<div class="liflogo"><img src="img/giken_logo.jpeg"></div>
<form action="" method="post">
	<div class="lifhead">LOGIN PAGE </div>
	
	<p>Employee Id: </p>
	<p><input class="animated fadeInLeft" type="text" id="Employee_id" name="Employee_id" /></p>
    <p>Password:</p> 
    <p><input  class="animated fadeInRight" type="password" id="Password" name="Password" /><p>
    <input type="submit" value="LOGIN" class="animated bounce" />
</form>
</div>


</body>
</html>