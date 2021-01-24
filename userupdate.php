<?php
session_start();
require_once('dbconnect.php');

$pan = $_SESSION['pan'];

$q1 = " SELECT * FROM tax_payer WHERE PAN_NO = '$pan' ";
$res1 = mysqli_query($connection,$q1);
$val1 = mysqli_fetch_array($res1);
$pan = $val1['PAN_NO'];
$fname = $val1['FNAME'];
$lname = $val1['LNAME'];
$gen = $val1['GENDER'];
$dob = $val1['DOB'];
$addr = $val1['ADDRESS'];
$father = $val1['FATHER_NAME'];
$code = $val1['ID'];

$q2 = " SELECT * FROM income_tax WHERE PAN_NO = '$pan' ";
$res2 = mysqli_query($connection,$q2);
$val2 = mysqli_fetch_array($res2);
$res = $val2['RES'];
$assess = $val2['ASSESS_YEAR'];
$income = $val2['INCOME'];
$flag = $val2['FLAG'];

$assess1=$assess;
$_SESSION['assess1']=$assess1;

$q3 = " SELECT b.* FROM bank_details b, tax_payer t WHERE t.PAN_NO = '$pan' AND t.ACC_NO = b.ACC_NO ";
$res3 = mysqli_query($connection,$q3);
$val3 = mysqli_fetch_array($res3);
$bid = $val3['BANK_ID'];
$acc = $val3['ACC_NO'];
$bank = $val3['BANK_NAME'];
$baddr = $val3['ADDR'];
$ifsc = $val3['IFSC'];

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

  if (document.getElementById('first').value == '') 
    empty('first','first_error',"First Name is required.");
  else if(name_check.test(document.getElementById('first').value) == false)
    empty('first','first_error');
  else
    not_empty('first','first_error');

  if (document.getElementById('last').value == '')
    empty('last','last_error',"Last Name is required.");
  else if(name_check.test(document.getElementById('last').value) == false)
    empty('last','last_error');
  else
    not_empty('last','last_error');

  if (document.getElementById('fname').value == '')
    empty('fname','fname_error',"Father's Name is required.");
  else if(name_check.test(document.getElementById('fname').value) == false)
    empty('fname','fname_error');
  else
    not_empty('fname','fname_error');

  if (document.getElementById('dob').value == '')
    empty('dob','dob_error',"Date of Birth is required.");
  else
    not_empty('dob','dob_error');

  if (document.getElementById('addr').value == '')
    empty('addr','addr_error',"Address is required.");
  else
    not_empty('addr','addr_error');

  if (document.getElementById('bank').value == '')
    empty('bank','bank_error',"Bank's Name is required.");
  else if(name_check.test(document.getElementById('bank').value) == false)
    empty('bank','bank_error');
  else
    not_empty('bank','bank_error');

  var income_check = /^[0-9]{3,10}\.?[0-9]{0,2}$/;
  if (document.getElementById('income').value == '')
    empty('income','income_error',"Income is required.");
  else if(income_check.test(document.getElementById('income').value) == false)
    empty('income','income_error');
  else
    not_empty('income','income_error');
  
  var acc_check = /^[0-9]{9,18}$/;
  if (document.getElementById('acc').value == '')
    empty('acc','acc_error',"Account Number is required.");
  else if (acc_check.test(document.getElementById('acc').value) == false)
    empty('acc','acc_error');
  else
    not_empty('acc','acc_error');

  var ifsc_up=document.getElementById('ifsc').value.toUpperCase();
  var ifsc_check = /^[A-Z]{4}[0][0-9]{6}$/;
  if (document.getElementById('ifsc').value == '')
    empty('ifsc','ifsc_error',"IFSC Code is required.");
  else if (ifsc_check.test(ifsc_up) == false)
    empty('ifsc','ifsc_error');
  else
    not_empty('ifsc','ifsc_error');

  var codeup = document.getElementById('code').value.toUpperCase();
  var code_check = /^[A-Z]{3}[CW][1-9][0-9][0-9]?[0-9]/;
  if (document.getElementById('code').value == '')
    empty('code','code_error',"AO Code is required.");
 else if (code_check.test(codeup) == false)
    empty('code','code_error',"Invalid entry.");
  else
    not_empty('code','code_error');

  if(flag == 1)
    return false;
  else 
    return true;
}
</script> 

<body onload="document.form1.first.focus();">

