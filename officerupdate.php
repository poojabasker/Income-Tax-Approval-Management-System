<?php
session_start();
require_once('dbconnect.php');

$code = $_SESSION['code'];

$q = " SELECT * FROM ASSESSING_OFFICER WHERE ID = '$code' ";
$res = mysqli_query($connection,$q);
$val = mysqli_fetch_array($res);
$fullname = $val['NAME'];
$email = $val['EMAIL'];
$wc = $val['WC'];
$bname = $val['BUILD_NAME'];
$city = $val['CITY'];

$connection->close();
?>

<!DOCTYPE html>
<html>

<head>
<title>e-Tax</title>    
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
</head>

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
  var name_check= /^[A-Za-z ]{2,30}$/;

  if (document.getElementById('fullname').value == '') 
    empty('fullname','fullname_error',"Name is required.");
  else if(name_check.test(document.getElementById('fullname').value) == false)
    empty('fullname','fullname_error');
  else
    not_empty('fullname','fullname_error');

  if (document.getElementById('city').value == '') 
    empty('city','city_error',"City is required.");
  else if(name_check.test(document.getElementById('city').value) == false)
    empty('city','city_error');
  else
    not_empty('city','city_error');

  if (document.getElementById('bname').value == '') 
    empty('bname','bname_error',"Building Name is required.");
  else
    not_empty('bname','bname_error');

  var wcup = document.getElementById('wc').value.toUpperCase();
  var wc_check = /^[WARDCILE]{4,6} [0-9]\([0-9]\)\([0-9]\)$/;
  if (document.getElementById('wc').value == '') 
    empty('wc','wc_error',"Ward/Circle is required.");
  else if(wc_check.test(wcup) == false)
    empty('wc','wc_error');
  else
    not_empty('wc','wc_error');

  var email_check = /^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9]+[.][a-zA-Z]{2,3}$/;
  if (document.getElementById('email').value == '')
    empty('email','email_error',"Email ID is required.");
  else if (email_check.test(document.getElementById('email').value) == false)
    empty('email','email_error',"Invalid entry.");
  else
    not_empty('email','email_error');

  if(flag == 1)
    return false;
  else 
    return true;
}
</script> 

<body onload="document.form1.fullname.focus();">

<!---Navbar--->
<section id="nav-bar">
 <nav class="navbar navbar-expand-lg navbar-light">
  <img class="navbar-brand"><img src="logo.png">
  <text class="navbar-brand">e-Tax Officer Update</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <text class="nav-link" href="userloginlinks.php"><?php echo $code; ?></text>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="officerloginlinks.php">BACK</a>
      </li>
    </ul>
  </div>
</nav>
</section>

<!---User Entry Form--->
<div class="login">
<p><font size="4"><b>Edit Personal Details.</b></font></p>
<form method="POST" onsubmit="return validate()" action="offupdate.php" name="form1" id="form1">

  <label>Full Name:</label><br>
  <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" tabindex="-1"><br>
  <div id="fullname_error"></div><br>

  <label>Email ID:</label><br>
  <input type="text" id="email" name="email" value="<?php echo $email; ?>" tabindex="-1"><br>
  <div id="email_error"></div><br>

  <label>Building Name:</label><br>
  <input type="text" name="bname" id="bname" value="<?php echo $bname; ?>" placeholder="Format: Building name, Street Name, Area" tabindex="-1"></textarea><br>
  <div id="bname_error"></div><br>

  <label>Ward/Circle:</label><br>
  <input type="text" id="wc" name="wc" value="<?php echo $wc; ?>" placeholder="Format: WARD 1(2)(2) or CIRCLE 1(2)(2)" tabindex="-1"><br>
  <div id="wc_error"></div><br>

  <label>City:</label><br>
  <input type="text" id="city" name="city" value="<?php echo $city; ?>" tabindex="-1"><br>
  <div id="city_error"></div><br>

  <input type="submit" id="space1" value="Continue" class="btn btn-primary" onclick="window.scrollTo(0,0)" tabindex="-1">
  <a href="officerloginlinks.php">
  <input type="button" id="space2" value="Cancel" class="btn btn-primary"> 
</a>

</form>

</div>

</body>
</html>