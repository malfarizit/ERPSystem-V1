<?php
session_start();
if (isset($_SESSION['username'])) {
	
}else{
	header("location:login.php");
}
?>
<?php
session_start();
setcookie();
unset($_SESSION['user']);
session_destroy();
header("location:login.php");
exit;
?>