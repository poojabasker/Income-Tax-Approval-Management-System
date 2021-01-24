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

//Wrong values in form fields
function empty(x,y,z="Invalid entry.")
{
  document.getElementById(x).style.border = "1px solid red";
  document.getElementById(y).style.color="red";
  document.getElementById(y).textContent = z;
  flag=1;
}

//Right values entered in form fields after wrong values
function not_empty(x,y)
{
  document.getElementById(x).removeAttribute('style');
  document.getElementById(y).removeAttribute('style');
  document.getElementById(y).textContent = "";
}

//Form field validations
function validate() 
{
  flag=0;

  var name_check= /^[A-Za-z ]{2,30}$/;

  //Checking first name
  if (document.getElementById('first').value == '') 
    empty('first','first_error',"First Name is required.");
  else if(name_check.test(document.getElementById('first').value) == false)
    empty('first','first_error');
  else
    not_empty('first','first_error');

  //Checking last name
  if (document.getElementById('last').value == '')
    empty('last','last_error',"Last Name is required.");
  else if(name_check.test(document.getElementById('last').value) == false)
    empty('last','last_error');
  else
    not_empty('last','last_error');

  //Checking father's name
  if (document.getElementById('fname').value == '')
    empty('fname','fname_error',"Father's Name is required.");
  else if(name_check.test(document.getElementById('fname').value) == false)
    empty('fname','fname_error');
  else
    not_empty('fname','fname_error');

  //Checking DoB
   var dob = new Date(document.getElementById('dob').value);
  if (document.getElementById('dob').value == '')
    empty('dob','dob_error',"Date of Birth is required.");
  else
  {
    var month_diff = Date.now() - dob.getTime();  
    var age_dt = new Date(month_diff);   
    var year = age_dt.getUTCFullYear();  
    var age = year - 1970; 
    if(age<18 || age>120)
      empty('dob','dob_error',"Invalid entry.");
    else
      not_empty('dob','dob_error');
  }
  	

  //Checking address
  if (document.getElementById('addr').value == '')
    empty('addr','addr_error',"Address is required.");
  else
  	not_empty('addr','addr_error');

  //Checking bank name
  if (document.getElementById('bank').value == '')
    empty('bank','bank_error',"Bank's Name is required.");
  else if(name_check.test(document.getElementById('bank').value) == false)
    empty('bank','bank_error');
  else
    not_empty('bank','bank_error');

  //Checking Income
  var income_check = /^[0-9]{3,10}\.?[0-9]{0,2}$/;
  if (document.getElementById('income').value == '')
    empty('income','income_error',"Income is required.");
  else if(income_check.test(document.getElementById('income').value) == false)
    empty('income','income_error');
  else
    not_empty('income','income_error');
  
  //Checking PAN number
  var panup = document.getElementById('pan').value.toUpperCase();
  var f1 = document.getElementById('first').value.charAt('0').toUpperCase();
  var f2 = document.getElementById('last').value.charAt('0').toUpperCase();
  var pan_check = /^[A-Z]{3}[PCHABGJLFT][A-Z][0-9]{3}[1-9][A-Z]$/;
  if (document.getElementById('pan').value == '')
    empty('pan','pan_error',"PAN Number is required.");
  else if (pan_check.test(panup) == false || (panup.charAt('3') == 'P' && panup.charAt('4') != f2) || (panup.charAt('3') != 'P' && panup.charAt('4') != f1))
    empty('pan','pan_error');
  else
    not_empty('pan','pan_error');

  //Checking password
  var pwd_check = /^[a-zA-Z0-9!@#$%^&*+?_ ]{6,20}$/;
   if (document.getElementById('pwd').value == '')
    empty('pwd','pwd_error',"Password is required.");
   else if(document.getElementById('pwd').value.length < 6 || document.getElementById('pwd').value.length > 20)
    empty('pwd','pwd_error',"Password must be 6-20 characters long.");
   else if (pwd_check.test(document.getElementById('pwd').value) == false)
    empty('pwd','pwd_error');
   else
    not_empty('pwd','pwd_error');


  //Checking Bank Account
  var acc_check = /^[0-9]{9,18}$/;
  if (document.getElementById('acc').value == '')
    empty('acc','acc_error',"Account Number is required.");
  else if (acc_check.test(document.getElementById('acc').value) == false)
    empty('acc','acc_error');
  else
    not_empty('acc','acc_error');

  //Checking IFSC Code
  var ifsc_up=document.getElementById('ifsc').value.toUpperCase();
  var ifsc_check = /^[A-Z]{4}[0][0-9]{6}$/;
  if (document.getElementById('ifsc').value == '')
    empty('ifsc','ifsc_error',"IFSC Code is required.");
  else if (ifsc_check.test(ifsc_up) == false)
    empty('ifsc','ifsc_error');
  else
    not_empty('ifsc','ifsc_error');

  //Checking AO Code
  var codeup = document.getElementById('code').value.toUpperCase();
  var code_check = /^[A-Z]{3}[CW][1-9][0-9][0-9]?[0-9]/;
  if (document.getElementById('code').value == '')
    empty('code','code_error',"AO Code is required.");
 else if (code_check.test(codeup) == false)
    empty('code','code_error',"Invalid entry.");
  else
    not_empty('code','code_error');

  //Returning false value for POST method to prevent submitting
  if(flag == 1)
    return false;
  else 
    return true;
}
</script> 

<body onload="document.form1.first.focus();">

<!---Navbar--->
<section id="nav-bar">
 <nav class="navbar navbar-expand-lg navbar-light">
  <img class="navbar-brand"><img src="logo.png">
  <text class="navbar-brand">e-Tax User Register</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="user.php">BACK</a>
      </li>
    </ul>
  </div>
</nav>
</section>

<!---User Entry Form--->
<div class="login">
<p><font size="4"><b>New users must register to proceed.</b></font></p>
<form method="POST" onsubmit="return validate()" action="registration.php" name="form1" id="form1">

<p><font><b>User Personal Details</b></font></p>

  <label>First Name:</label><br>
  <input type="text" id="first" name="first" tabindex="-1"><br>
  <div id="first_error"></div><br>

  <label>Last Name:</label><br>
  <input type="text" id="last" name="last" tabindex="-1"><br>
  <div id="last_error"></div><br>

  <label>PAN Number:</label><br>
  <input type="text" id="pan" name="pan" tabindex="-1"><br>
  <div id="pan_error"></div><br>

  <label>Password:<font size="2px"> (should be 6-20 characters long and can contain only alaphanumeric, space, !, @, #, $, %, ^, &, *, +, ? and _ characters)</font></label><br>
  <input type="password" id="pwd" name="pwd" tabindex="-1"><br>
  <div id="pwd_error"></div><br>

  <label>Gender:</label><br>
  <input type="radio" name="gen" value="M" checked tabindex="-1"> Male<br>
  <input type="radio" name="gen" value="F" tabindex="-1"> Female<br>
  <input type="radio" name="gen" value="O" tabindex="-1"> Other<br><br>

  <label>Date of Birth:</label><br>
  <input type="date" id="dob" name="dob" tabindex="-1"><br>
  <div id="dob_error"></div><br>

  <label>Address:</label><br>
  <textarea name="addr" rows="5" cols="100" id="addr" placeholder="Format: House Number, Street Name, Area, City, Pincode" tabindex="-1"></textarea><br>
  <div id="addr_error"></div><br>

  <label>Father's Full Name:</label><br>
  <input type="text" id="fname" name="father" tabindex="-1"><br>
  <div id="fname_error"></div><br>

  <label>Yearly Income:</label><br>
  <input type="text" id="income" name="income" tabindex="-1"><br>
  <div id="income_error"></div><br>
  
  <label>Residential Status:</label><br>
  <input type="radio" name="res" checked value="ROR" tabindex="-1"> Resident (ROR)<br>
  <input type="radio" name="res" value="RNOR" tabindex="-1"> Not Ordinarily Resident (RNOR)<br>
  <input type="radio" name="res" value="NR" tabindex="-1"> Non-Resident (NR)<br><br>

  <label>Assessment Year: </label>
  <select name="assess" id="assess" tabindex="-1">
    <?php
      for($i = 2000; $i < date('Y')+2; $i++)
        echo '<option value="'.$i.'">'.$i.'</option>';
    ?>
  </select>
  <br><br>

 <p><font><b>User Bank Details</b></font></p>

  <label>Account Number:</label><br>
  <input type="text" id="acc" name="acc" tabindex="-1"><br>
  <div id="acc_error"></div><br>

  <label>Bank Name:</label><br>
  <input type="text" id="bank" name="bank" tabindex="-1"><br>
  <div id="bank_error"></div><br>

  <label>Bank Address:</label><br>
  <textarea name="baddr" rows="5" cols="100" id="baddr" placeholder="Format: Area, City, Pincode" tabindex="-1"></textarea><br><br>

  <label>IFSC Code:</label><br>
  <input type="text" id="ifsc" name="ifsc" tabindex="-1">
  <div id="ifsc_error"></div><br><br>

  <p><font><b>Jurisdiction Details</b></font></p>

  <label>Assessing Officer(AO) Code:</label><br>
  <input type="text" id="code" name="code" tabindex="-1"><br>
  <div id="code_error"></div><br>

  <input type="submit" id="space1" value="Continue" class="btn btn-primary" onclick="window.scrollTo(0,0)" tabindex="-1">
  <a href="user.php">
  <input type="button" id="space2" value="Cancel" class="btn btn-primary"> 
</a>

</form>

</div>

</body>
</html>