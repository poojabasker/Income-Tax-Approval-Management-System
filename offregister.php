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

  var code_check = /^[A-Z]{3}[CW][1-9][0-9][0-9]?[0-9]/;
  var codeup = document.getElementById('code').value.toUpperCase();
  var lastcode = codeup.length-1;
  var aotype = codeup.charAt('3');
  var first = wcup.charAt('0');
  if (document.getElementById('code').value == '')
    empty('code','code_error',"AO Code is required.");
  else if (code_check.test(codeup) == false)
    empty('code','code_error');
  else if(first != aotype)
    empty('code','code_error',"AO Type doesn't match Ward/Circle entry.");
  else if(wcup.length == 12 && wcup.charAt('10') != codeup.charAt(lastcode))
    empty('code','code_error',"AO Number doesn't match with Ward/Circle enrty.");
  else if(wcup.length == 14 && wcup.charAt('12') != codeup.charAt(lastcode))
    empty('code','code_error',"AO Number doesn't match with Ward/Circle entry.");
  else
    not_empty('code','code_error');
  
  var pwd_check = /^[a-zA-Z0-9!@#$%^&*+?_ ]{6,20}$/;
   if (document.getElementById('pwd').value == '')
    empty('pwd','pwd_error',"Password is required.");
   else if(document.getElementById('pwd').value.length < 6 || document.getElementById('pwd').value.length > 20)
    empty('pwd','pwd_error',"Password must be 6-20 characters long.");
   else if (pwd_check.test(document.getElementById('pwd').value) == false)
    empty('pwd','pwd_error');
   else
    not_empty('pwd','pwd_error');

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

<body onload="document.form1.code.focus();">

<!---Navbar--->
<section id="nav-bar">
 <nav class="navbar navbar-expand-lg navbar-light">
  <img class="navbar-brand"><img src="logo.png">
  <text class="navbar-brand">e-Tax Officer Register</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="officer.php">BACK</a>
      </li>
    </ul>
  </div>
</nav>
</section>

<!---User Entry Form--->
<div class="login">
<p><font size="4"><b>New officers must register to proceed.</b></font></p>
<form method="POST" onsubmit="return validate()" action="offregistration.php" name="form1" id="form1">

<p><font><b>User Personal Details</b></font></p>

  <label>AO Code:</label><br>
  <input type="text" id="code" name="code" tabindex="-1"><br>
  <div id="code_error"></div><br>

  <label>Full Name:</label><br>
  <input type="text" id="fullname" name="fullname" tabindex="-1"><br>
  <div id="fullname_error"></div><br>

  <label>Email ID:</label><br>
  <input type="text" id="email" name="email" tabindex="-1"><br>
  <div id="email_error"></div><br>

  <label>Password:<font size="2px"> (should be 6-20 characters long and can contain only alaphanumeric, space, !, @, #, $, %, ^, &, *, +, ? and _ characters)</font></label><br>
  <input type="password" id="pwd" name="pwd" tabindex="-1"><br>
  <div id="pwd_error"></div><br>

  <label>Building Name:</label><br>
  <textarea name="bname" rows="5" cols="100" id="bname" placeholder="Format: Building name, Street Name, Area" tabindex="-1"></textarea><br>
  <div id="bname_error"></div><br>

  <label>Ward/Circle:</label><br>
  <input type="text" id="wc" name="wc" placeholder="Format: WARD 1(2)(2) or CIRCLE 1(2)(2)" tabindex="-1"><br>
  <div id="wc_error"></div><br>

  <label>City:</label><br>
  <input type="text" id="city" name="city" tabindex="-1"><br>
  <div id="city_error"></div><br>

  <input type="submit" id="space1" value="Continue" class="btn btn-primary" onclick="window.scrollTo(0,0)" tabindex="-1">
  <a href="officer.php">
  <input type="button" id="space2" value="Cancel" class="btn btn-primary"> 
</a>

</form>

</div>

</body>
</html>