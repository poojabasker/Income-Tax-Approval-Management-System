<?php
session_start();
require_once('dbconnect.php');

$pan = $_SESSION['pan'];
$q = " SELECT a.ID FROM ASSESSING_OFFICER a, TAX_PAYER t WHERE t.PAN_NO = '$pan' AND a.ID = t.ID ";
$res = mysqli_query($connection,$q);
if(mysqli_num_rows($res)==0)
  echo "<script> alert('AO not found. Please check AO Code entered or try again later.'); window.location='userloginlinks.php' </script>";
else
{
  $q1 = " SELECT FLAG FROM INCOME_TAX WHERE PAN_NO = '$pan' ";
  $res1 = mysqli_query($connection,$q1);
  $flag = mysqli_fetch_array($res1)['FLAG'];
  if($flag != NULL)
     echo "<script> alert('Entry already exists for given assessment year.'); window.location='userloginlinks.php' </script>";

  $q2 = " SELECT ASSESS_YEAR,FLAG FROM INCOME_TAX WHERE PAN_NO = '$pan' LIMIT 1 ";
  $res2 = mysqli_query($connection,$q2);
  $assess = mysqli_fetch_array($res2)['ASSESS_YEAR'];

  $_SESSION['assess']=$assess;
}
$connection->close();
?>

<html>

<head>
<title>e-Tax</title>    
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>

<script>

var flag;

function empty(x,y,z="Invalid entry.")
{
  document.getElementById(x).style.border = "1px solid red";
  document.getElementById(y).style.color="red";
  document.getElementById(y).textContent = z;
  flag=1;
}

function not_empty(x,y)
{
  document.getElementById(x).removeAttribute('style');
  document.getElementById(y).removeAttribute('style');
  document.getElementById(y).textContent = "";
}

function validate() 
{
  flag=0;

  var tax_check = /^[0-9]{3,10}\.?[0-9]{0,2}$/;
  if (document.getElementById('tax').value == '')
    empty('tax','tax_error',"Amount of tax paid is required.");
  else if(tax_check.test(document.getElementById('tax').value) == false)
    empty('tax','tax_error');
  else
    not_empty('tax','tax_error');

  if (document.getElementById('dop').value == '')
    empty('dop','dop_error',"Date of Payment is required.");
  else
    not_empty('dop','dop_error');

  var evcup = document.getElementById('evc').value.toUpperCase();
  var evc_check = /^[1-9][A-Z]{5}[0-9]{4}$/;
  if (document.getElementById('evc').value == '')
    empty('evc','evc_error',"Electronic Verification Code is required.");
  else if(evc_check.test(evcup) == false)
    empty('evc','evc_error');
  else
    not_empty('evc','evc_error');

  var ip_check = /^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
  if (document.getElementById('ip').value == '')
    empty('ip','ip_error',"IP Address is required.");
  else if(ip_check.test(document.getElementById('ip').value) == false)
    empty('ip','ip_error');
  else
    not_empty('ip','ip_error');

  if(flag == 1)
    return false;
  else 
    return true;
}

</script>

</head>

<body onload="document.form1.tax.focus();">

<section id="nav-bar">
 <nav class="navbar navbar-expand-lg navbar-light">
  <img class="navbar-brand"><img src="logo.png">
  <text class="navbar-brand">e-Tax User Payment</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <text class="nav-link"><?php echo $pan; ?></text>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="userloginlinks.php">BACK</a>
      </li>
    </ul>
  </div>
</nav>
</section>

<div class="login">
<p><font><b>Please enter Payment Details for the assessment year <font color='red' size='5'><?php echo $assess;?></font>.</b></font></p>
<p><font size='2'>
<li>Please enter details as in acknowledgement generated after payment.</li>
<li>Assessment year can be changed in personal details.</li>
<li>Changes to the entered data can be made only when payment has been disapproved.</li>
<li>Approval status will be updated within 3-4 days after application is sent for approval.</li></font></p>

<form method="POST" onsubmit="return validate()" action="paymentinsert.php" name="form1"> 

  <br><label>Tax Amount Paid:</label><br>
  <input type="text" id="tax" name="tax" tabindex="-1"><br>
  <div id="tax_error"></div><br>

  <label>Electronic Verification Code:</label><br>
  <input type="text" id="evc" name="evc" tabindex="-1"><br>
  <div id="evc_error"></div><br>

  <label>Date of Payment:</label><br>
  <input type="date" id="dop" name="dop" tabindex="-1"><br>
  <div id="dop_error"></div><br>

  <label>IP-Address:</label><br>
  <input type="text" id="ip" name="ip" tabindex="-1"><br>
  <div id="ip_error"></div><br>

   <input type="submit" id="space1" value="Continue" class="btn btn-primary" tabindex="-1">
  <a href="userloginlinks.php">
  <input type="button" id="space2" value="Cancel" class="btn btn-primary" tabindex="-1"> 
  </a>

</form>
</div>

</body>
</html>