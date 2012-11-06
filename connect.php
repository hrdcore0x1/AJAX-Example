<?php



//connect to server, then test for failure



	if(!($dbLink = mysql_connect("db_url", "user", "password")))

	{

		print("Failed to connect to the database!<br /> Aborting!<br/>\n");

		print("MySQL reports: " . mysql_error() . "<br />\n");

		exit();

	}



//select database, then test for failure



	if(!mysql_select_db("csci7136", $dbLink))

	{

		print("Can't use the database!<br />Aborting! <br />\n");

		print("MySQL reports: " . mysql_error() . "<br />\n");

		exit();

	}

?>

