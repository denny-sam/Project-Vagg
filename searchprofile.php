<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_start();
include_once("functions.php");
$searchUser=$_SESSION["searchUser"];
$username=$_SESSION["username"];
if(!loggedIn())
	header("location:index.php");
	
if($searchUser==$username)
	header('location:profile.php');
	
$connection=new MongoClient();
$datab=$connection->$searchUser;
$pp=$datab->profilepic->findOne();
$profilepic='imageupload/uploads/'.$pp['pic'];
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $searchUser ?>'s Wall</title>
	<script type="text/javascript" src="jquery-2.1.4.min.js"></script>
	<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="home.css"/>
	<link rel="stylesheet" href="fonts.css"/>
	<script type="text/javascript" src="voting1.js"></script>
	<script type="text/javascript">
	$(document).ready(function()
		{
			$('#menu').height($(document).height());
		}
	);
	</script>
	<style>
		#followbutton{
			position:relative;
			top:10%;
			left:90%;
		}	
	</style>
</head>


<body>
<div class="header">
<h1 class="site-name">VAGG <span class="intro"><?php echo $searchUser ?>'s Wall</span></h1>

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
<div class="cover"><div class="dp"><img src='<?php echo $profilepic ?>' class='dp' style="position:relative; top:0; left:0"></div>


<?php

$Conn=new MongoClient();

$DB=$Conn->$searchUser;
$posts=$DB->posts_own->find()->sort(array("Snum" => -1));
$follow=$DB->followers->findOne(array("user_Id" => $username));

//echo $posts->next()["post_Id"];

if ($follow)
{
	echo "<a href='#!' id='followbutton' class='btn btn-danger btn-sm'>Unfollow</a>";
}
else
{
	echo "<a href='#!' id='followbutton' class='btn btn-primary btn-sm'>Follow</a>";
}


while($posts->hasNext())
{

	$postId= $posts->next()["post_Id"];
	if($postId!="empty")
	{

		$post= retrievePost($postId);
		$usercon=new MongoClient();
		$userdb=$usercon->$username;
		$isUpvoted=$userdb->upvoted->findOne(array("post_Id" => $postId));
	$isDownvoted=$userdb->downvoted->findOne(array("post_Id" => $postId));?>
	</div>
<div class="container"><br><br>
<div class="post">

<div class="content">
		<div class="title"><h2><b>
		<?php echo $post['title'];?>
		</b>
		</h2>
		</div>
		<hr/>
		<h5>By <a href="search.php?searchtext=<?php echo $post['author'];?>"> <?php echo $post['author'];?></a></h5>
		<div class="time"><?php echo $post['time']; ?></div>
		<div class="para"><p>
		<?php echo $post['post_Content'];echo "<br>"; ?></p>
		</div>
		<br>
		
		<div class="votes">
		
		<?php 
		$upvotes=$post["upvotes"];
		$downvotes=$post["downvote"];
	
	

		echo "<button class='numups'>$upvotes</button>";
		if (!$isUpvoted)
			{echo "<button class='butupvote' id="; echo $postId; echo  "><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></a> ";  }
		else
			{echo "<button class='butupvote butupvoted' id="; echo $postId;echo "><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></a> "; }
			
		
		if(!$isDownvoted)
			{echo "<button class='butdownvote' id="; echo $postId; echo "><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button> ";}
		else
			{echo "<button class='butdownvote butdownvoted' id="; echo $postId; echo "><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button> ";}
			
		?>
		<button class="numdowns"><?php echo $downvotes ?></button>
		
		</div></div></div>
		






		<?php
	}

}






?>
</div>
</body>
</html>

