<?php

function loggedIn()
{
	if($_SESSION["username"]!='')
		return true;
	else
		return false;
}


function checkLogin($username, $password)
{
	global $userscoll;
	if ($request=$userscoll->findOne(array("user_Id"=>$username, "password"=>$password)))
	{
		if ($request)
			return true;
		else
			return false;
	}
}


function sessionCreate($username, $password)
{
	session_start();
	$_SESSION["username"]=$username;
	$_SESSION["password"]=$password;
	$_SESSION["loggedIn"]='yes';

}

function checkExisting($username)
{
	global $userscoll;
	if ($request=$userscoll->findOne(array("user_Id"=>$username)))
	{
		if ($request)
			return true;
		else 
			return false;
	}
}

function signUpUser($username, $password, $emailId)
{
	global $userscoll;
	$newUser=array("user_Id"=>$username, "password"=>$password, "email_Id"=>$emailId);

	$userscoll->insert($newUser);

}


function randomize()
{
	$rand1= rand(0,2000);
	$rand1%=25;
	$rand2= rand(0,2000);
	$rand2%=25;
	$rand3= rand(0,2000);
	$rand3%=25;
	
	$alpha=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	$rand1=$alpha[$rand1];
	$rand2=$alpha[$rand2];
	$rand3=$alpha[$rand3];
	$rand4=rand(11111,32222);
	$rand5=rand(11111,32222);
	$random="$rand1$rand2$rand3$rand4$rand5";
	return $random;
}


function retrievePost($postId)
{
	$conn=new MongoClient();
	$db=$conn->admin_panel;
	$doc= $db->all_posts->findOne(array("post_Id" => $postId));
	return $doc;

}

function follow($user_Id)
{
	if ($_SESSION["username"] != $user_Id)
	{
		
		$conn=new MongoClient();
		$username=$_SESSION["username"];
		$db=$conn->$username;
		

		$doc= $db->following->find()->sort(array("Snum" => -1));
		$great=$doc->getNext();
		$greatest=$great["Snum"] + 1;

		$update= $db->following->insert(array("Snum" => $greatest, "user_Id" => $user_Id));


		$conn1=new MongoClient();
		$db1=$conn1->$user_Id;

		$doc= $db1->followers->find()->sort(array("Snum" => -1));
		$great=$doc->getNext();
		$greatest=$great["Snum"] + 1;

		$update= $db1->followers->insert(array("Snum" => $greatest, "user_Id" => $username));
		$homeposts=$db1->posts_own->find();

		while($homeposts->hasNext())
		{
			$posts=$homeposts->Next();
			$Snum=$posts["Snum"];
			$author=$user_Id;
			$time=$posts["time"];
			$postId=$posts["post_Id"];

			$post=array("Snum" => $Snum, "author" => $author, "time" => $time, "post_Id" => $postId);

			$insert=$db->posts_home->insert($post);
		}

		

		return true;
	}

}

function unfollow($user_Id)
{
	if ($_SESSION["username"] != $user_Id)
	{

		$conn=new MongoClient();
		$username=$_SESSION["username"];
		$db=$conn->$username;

		$update= $db->following->remove(array("user_Id" => $user_Id));


		$remove=$db->posts_home->remove(array("author" => $user_Id));
		


		$conn1=new MongoClient();
		$db1=$conn1->$user_Id;

		$update= $db1->followers->remove(array("user_Id" => $username));
		return true;
	}

}


?>