<!DOCTYPE html>
<html>
<head>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
include_once("functions.php");
if (!loggedIn())
	header("Location: index.php");

$username=$_SESSION["username"];
$connection=new MongoClient();
$datab=$connection->$username;
$pp=$datab->profilepic->findOne();
$profilepic='imageupload/uploads/'.$pp['pic'];



		
?>


	<title><?php echo $username ?>'s Wall</title>
	<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="fonts.css"/>
	<link rel="stylesheet" href="home.css"/>
	<script src="jquery-2.1.4.min.js"></script>
	<script src='jquery.min.js'></script>
	<script src='jquery.form.js'></script>
<script type="text/javascript">
	$(document).ready(function()
		{
			$('#menu').height($(document).height());
			$('.above').bind('click',upload);
			
			
            $('#photoimg').live('change', function()			{ 
			           $("#preview").html('');
			    $("#preview").html('<img src="loader.gif" alt="Uploading...." style="height:19px"/>');
			$("#imageform").ajaxForm({
						target: '#preview'
		}).submit();
		
			});

		});
	
	function upload()
	{
		$('#photoimg').trigger('click');
	}
	
	
</script>
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
	<li><a href="new_post.php"><div class="n ellipse"><img src="Icons/White/newpost.png"/></div></a></li>
	<li><a href="main.php"><div class="h ellipse"><img src="Icons/White/home.png"/></div></a></li>
	<li><a href="profile.php"><div class="p ellipse"><img src="Icons/White/profile.png"/></div></a></li>
	<li><a href="trending.php"><div class="t ellipse"><img src="Icons/White/trending.png"/></div></a></li>
	<li><a href="logout.php"><div class="l ellipse"><img src="Icons/White/logout.png"/></div></a></li>
</ul>	
</div>
<div class="cover">
	<div class="above">Change Pic</div>
	<div class="dp" id="preview">
		<img src='<?php echo $profilepic ?>'class='dp'  style='position:relative; top:0px; left:0px' >
	</div>
	<form name='imageform' id='imageform' action="imageupload/ajaximage.php" method="post">
	<input type="file" name="photoimg" id="photoimg" style="opacity:0"/>
	</form> 
	</div>	
<div class="container"><br><br>
<?php

$user_conn=new MongoClient();
$user_db=$user_conn->$username;
$posts=$user_db->posts_own->find()->sort(array("Snum" => -1));
if (!($posts->hasNext())){
	echo "<h1 id='noposts' style='top:50%;left:8%'>Submit some posts.<br> It will show up here!</h1>";

}


while($posts->hasNext())
{
	$postId= $posts->next()["post_Id"];
	if($postId!="empty")
	{
		$post= retrievePost($postId);
		$upvotes=$post['upvotes'];
		$downvotes=$post['downvote'];
		?>
		<div class="post">
		<div class="content">
		<div class="title"><h2><b>
		<?php echo $post['title'];?>
		</b>
		</h2>
		</div>
		<hr/>
		<div class="time"><?php echo $post['time']; ?></div>
		<div class="para"><p>
		<?php echo $post['post_Content'];echo "<br>"; ?></p>
		</div>
		<br>
		
		<div class="votes">
		<div class="numups"><?php echo $upvotes ?></div><button class="butupvote" ><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button><button class="butdownvote"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button><div class="numdowns"><?php echo $downvotes ?></div>	
		</div>
		
		</div></div>

		<?php
	}

}



			


?>
</div>
</body>
</html>





