

<?php
session_start();
$username=$_SESSION["username"];

$conn=new MongoClient();
$db=$conn->$username;
$follower=$db->followers->find();

while($follower->hasNext())
{
	$curr=$follower->next()["user_Id"];
	if($curr !="empty")
{
?>
<a href="search.php?searchtext=<?php echo $curr; ?>"> <?php echo $curr; ?> </a><br><br>

<?php
}
}
?>