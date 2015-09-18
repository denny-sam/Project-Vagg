<?php
session_start();
$username=$_SESSION["username"];

$conn=new MongoClient();
$db=$conn->$username;
$following=$db->following->find();

while($following->hasNext())
{
$curr=$following->next()["user_Id"];
if ($curr != "empty")
{
?>
<a href="search.php?searchtext=<?php echo $curr; ?>"> <?php echo $curr; ?> </a><br><br>

<?php
}}
?>