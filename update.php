<?php

session_start();
require_once('dbconnect.php');

$pan = $_SESSION['pan'];
$assess1 = $_SESSION['assess1'];

$first = mysqli_real_escape_string($connection, $_POST['first']);
$last = mysqli_real_escape_string($connection, $_POST['last']);
$gen = mysqli_real_escape_string($connection, $_POST['gen']);
$dob = mysqli_real_escape_string($connection, $_POST['dob']);
$addr = mysqli_real_escape_string($connection, $_POST['addr']);
$father = mysqli_real_escape_string($connection, $_POST['father']);
$res = mysqli_real_escape_string($connection, $_POST['res']);
$assess = (int) mysqli_real_escape_string($connection, $_POST['assess']);
$income = mysqli_real_escape_string($connection, $_POST['income']);
$acc = (double) mysqli_real_escape_string($connection, $_POST['acc']);
$bank = mysqli_real_escape_string($connection, $_POST['bank']);
$baddr = mysqli_real_escape_string($connection, $_POST['baddr']);
$ifsc = mysqli_real_escape_string($connection, $_POST['ifsc']);
$bid = mysqli_real_escape_string($connection, $_POST['bid']);
$code = mysqli_real_escape_string($connection, $_POST['code']);

$q1 = " UPDATE BANK_DETAILS SET ACC_NO='$acc', BANK_NAME='$bank', ADDR='$baddr', IFSC='$ifsc' WHERE BANK_ID = '$bid' " ;
$q2 =  " UPDATE TAX_PAYER SET FNAME='$first', LNAME='$last', ADDRESS='$addr', GENDER='$gen', FATHER_NAME='$father', DOB='$dob',ID='$code' WHERE PAN_NO = '$pan' ";
$q3 = " UPDATE INCOME_TAX SET RES='$res', INCOME='$income', ASSESS_YEAR='$assess', FLAG = NULL WHERE PAN_NO = '$pan' ";
$q4 = " SELECT STATUS FROM PAYMENT WHERE PAN_NO = '$pan' AND ASSESS_YEAR = '$assess' ";

if(mysqli_query($connection,$q1) && mysqli_query($connection,$q2))
{
    $res1 = mysqli_query($connection,$q4);
    if(mysqli_num_rows($res1) == 1)
    {
      $status = mysqli_fetch_array($res1)['STATUS'];

      if($status == 'DISAPPROVED')
        $f = 1;
      else
        $f = 2;

      $q5 = " UPDATE INCOME_TAX SET RES='$res', INCOME='$income', ASSESS_YEAR='$assess', FLAG='$f' WHERE PAN_NO = '$pan' ";
      if(mysqli_query($connection,$q5))
        echo "<script> alert('Updation Successful!');window.location='userupdate.php' </script>";
    }
    else if(mysqli_query($connection,$q3))
        echo "<script> alert('Updation Successful!');window.location='userupdate.php' </script>";
}

$connection->close();

?>