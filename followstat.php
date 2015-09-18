<?php
include_once("functions.php");
session_start();
$searchuser=$_SESSION["searchUser"];


if($_GET)
{
	if($_GET['type']=='follow')
	{
		follow($searchuser);
	}
	else
		unfollow($searchuser);
}

?>