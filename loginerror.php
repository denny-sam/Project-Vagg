<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once("setup.php");
if (loggedIn())
	header('Location:main.php');

?>



<!DOCTYPE html>
<html lang="en">
<head> <title>Vagg- Note your thought, on a wall</title>
<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css"/>
<link rel="stylesheet" href="index.css"/>
<link rel="stylesheet" href="fonts.css"/>
<script type="text/javascript" src="jquery-2.1.4.min.js"></script>

<script>
	$(document).ready(function(){
		$('#login-label').click(function(){
			$('.enclose').css('display','block');
			$('#login').css('display','block');
		});
		
		$('#signup-label').click(function(){
			$('.enclose').css('display','block');
			$('#signup').css('display','block');
		});
		
		$('.close').click(function(){
			$('.enclose').css('display','none');
			$('#login').css('display','none');
			$('#signup').css('display','none');
			
		});
	});
	
	
	
</script>

<style>
	
	h2{
		color:white;
		font-size: 35px;
		position:relative;
		top:30%;
		font-family:intro;
	}
	</style>
</head>

<body>
	
		<div id="site-intro">
		<?php
	if($_GET)
	{
	if($_GET['type']==login)
	{
	Echo "<h2>Seems like you have input some wrong credintials! Try again</h2>";
	}
	else{
		Echo "<h2>Oops! Seems like the username is already taken. Try again</h2>";
	}
	}
	else
	{
		header("location:index.php");
	}




?>
		</div>

<br>
<div id="login-label">
<h4>Log In</h4>
</div>
<div id="signup-label">
<h4>Sign Up</h4>
</div>

<div class="enclose"></div>
<div id="login" class="form-group pop">
<h1>Log In</h1><span class="glyphicon glyphicon glyphicon-remove close" aria-hidden="true"></span>
<form name="login" method="POST" action="login.php">
<input type="text" name="log_username" placeholder="Username" class="ele"/><br>
<input type="password" name="log_pass" placeholder="Password" class="ele"/><br>
<input type="submit" value="Log In" class="subbut"/>
<br><br>
</form>
</div>




<div id="signup" class="form-group pop">
<h1> Sign Up</h1>
<span class="glyphicon glyphicon glyphicon-remove close" aria-hidden="true"></span>
<form name="signup" method="POST" action="signup.php">

<input type="text" name="sign_username" placeholder=" Username" class="ele"/><br>
<input type="password" name="sign_pass" placeholder=" Password" class="ele"/><br>
<input type="text" name="sign_email" placeholder="Email-ID" class="ele"/><br>
<input type="submit" class="subbut" style="background-color:#145acf" value="Sign Up">
<br><br>
</form>
</div>


</body>
</html>