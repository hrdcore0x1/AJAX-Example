<?php session_start(); ?>

<div id="order">

<?php
include('connect.php');
if (!isset($_SESSION['userid'])){
	echo "Please log in first.";
	echo "</div>";
	return;
}

if (isset($_SESSION['orderid'])){
	echo '<h1>Order: #' . $_SESSION['orderid'] . '</h1>';
	$sql = "SELECT count(id) as count FROM csci7136.Pizza WHERE order_id = " . $_SESSION['orderid'];
	$result = mysql_query($sql, $dbLink);
	$row = mysql_fetch_object($result);
	$pizzaNum = $row->count;
	$pizzaNum++;
	echo "<h1>Pizza: #$pizzaNum</h1>";

}
else echo '<h1>New Order</h1>';

?>
<br />
<br />

<h1>Pizza Crust</h1>
<div class="clear" />
<form name="pizza" id="pizzaForm" action="pizzaPost.php" method="POST">
<table><tr>
<?php 

$sql = "SELECT id, crust, price FROM Crust;";
$result = mysql_query($sql, $dbLink);

while ($row = mysql_fetch_object($result)){
	$checked = '';
	$price = sprintf("%2.2f",$row->price);
	if ($row->crust == 'Original') $checked = ' checked';

	echo "<td class=\"crusttd\"><input class=\"input\" type=\"radio\" name=\"crust\" value=\"" . $row->id . "\"$checked>" . $row->crust . " ($" . $price . ")</input></td>";	
}
?>
</tr></table>

<h1>Toppings</h1>
<table>
<?
$toppingInRow = 0;
$sql = "SELECT id, topping, price FROM Topping";
$result = mysql_query($sql,$dbLink);
while ($row = mysql_fetch_object($result)){
	$price = sprintf("%2.2f",$row->price);
	$tr = ($toppingInRow % 3 == 0) ? "<tr>" : "";
	$slashTr = ($toppingInRow % 3 == 2) ? "</tr>" : "";
	$toppingInRow++;
	echo "$tr<td class=\"toppingtd\"><input class=\"input\" id=\"Topping" . $row->id . "\" type=\"checkbox\" name=\"Topping" . $row->id  . "\" onclick=\"toggleToppingExtra(" . $row->id . ");\"></input>" . $row->topping . " ($" . $price . ") <br /><input class=\"toppingtdExtra noshow\" type=\"checkbox\" id=\"Topping" . $row->id . "Extra\" name=\"Topping" . $row->id . "Extra\"></input><span id=\"topping" . $row->id . "span\" style=\"padding-left: 65px;\" class=\"toppingtdExtra noshow\">Extra</span></td>$slashTr";

}
?>
</table>
</form>
</div>
<div id="submitWrapper">
<div class="clear" />
<div id="OrderContinue" onClick="orderContinue();">Continue</div>
<div id="AddPizza" onClick="addPizza();">Add Pizza</div>
</div>
