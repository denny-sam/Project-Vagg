<?php
	header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once("functions.php");
session_start();
if (!loggedIn())
	header("location: index.php");

$username=$_SESSION["username"];

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

<?php

$user_conn= new MongoClient();
$user_db=$user_conn->$username;

$posts=$user_db->posts_home->find()->sort(array("time" => -1));
if (!($posts->hasNext())){
	echo "<h1 id='noposts'> Seems like your wall is empty.<br> Follow people to populate it!</h1>";
}

while($posts->hasNext())
{
	$post=$posts->next();
	$postId= $post["post_Id"];
	$isUpvoted=$user_db->upvoted->findOne(array("post_Id" => $postId));
	$isDownvoted=$user_db->downvoted->findOne(array("post_Id" => $postId));
	

	if($postId!="empty")
	{
		$post= retrievePost($postId);
		$ui=new MongoClient();
		$auth=$post['author'];
		$db1=$ui->$auth;
		$qu=$db1->profilepic->findOne();
		$profilepic="imageupload/uploads/".$qu['pic'];
		
		?>
		<div class="post">
		<div class="avatar"><img src='<?php echo $profilepic;?>' class='avatar' style="position:relative; left:2px;top:2px; height:55px; width:55px; box-shadow:0px 0px 0px; border:0px;"></div>
				
		<div class="content">
		<div class="title"><h2><b>
		<?php echo $post['title'];?>
		</b>
		</h2>
		</div>
		<hr/>
		<h5>By <a href="search.php?searchtext=<?php echo $post['author'];?>"> <?php echo $post['author'];?></a></h5>
		<div class="time" style="top:-10px"><?php echo $post['time']; ?></div>
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
		
		</div>
		</div>
		</div>
		
		<?php
	}
}
?>



</div>

</body>
</html>









