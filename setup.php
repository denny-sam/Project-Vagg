
<?php
ob_start();
error_reporting(E_ALL);
try
{
$server="localhost";
$dbname="admin_panel";
$userpanel="users_panel";

$main= new MongoClient(); 
$db=$main->$dbname;	


$userscoll=$db->$userpanel;
}
catch (MongoConnectionException $e)
{
  die($e->getMessage());
} 
catch (MongoException $e) {
  die('Error: ' . $e->getMessage());
}

session_start();
if (!isset($_SESSION["username"]))
{
$_SESSION["username"]='';
$_SESSION["password"]='';
$_SESSION["loggedIn"]='no';
}

include_once("functions.php");
?>
