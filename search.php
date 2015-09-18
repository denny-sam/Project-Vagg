<?php

session_start();
if(isset($_GET))
{
	$userSearch=$_GET["searchtext"];
	$username=$_SESSION["username"];	
	if ($userSearch==$username)
	{
		header("location:profile.php");
	}

	$conn= new MongoClient();
	$db=$conn->admin_panel;
	$req= $db->users_panel->findOne(array("user_Id" => $userSearch));
	
	if ($req)
	{
		$_SESSION["searchUser"]=$userSearch;
		header("Location: searchprofile.php");
	}
	else{
		?>
		
		
		<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
<meta http-equiv="pragma" content="no-cache" />
	<title><?php echo $username; ?></title>
	<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="fonts.css"/>
	<link rel="stylesheet" href="home.css"/>
	<script type="text/javascript" src="jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="voting1.js"></script>
	<script type="text/javascript">
	$(function(){$('#menu').height($(window).height());});

	</script>
<style>
	h1{
		color:white;
		font-size:50px;
		position:relative;
		top:40%;
		text-align:center;
	}
	</style>

</head>

<body>

<div class="header">
<h1 class="site-name">VAGG <span class="intro">Welcome, <?php echo $username; ?></span></h1>
<div id="search">
<form name="search" method="GET" action="search.php" class="form-inline">

<input type="text" id="searchbox" name="searchtext" placeholder="Search for a user..."><button class="searchbutton"><span class="glyphicon glyphicon-search"></span></button>
<input type="submit" name="search" value="search" style="display:none"></form>
</div>
</div>




	
<div id="menu">
<ul>
	<li><a href="new_post.php"><div class="n ellipse"><img src="Icons/White/newpost.png"/></div></a></li>
	<li><a href="main.php"><div class="h ellipse"><img src="Icons/White/home.png"/></div></a></li>
	<li><a href="profile.php"><div class="p ellipse"><img src="Icons/White/profile.png"/></div></a></li>
	<li><a href="trending.php"><div class="t ellipse"><img src="Icons/White/trending.png"/></div></a></li>
	<li><a href="logout.php"><div class="l ellipse"><img src="Icons/White/logout.png"/></div></a></li>
</ul>	
</div>
<div class="container">
<br><br><br>
<h2 id="noposts">Oops! No such user found.</h2>
</div>
</div>
		
		
<?php
	}

}
?>