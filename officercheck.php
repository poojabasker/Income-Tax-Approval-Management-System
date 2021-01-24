<?php

session_start();

require_once('dbconnect.php');

$code = mysqli_real_escape_string($connection,  $_POST['code']);
$pwd = mysqli_real_escape_string($connection, $_POST['pwd']);

//querying the db
$q1 = " SELECT * FROM ASSESSING_OFFICER WHERE ID = '$code' ";
$res1 = mysqli_query($connection, $q1);

//checking if there is a result
if(mysqli_num_rows($res1) == 1)
{
	$q2 = " SELECT * FROM ASSESSING_OFFICER WHERE ID = '$code' AND AO_PWD = '$pwd' ";
	$res2 = mysqli_query($connection, $q2);
	if(mysqli_num_rows($res2) == 1)
	{
		$_SESSION['code']=$code;
		header('Location: officerloginlinks.php');
		exit();
	}
	else 
	  echo '<script>alert("Password doesn\'t match the AO Code entered!");window.location = window.history.back() </script>';
}
else
{
	echo "<script> alert('AO Code not found. Redirecting to register form.');window.location='offregister.php' </script>";
	exit();
}

$connection->close();

?>