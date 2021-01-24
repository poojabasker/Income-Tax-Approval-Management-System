<?php

session_start();
require_once('dbconnect.php');

$first = mysqli_real_escape_string($connection, $_POST['first']);
$last = mysqli_real_escape_string($connection, $_POST['last']);
$pan = mysqli_real_escape_string($connection, $_POST['pan']);
$pwd = mysqli_real_escape_string($connection, $_POST['pwd']);
$gen = mysqli_real_escape_string($connection, $_POST['gen']);
$dob = mysqli_real_escape_string($connection, $_POST['dob']);
$addr = mysqli_real_escape_string($connection, $_POST['addr']);
$father = mysqli_real_escape_string($connection, $_POST['father']);
$res = mysqli_real_escape_string($connection, $_POST['res']);
$income = mysqli_real_escape_string($connection, $_POST['income']);
$assess = (int) mysqli_real_escape_string($connection, $_POST['assess']);
$acc = mysqli_real_escape_string($connection, $_POST['acc']);
$bank = mysqli_real_escape_string($connection, $_POST['bank']);
$baddr = mysqli_real_escape_string($connection, $_POST['baddr']);
$ifsc = mysqli_real_escape_string($connection, $_POST['ifsc']);
$code = mysqli_real_escape_string($connection, $_POST['code']);

$q1 = " SELECT PAN_NO FROM TAX_PAYER WHERE PAN_NO = ? LIMIT 1 ";
$q2 = " INSERT INTO TAX_PAYER (PAN_NO,ACC_NO,ID,FNAME,LNAME,ADDRESS,GENDER,FATHER_NAME,DOB,PWD) VALUES (?,?,?,?,?,?,?,?,?,?) ";
$q3 = " SELECT ACC_NO FROM BANK_DETAILS WHERE ACC_NO = ? LIMIT 1 ";
$q4 = " INSERT INTO BANK_DETAILS (ACC_NO,BANK_NAME,ADDR,IFSC) VALUES (?,?,?,?) ";
$q5 = " INSERT INTO INCOME_TAX (PAN_NO,RES,INCOME,ASSESS_YEAR) VALUES (?,?,?,?) ";

$st1 = $connection->prepare($q1);
$st1->bind_param("s",$pan);
$st1->execute();
$st1->store_result();

$st2 = $connection->prepare($q3);
$st2->bind_param("s",$acc);
$st2->execute();
$st2->store_result();

if($st1->num_rows == 0 && $st2->num_rows == 0)
{
	$st1->close();
	$st2->close();

	$st2 = $connection->prepare($q4);
	$st2->bind_param("ssss", $acc, $bank, $baddr, $ifsc);
	$st2->execute();

	$st1 = $connection->prepare($q2);
	$st1->bind_param("ssssssssss", $pan, $acc, $code, $first, $last, $addr, $gen, $father, $dob, $pwd);
	$st1->execute();

	$st1 = $connection->prepare($q5);
	$st1->bind_param("sssi", $pan, $res, $income, $assess);
	$st1->execute();

	$_SESSION['pan'] = $pan;

	echo "<script> alert('Registration Successful!');window.location='userloginlinks.php' </script>"; 
}

else if($st1->num_rows != 0)
	echo "<script> alert('PAN Number already exists.');window.location = window.history.back() </script>";

else
	echo "<script> alert('Account Number already exists.');window.location = window.history.back() </script>";

$st1->close();
$st2->close();
$connection->close();

?>