<?php
session_start();

$orderid = $_SESSION['orderid'];
unset($_SESSION['orderid']);

include("connect.php");

$sql = "SELECT id FROM Pizza WHERE order_id=$orderid";

$pizzaResult = mysql_query($sql, $dbLink);
if (mysql_num_rows($pizzaResult) > 0) echo "<h1 style=\"text-decoration:underline;\">Pizza</h1>";
$totalPrice = 0;
while ($row = mysql_fetch_object($pizzaResult)){
	$pizzaid = $row->id;
	$sql = "select topping, crust, Pizza.price as pizzaPrice, Crust.price as crustPrice, Topping.price as toppingPrice from csci7136.Pizza LEFT JOIN csci7136.PizzaTopping ON (Pizza.id = PizzaTopping.pizza_id) LEFT JOIN csci7136.Crust ON (crust_id=Crust.id) LEFT JOIN csci7136.Topping ON (PizzaTopping.topping_id = Topping.id) where Pizza.id=$pizzaid;";
	$result = mysql_query($sql, $dbLink);
	$pizzaRow = mysql_fetch_object($result);
	$pizza =  $pizzaRow -> crust;
	if ($pizzaRow->topping != null) $pizza .= " with ";
	$pizza .= $pizzaRow -> topping . ', ';
	$thisPrice = 0;
	$thisPrice += $pizzaRow->pizzaPrice + $pizzaRow->toppingPrice + $pizzaRow->crustPrice;
	while ($pizzaRow = mysql_fetch_object($result)){
		$pizza .= $pizzaRow -> topping . ', ';
		$thisPrice += $pizzaRow->toppingPrice;
	}
	$pizza = substr($pizza, 0, strlen($pizza)-2) . " $" . sprintf('%2.2f',$thisPrice);
	$totalPrice += $thisPrice;
	echo "$pizza<br />";
}


$sql = "SELECT extra_id FROM csci7136.OrderExtra WHERE order_id=$orderid";
$extraResult = mysql_query($sql, $dbLink);
if (mysql_num_rows($extraResult) > 0) echo "<h1 style=\"text-decoration:underline;\">Extras</h1>";
while($row=mysql_fetch_object($extraResult)){
	$extraid = $row->extra_id;
	$sql = "SELECT extra, price FROM csci7136.Extra WHERE id = $extraid";
	$result = mysql_query($sql, $dbLink);
	if (!$result) echo mysql_error($dbLink);
	while ($extraRow = mysql_fetch_object($result)){
		echo $extraRow->extra . " " . sprintf('%2.2f',$extraRow->price) . "<br />";
		$totalPrice += $extraRow->price;
	}
}

echo "<br /><br />";
echo "Subtotal: " . sprintf('%2.2f',$totalPrice) . "<br />";
$tax= ($totalPrice * .08);
echo "Tax: " . sprintf('%2.2f',$tax) . "<br />";
$totalPrice += $tax;
echo "<span id=\"total\">Total: $" . sprintf('%2.2f',$totalPrice) . "</span>";
?>
