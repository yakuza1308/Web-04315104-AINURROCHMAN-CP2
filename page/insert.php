<?php
	include "../connection.php";
	$table = $_POST["table"];
	$field = $_POST["field"];
	$value = $_POST["value"];
	$sql = 'INSERT INTO '.$table.' '.$field.' VALUES '.$value.";";

	if ($conn->query($sql) === TRUE) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
?>