<!DOCTYPE html>
<html>
<head>
<?php

session_start();
include_once("../functions.php");
if (!loggedIn())
	header("Location: ../index.php");

$username=$_SESSION["username"];
$profilepic="uploads/".$username.".png";

?>

<title><?php echo $username; ?></title>


<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.form.js"></script>

<script type="text/javascript">
 $(document).ready(function() { 
		$('#up').click(function(){$('#photoimg').trigger('click');});
            $('#photoimg').live('change', function()			{ 
			           $("#preview").html('');
			    $("#preview").html('<img src="loader.gif" alt="Uploading...."/>');
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});
        }); 
</script>
<link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="../fonts.css"/>
	<link rel="stylesheet" href="../home.css"/>
</head>



<body>
<div class="header">
<h1 class="site-name">VAGG <span class="intro">Your wall</span></h1>

<div id="search">
<form name="search" method="GET" action="search.php" class="form-inline">

<input type="text" id="searchbox" name="searchtext" placeholder="Search for a user..."><button class="searchbutton"><span class="glyphicon glyphicon-search"></span></button>
<input type="submit" name="search" value="search" style="display:none"></form>
</div></div>
	
<div id="menu">
<ul>
	<li><a href="new_post.php"><div class="n ellipse"><img src="../Icons/White/newpost.png"/></div></a></li>
	<li><a href="main.php"><div class="h ellipse"><img src="../Icons/White/home.png"/></div></a></li>
	<li><a href="profile.php"><div class="p ellipse"><img src="../Icons/White/profile.png"/></div></a></li>
	<li><a href="trending.php"><div class="t ellipse"><img src="../Icons/White/trending.png"/></div></a></li>
	<li><a href="logout.php"><div class="l ellipse"><img src="../Icons/White/logout.png"/></div></a></li>
</ul>	
</div>



<div style="width:600px;position:relative; left:500px; top:150px">

<form id="imageform" method="post" enctype="multipart/form-data" action='ajaximage.php'><input type="file" name="photoimg" id="photoimg" style="opacity:0"/>
</form>
<button class="btn btn-primary" style="position:relative; top:110px" id="up">Upload Image</button>
<div id='preview' class="dp">
	<img src='<?php echo $profilepic; ?>'>
</div>


</div>
</body>
</html>