<?php session_start(); ?>

<div id="order">

<?php
include('connect.php');
if (!isset($_SESSION['userid'])){
	echo "Please log in first.";
	echo "</div>";
	return;
}

echo '<h1>Order: #' . $_SESSION['orderid'] . '</h1>';

?>
<br />
<br />

<h1>Extras</h1>
<div class="clear" />
<form name="pizzaExtra" id="pizzaExtraForm" action="pizzaExtraPost.php" method="POST">
<table>
<?php 

$sql = "SELECT id, extra, price FROM csci7136.Extra;";
$result = mysql_query($sql, $dbLink);
$extraInRow = 0;
while ($row = mysql_fetch_object($result)){
	$price = sprintf("%2.2f",$row->price);
	 $tr = ($extraInRow % 3 == 0) ? "<tr>" : "";
        $slashTr = ($extraInRow % 3 == 2) ? "</tr>" : "";
        $extraInRow++;
	echo "$tr<td class=\"toppingtd\"><input class=\"input\" style=\"text-align: center;\" id=\"Extra" . $row->id . "\" type=\"checkbox\" name=\"Extra" . $row->id . "\">" . $row->extra . "</input></td>$slashTr";

}
?>

</table>
</form>
</div>
<div id="submitWrapper">
<div class="clear" />
<div id="OrderContinue" onClick="orderFinish();">Complete</div>
<div id="AddPizza" onClick="addExtra();">Add More</div>
</div>
