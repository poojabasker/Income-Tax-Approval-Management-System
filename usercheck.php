<?php

session_start();

//db connection
require_once('dbconnect.php');

//form values and preventing sql injection
$pan = mysqli_real_escape_string($connection,  $_POST['pan']);
$pwd = mysqli_real_escape_string($connection, $_POST['pwd']);

//querying the db
$q1 = " SELECT * FROM TAX_PAYER WHERE PAN_NO = '$pan' ";
$res1 = mysqli_query($connection, $q1);

//checking if there is a result
if(mysqli_num_rows($res1) == 1)
{
	$q2 = " SELECT * FROM TAX_PAYER WHERE PAN_NO = '$pan' AND PWD = '$pwd' ";
	$res2 = mysqli_query($connection, $q2);
	if(mysqli_num_rows($res2) == 1)
	{
		$_SESSION['pan']=$pan;
		header('Location: userloginlinks.php');
		exit();
	}
	else 
	  echo '<script>alert("Password doesn\'t match the PAN Number entered!");window.location = window.history.back() </script>';
}
else
{
	echo "<script> alert('PAN Number not found. Redirecting to register form.');window.location='register.php' </script>";
	exit();
}

$connection->close();

?>