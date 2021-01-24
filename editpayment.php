<?php
session_start();
require_once('dbconnect.php');

$pan = $_SESSION['pan'];
$assess = $_SESSION['assess'];

$q1 = " SELECT * FROM PAYMENT WHERE PAN_NO = '$pan' AND ASSESS_YEAR = '$assess' LIMIT 1 ";
$res1 = mysqli_query($connection,$q1);

if(mysqli_num_rows($res1) == 1)
{
  $q2 = " SELECT FLAG FROM INCOME_TAX WHERE PAN_NO = '$pan' ";
  $res2 = mysqli_query($connection,$q2);
  $flag = mysqli_fetch_array($res2)['FLAG'];

  if($flag == 2)
   echo "<script> alert('Cannot alter APPROVED payment details.'); window.location='userloginlinks.php' </script>";
 else if($flag == 0)
    echo "<script> alert('Cannot alter payment when APPROVAL PENDING.'); window.location='userloginlinks.php' </script>";

 else
 {
    $val = mysqli_fetch_array($res1);
    $tax = $val['TAX_PAID'];
    $evc = $val['EVC'];
    $dop = $val['DATE_PAID'];
    $ip = $val['IP_ADDR'];
 }
}
else
  echo "<script> alert('Payment Details not found for assessment year. Redirecting to payment entry page.');window.location='newpayment.php' </script>";

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
<p><font><b>Edit Payment Details for the assessment year <font color='red' size='5'><?php echo $assess;?></font>.</b></font></p>
<p><font size='2'>
<li>Please enter details as in acknowledgement generated after payment.</li>
<li>You cannot change assessment year or payment year when approval is pending.</li>
<li>Approval status will be updated within 3-4 days after application is sent for approval.</li></font></p>

<form method="POST" onsubmit="return validate()" action="updatepayment.php" name="form1"> 

  <br><label>Tax Amount Paid:</label><br>
  <input type="text" id="tax" name="tax" value="<?php echo $tax; ?>"tabindex="-1"><br>
  <div id="tax_error"></div><br>

  <label>Electronic Verification Code:</label><br>
  <input type="text" id="evc" name="evc" value="<?php echo $evc; ?>" tabindex="-1"><br>
  <div id="evc_error"></div><br>

  <label>Date of Payment:</label><br>
  <input type="date" id="dop" name="dop" value="<?php echo $dop; ?>" tabindex="-1"><br>
  <div id="dop_error"></div><br>

  <label>IP-Address:</label><br>
  <input type="text" id="ip" name="ip" value="<?php echo $ip; ?>" tabindex="-1"><br>
  <div id="ip_error"></div><br>

   <input type="submit" id="space1" value="Continue" class="btn btn-primary" tabindex="-1">
  <a href="userloginlinks.php">
  <input type="button" id="space2" value="Cancel" class="btn btn-primary" tabindex="-1"> 
  </a>

</form>
</div>  

</body>
</html>