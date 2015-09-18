<?php

$conn=new MongoClient();
$db=$conn->admin_panel;
$all=$db->users_panel->find();

while($all->hasNext())
{
	$curr=$all->next();
	$user=$curr['user_Id'];
	if(!($user=="efrvr2fvwrgf2b wg ccsawbgswj.;'"))
	{
	$conn2=new MongoClient();
	$db2=$conn2->$user;
	$db2->drop();
	echo "$user done<br>";
	}
}

$all=$db->drop();






?>