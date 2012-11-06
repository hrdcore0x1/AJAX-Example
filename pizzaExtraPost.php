<?php
session_start();
include('connect.php');  //$dbLink

$orderid = $_SESSION['orderid'];


//see how many extras we need to verify
$sql = 'SELECT MAX(id) as id from csci7136.Extra;';
$result = mysql_query($sql, $dbLink);
if (!$result) echo mysql_error($dbLink) . "<br />" . $sql . "<br />";

$row = mysql_fetch_object($result);
$maxid = $row->id;

//loop through toppings and add the selected ones to the PizzaTopping table
for ($i=1; $i<=$maxid; $i++){
	if (isset($_POST['Extra' . $i])){
		$sql = "INSERT INTO csci7136.OrderExtra(order_id, extra_id) VALUES ($orderid, $i);";
		$result = mysql_query($sql, $dbLink);
		if (!$result) echo mysql_error($dbLink) . "<br />" . $sql . "<br />";
	}
}

if ($_GET['action'] == 'addExtra'){
	include('orderExtra.php');
}elseif ($_GET['action'] == 'finish'){
	include('orderReview.php');
}
else{
	echo "PROBLEM!!";
}
?>
