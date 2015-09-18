<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once("functions.php");
if ($_SESSION=='null')
header("Location:index.php");

session_start();
$username=$_SESSION["username"];
if($_POST)
{

	$title=$_POST["title"];
	$content=$_POST["content"];
	$author=$_SESSION["username"];
	$date=new MongoDate();
	$date_human=date('Y-M-d h:i:s');

	$main= new MongoClient(); 
	$db=$main->admin_panel;	
	$random=randomize();
	
	$post_Id=$random;
	global $follower;
	$postit=$db->all_posts->insert(array("post_Id"=>$post_Id, "author"=>$author, "title"=>$title, "time"=>$date_human, "post_Content"=>$content, "upvotes" => 0, "downvote" => 0));
	$votecount=$db->votecount->insert(array("post_Id" => $post_Id, "vote_diff" => 0));

	$userm=new MongoClient();
	
	$user_db=$userm->$author;
	$collect=$user_db->posts_own->find()->sort(array("Snum" => -1));
	
	
	$lastpost=$collect->getNext();
	
	$lastpost1=$lastpost["Snum"] + 1;

	
	$postown=$user_db->posts_own->insert(array("Snum" => $lastpost1, "author" => $author, "time" =>$date, "post_Id"=> $post_Id));


	
	
		$followers=$user_db->followers->find();
		
		while($followers->hasNext())
		{

			$follower = $followers->next()["user_Id"];
			$sub=new MongoClient();
			$sub_db=$sub->$follower;

			$Collect=$sub_db->posts_home->find()->sort(array("Snum" => -1));
			
			$lastPost=$Collect->getNext();
			$lastPost1=$lastPost["Snum"] + 1;
			
			$posthome=$sub_db->posts_home->insert(array("Snum" => $lastPost1, "author"=>$author, "time" =>$date, "post_Id" => $post_Id, "isUpvoted" => false, "isDownvoted" => false)); 
			
		}
		
	
	
	

}




?>


<!DOCTYPE html>
<html>
<head>
	<title>New Post</title>
	<link rel="stylesheet" href="bootstrap-3.3.5-dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="home.css"/>
	<link rel="stylesheet" href="fonts.css"/>
	<script type="text/javascript">
	$(function(){$('#menu').height($(window).height());});
	</script>
</head>
<body>
<div class="header">
<h1 class="site-name">VAGG <span class="intro">Post as <?php echo $username; ?></span></h1>

<div id="search">
<form name="search" method="GET" action="search.php" class="form-inline">

<input type="text" id="searchbox" name="searchtext" placeholder="  Search for a user..."><button class="searchbutton"><span class="glyphicon glyphicon-search"></span></button>
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


<div class="container newpost">
<br><br><br><br>

<form name="newPost" action="<?php  echo $_SERVER['PHP_SELF']?>" method="POST">
<div class="form-group">
<textarea rows="1" cols="100" name="title" placeholder="Title of the post" class="form-control"></textarea><br>
</div>
<div class="form-group">
<textarea rows="17" cols="100" name="content" placeholder="Your content goes here..." class="form-control"></textarea>
</div>
<input type="submit" value="Post It!" id="submitpostbutton" class="form-control">

</form>
</div>
</body>
</html>