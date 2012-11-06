<?php
	include('connect.php');  //$dbLink
	echo "<div id=menu>";	
	echo "<h1>Pizza</h1>\n";
	
	$dots = "........................................";
	$base = "Base Price";
	$theseDots = substr($dots, strlen($base));
	$base = $base . $theseDots . "$10.00";
	echo $base . "<br />";
	$sql = "SELECT crust, price FROM Crust order by crust asc;";
	$result = mysql_query($sql, $dbLink);
	echo "<h1>Crust</h1>\n";	
	while ($row = mysql_fetch_object($result)){
		$theseDots = substr($dots, strlen($row->crust));
		echo $row->crust . $theseDots . "$" . sprintf("%2.2f",$row->price) . "<br />\n";
	}
        $sql = "SELECT topping, price FROM Topping order by topping asc;";
        $result = mysql_query($sql, $dbLink);

        echo "<h1>Toppings</h1>\n";
        while ($row = mysql_fetch_object($result)){
		$theseDots = substr($dots, strlen($row->topping));
                echo $row->topping . $theseDots . "$" . sprintf("%2.2f",$row->price) . "<br />\n";
        }
        $sql = "SELECT extra, price FROM Extra order by extra asc;";
        $result = mysql_query($sql, $dbLink);

        echo "<h1>Extras</h1>\n";
        while ($row = mysql_fetch_object($result)){
                $theseDots = substr($dots, strlen($row->extra));
		echo $row->extra . $theseDots . "$" . sprintf("%2.2f",$row->price) . "<br />\n";
        }
?>
</div>
