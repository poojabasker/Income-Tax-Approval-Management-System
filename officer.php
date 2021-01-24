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

<script>


var flag;

//Wrong values in form fields
function empty(x,y,z)
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

  var codeup = document.getElementById('code').value.toUpperCase();
  var code_check = /^[A-Z]{3}[CW][1-9][0-9][0-9]?[0-9]/;

  if (document.getElementById('code').value == '')
    empty('code','code_error',"AO Code is required.");
 else if (code_check.test(codeup) == false)
    empty('code','code_error',"Invalid entry.");
  else
    not_empty('code','code_error');

  var pwd_check = /^[a-zA-Z0-9!@#$%^&*_ ]{6,20}$/;
   if (document.getElementById('pwd').value == '')
    empty('pwd','pwd_error',"Password is required.");
   else if(document.getElementById('pwd').value.length < 6 || document.getElementById('pwd').value.length > 20)
    empty('pwd','pwd_error',"Password must be 6-20 characters long.");
   else if (pwd_check.test(document.getElementById('pwd').value) == false)
    empty('pwd','pwd_error',"Password can contain only alphanumeric, space, !, @, #, $, %, ^, &, *, +, ? and _ characters.");
   else
    not_empty('pwd','pwd_error');

  if(flag == 1)
    return false;
  else 
    return true;
}
</script> 

</head>

<body onload="document.form1.code.focus();">
<section id="nav-bar">
 <nav class="navbar navbar-expand-lg navbar-light">
  <img class="navbar-brand"><img src="logo.png">
    <text class="navbar-brand">e-Tax Officer</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="user.php">TAX PAYER</a>
      </li>
   </ul>
  </div>
</nav>
</section>

<div class="login">
<p><font><b>Please enter your details.</b></font></p>

<form method="POST" onsubmit="return validate()" action="officercheck.php" name="form1"> 

  <label>AO Code:</label><br>
  <input type="text" id="code" name="code" tabindex="-1"><br>
  <div id="code_error"></div><br>

  <label>Password:</label><br>
  <input type="password" id="pwd" name="pwd" tabindex="-1"><br>
  <div id="pwd_error"></div><br>

   <input type="submit" id="space1" value="Continue" class="btn btn-primary" tabindex="-1">
  <a href="officer.php">
  <input type="button" id="space2" value="Cancel" class="btn btn-primary" onclick="window.location.reload()" tabindex="-1"> 
  </a>

</form>

<a href="offregister.php"><u>New Officer? Click here to register</u></a>
</div>

</body>
</html>