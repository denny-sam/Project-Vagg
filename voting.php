<?php
session_start();
$postId=$_GET['postid'];
$type=$_GET['type'];
$nums=$_GET['nums']*1;
$username=$_SESSION['username'];



$con=new MongoClient();
$db=$con->admin_panel;
$record=$db->all_posts->findOne(array("post_Id"=>$postId));

$postId=$record["post_Id"];
$author=$record["author"];
$title=$record["title"];
$time=$record["time"];
$post_Content=$record["post_Content"];
$upvotes=$record["upvotes"];
$downvotes=$record["downvote"];


$usercon=new MongoClient();
$dbuser=$usercon->$username;


if($type == "upvote")
{
		$upvotes=$nums*1;
		$votediff=($upvotes - $downvotes)*1;
		$modified=array("post_Id" => $postId, "author" => $author, "title" => $title, "time" => $time, "post_Content" => $post_Content, "upvotes" => $upvotes, "downvote" => $downvotes);
		$que=$db->all_posts->update(array("post_Id"=>$postId), $modified);
		$modified2=array("post_Id" => $postId, "vote_diff" => $votediff);
		$que=$db->votecount->update(array("post_Id" => $postId), $modified2);
		
		
		$query= $dbuser->upvoted->findOne(array("post_Id" => $postId));
		if(!$query)
		{
			$dbuser->upvoted->insert(array("post_Id" => $postId));
		}
		else
		{
			$dbuser->upvoted->remove(array("post_Id" => $postId));
		}
}

else if ($type =="downvote")
{
	
		$downvotes=$nums*1;
		$votediff=($upvotes - $downvotes)*1;	
		$modified=array("post_Id" => $postId, "author" => $author, "title" => $title, "time" => $time, "post_Content" => $post_Content, "upvotes" => $upvotes, "downvote" => $downvotes);
		$que=$db->all_posts->update(array("post_Id"=>$postId), $modified);
		$modified2=array("post_Id" => $postId, "vote_diff" => $votediff);
		$que=$db->votecount->update(array("post_Id" => $postId), $modified2);
	
	$query= $dbuser->downvoted->findOne(array("post_Id" => $postId));
		if(!$query)
		{
			$dbuser->downvoted->insert(array("post_Id" => $postId));
		}
		else
		{
			$dbuser->downvoted->remove(array("post_Id" => $postId));
		}
}
	
?>