<section id="nav-bar">
 <nav class="navbar navbar-expand-lg navbar-light">
  <img class="navbar-brand"><img src="logo.png">
  <text class="navbar-brand">e-Tax User Update</text>
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
<p><font size="4"><b>Update Details</b></font></p>
<p><font size="2">(<b>CANNOT</b> update assessment year when approval for payment is pending.)</font></p>

<form method="POST" onsubmit="return validate()" action="update.php" name="form1" id="form1">

<p><font><b>User Personal Details</b></font></p>

  <label>First Name:</label><br>
  <input type="text" id="first" name="first" value="<?php echo $fname; ?>" tabindex="-1"><br>
  <div id="first_error"></div><br>

  <label>Last Name:</label><br>
  <input type="text" id="last" name="last" value="<?php echo $lname; ?>" tabindex="-1"><br>
  <div id="last_error"></div><br>

  <label>Gender:</label><br>
  <input type="radio" name="gen" value="M" <?php echo ($gen =='M')? 'checked':'' ?> tabindex="-1"> Male<br>
  <input type="radio" name="gen" value="F" <?php echo ($gen =='F')? 'checked':'' ?> tabindex="-1"> Female<br>
  <input type="radio" name="gen" value="O" <?php echo ($gen =='O')? 'checked':'' ?> tabindex="-1"> Other<br><br>

  <label>Date of Birth:</label><br>
  <input type="date" id="dob" name="dob" value="<?php echo $dob; ?>" tabindex="-1"><br>
  <div id="dob_error"></div><br>

  <label>Address:</label><br>
  <textarea name="addr" rows="5" cols="100" id="addr" placeholder="Format: House Number, Street Name, Area, City, Pincode" tabindex="-1"><?php echo $addr; ?></textarea><br>
  <div id="addr_error"></div><br>

  <label>Father's Full Name:</label><br>
  <input type="text" id="fname" name="father" value="<?php echo $father; ?>" tabindex="-1"><br>
  <div id="fname_error"></div><br>

  <label>Yearly Income:</label><br>
  <input type="text" id="income" name="income" value="<?php echo $income; ?>" tabindex="-1"><br>
  <div id="income_error"></div><br>
  
  <label>Residential Status:</label><br>
  <input type="radio" name="res" value="ROR" <?php echo ($res =='ROR')? 'checked':'' ?> tabindex="-1"> Resident (ROR)<br>
  <input type="radio" name="res" value="RNOR" <?php echo ($res =='NROR')? 'checked':'' ?> tabindex="-1"> Not Ordinarily Resident (RNOR)<br>
  <input type="radio" name="res" value="NR" <?php echo ($res =='NR')? 'checked':'' ?> tabindex="-1"> Non-Resident (NR)<br><br>

<?php 
  if($flag==NULL || $flag==2 || $flag==1)
  {
    echo '<label>Assessment Year: </label><select name="assess" id="assess"><option value="'.$assess.'">'.$assess.'</option>';
    for($i = 2000; $i < date('Y')+2; $i++)
      echo '<option value="'.$i.'">'.$i.'</option>';
    echo '</select><br><br>';
  }
?>

 <p><font><b>User Bank Details</b></font></p>

  <label>Account Number:</label><br>
  <input type="text" id="acc" name="acc" value="<?php echo $acc; ?>" tabindex="-1"><br>
  <div id="acc_error"></div><br>

  <label>Bank Name:</label><br>
  <input type="text" id="bank" name="bank" value="<?php echo $bank; ?>" tabindex="-1"><br>
  <div id="bank_error"></div><br>

  <label>Bank Address:</label><br>
  <textarea name="baddr" rows="5" cols="100" id="baddr" placeholder="Format: Area, City, Pincode" tabindex="-1"><?php echo $baddr; ?></textarea><br><br>

  <label>IFSC Code:</label><br>
  <input type="text" id="ifsc" name="ifsc" value="<?php echo $ifsc; ?>" tabindex="-1">
  <div id="ifsc_error"></div><br>

  <input type="hidden" name="bid" value="<?php echo $bid; ?>"><br>

  <p><font><b>Jurisdiction Details</b></font></p>

  <label>Assessing Officer(AO) Code:</label><br>
  <input type="text" id="code" name="code" value="<?php echo $code; ?> "tabindex="-1"><br>
  <div id="code_error"></div><br>

  <input type="submit" id="space1" value="Continue" class="btn btn-primary" onclick="window.scrollTo(0,0)" tabindex="-1">
  <a href="userloginlinks.php">
  <input type="button" id="space2" value="Cancel" class="btn btn-primary"> 
</a>

</form>
</div>

</body>
</html>