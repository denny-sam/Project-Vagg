<?php
include_once("setup.php");

if ($_POST)
{
	$username=$_POST["sign_username"];
	$password=$_POST["sign_pass"];
	$emailId=$_POST["sign_email"];

	if (checkExisting($username))
	{
		header("location:loginerror.php?type=sign");
	}
	else
	{
		signUpUser($username, $password, $emailId);
		sessionCreate($username, $password);
		header("Location:setup_user.php");

	}
}
else 
{
	header("Location:index.php");
}




?>