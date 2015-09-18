
<?php

include_once("setup.php");

if(loggedIn())
{
	header('Location:main.php');
}


if ($_POST)
{

	if (checkLogin($_POST["log_username"], $_POST["log_pass"]))
	{
		sessionCreate($_POST["log_username"], $_POST["log_pass"]);
		header('Location:main.php');
	}
	else
	{
		header('Location:loginerror.php?type=login');
	}
}
else
{
	header("Location:index.php");
}





?>