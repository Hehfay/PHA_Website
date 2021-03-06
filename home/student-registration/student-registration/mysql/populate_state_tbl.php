<?php
require_once "global_vars.php";
/* Run this script to populate the state table. */

$file = fopen(".state_tbl_data.txt", 'r') or
die("Failed to open file.\n");

$mysqli = new mysqli($host, $username, $password, $database);
if($mysqli->connect_errno)
{
	echo "php error: $mysqli->connect_errno\n";
}
else
{
	echo "Connection successful!\n";
	$query = "DROP TABLE if EXISTS state;";
	if($result = $mysqli->query($query))
	{
		echo "Dropped state table\n";
	}
	else
	{
		echo "Unable to drop state table\n";
		exit(1);
	}

	$query = "CREATE TABLE state(abbreviation CHAR(2), name VARCHAR(14), PRIMARY KEY(abbreviation)) ENGINE InnoDB;";
	if($result = $mysqli->query($query))
	{
		echo "Created state table\n";
	}
	else
	{
		echo "Unable to create state table\n";
		exit(1);
	}

	for($i = 0; $i < 50; $i++)
	{
		$string = fgets($file);
		$data = explode(" ", $string);
		$count = count($data);

		if($count === 3)
		{
			$name = sprintf("%s %s", $data[0], $data[1]);
			$abbreviation = $data[2];
		}
		elseif($count == 2)
		{
			$name = $data[0];
			$abbreviation = $data[1];
		}
		else
		{
			echo "Problem reading from file!";
			exit(1);
		}

		$query = "INSERT INTO state VALUES('$abbreviation', '$name');";
		if($result = $mysqli->query($query))
		{
			echo "Successfully added to the state table\n";
		}
		else
		{
			echo "Failure to add to the state table\n";
		}
	}
	$mysqli->close();
	$mysqli->free();
}
fclose($file);
?>
