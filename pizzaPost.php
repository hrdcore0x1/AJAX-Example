<?php
session_start();
include('connect.php');  //$dbLink

//create order or use SESSION orderid
if (!isset($_SESSION['orderid'])){
	$sql = "INSERT INTO csci7136.Order(customer_id, datetime) VALUES (" . $_SESSION['userid'] . ", curdate());";
	$result = mysql_query($sql, $dbLink);
	$orderid = mysql_insert_id();
	$_SESSION['orderid'] = $orderid;
}else{
	$orderid = $_SESSION['orderid'];
}

$crustid = $_POST['crust'];


//create pizza record
$sql = "INSERT INTO csci7136.Pizza(order_id, crust_id, price) VALUES ($orderid, $crustid, 10);";
$result = mysql_query($sql, $dbLink);
$pizzaid = mysql_insert_id();


//see how many toppings we need to verify
$sql = 'SELECT MAX(id) as id from csci7136.Topping;';
$result = mysql_query($sql, $dbLink);
$row = mysql_fetch_object($result);
$maxid = $row->id;

//loop through toppings and add the selected ones to the PizzaTopping table
for ($i=1; $i<=$maxid; $i++){
	if (isset($_POST['Topping' . $i])){
		$sql = "INSERT INTO csci7136.PizzaTopping(pizza_id, topping_id) VALUES ($pizzaid, $i);";
		$result = mysql_query($sql, $dbLink);
		if (!$result) echo mysql_error($dbLink) . "<br />" . $sql . "<br />";

	}
	if (isset($_POST['Topping' . $i . 'Extra'])){
		$sql = "INSERT INTO csci7136.PizzaTopping(pizza_id, topping_id) VALUES ($pizzaid, $i);";
                $result = mysql_query($sql, $dbLink);
		if (!$result) echo mysql_error($dbLink) . "<br />" . $sql . "<br />";

	}
}

if ($_GET['action'] == 'addPizza'){
	include('order.php');
}elseif ($_GET['action'] == 'continue'){
	include('orderExtra.php');
}
?>
