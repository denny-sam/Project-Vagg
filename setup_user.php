<?php
session_start();

$username = $_SESSION["username"];
$main= new MongoClient(); 

$db=$main->$username;	
$posts_home=$db->createCollection("posts_home");
$posts_own=$db->createCollection("posts_own");
$following=$db->createCollection("following");
$followers=$db->createCollection("followers");

$upvoted=$db->createCollection("upvoted");
$downvoted=$db->createCollection("downvoted");
$profilepic=$db->createCollection("profilepic");
$req=$db->profilepic->insert(array("pic"=>'default.png'));


header('Location:main.php');
?>
