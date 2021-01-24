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
  
  //Checking PAN number
  var panup = document.getElementById('pan').value.toUpperCase();
  var pan_check = /^[A-Z]{3}[PCHABGJLFT][A-Z][0-9]{3}[1-9][A-Z]$/;
  if (document.getElementById('pan').value == '')
    empty('pan','pan_error',"PAN Number is required.");
 else if (pan_check.test(panup) == false)
    empty('pan','pan_error',"Invalid entry.");
  else
    not_empty('pan','pan_error');

  //Checking password
  var pwd_check = /^[a-zA-Z0-9!@#$%^&*_ ]{6,20}$/;
   if (document.getElementById('pwd').value == '')
    empty('pwd','pwd_error',"Password is required.");
   else if(document.getElementById('pwd').value.length < 6 || document.getElementById('pwd').value.length > 20)
    empty('pwd','pwd_error',"Password must be 6-20 characters long.");
   else if (pwd_check.test(document.getElementById('pwd').value) == false)
    empty('pwd','pwd_error',"Password can contain only alphanumeric, space, !, @, #, $, %, ^, &, *, +, ? and _ characters.");
   else
    not_empty('pwd','pwd_error');

  //Returning false value for POST method to prevent submitting
  if(flag == 1)
    return false;
  else 
    return true;
}
</script> 

</head>

<body onload="document.form1.pan.focus();">

 <!---Navbar---> 
<section id="nav-bar">
 <nav class="navbar navbar-expand-lg navbar-light">
  <img class="navbar-brand"><img src="logo.png">
  <text class="navbar-brand">e-Tax User</text>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="officer.php">OFFICER</a>
      </li>
    </ul>
  </div>
</nav>
</section>

<!---User Entry Form--->
<div class="login">
  <p><font><b>Please enter details as in PAN Card.</b></font></p>

<form method="POST" onsubmit="return validate()" action="usercheck.php" name="form1" id="form1"> 

  <label>PAN Number:</label><br>
  <input type="text" id="pan" name="pan" tabindex="-1"><br>
  <div id="pan_error"></div><br>

  <label>Password:</label><br>
  <input type="password" id="pwd" name="pwd" tabindex="-1"><br>
  <div id="pwd_error"></div><br>

  <input type="submit" id="space1" value="Continue" class="btn btn-primary" tabindex="-1">
  <a href="user.php">
  <input type="button" id="space2" value="Cancel" class="btn btn-primary" onclick="window.location.reload()" tabindex="-1"> 
</a>

</form>

<a href="register.php"><u>New User? Click here to register</u></a>
</div>
  

</body>
</html>