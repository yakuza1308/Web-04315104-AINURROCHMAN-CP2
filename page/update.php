<?php
	include "../connection.php";
	$table = $_POST["table"];
	$set = $_POST["set"];
	$where = $_POST["where"];
	$sql = 'UPDATE '.$table.' SET '.$set.' WHERE '.$where.";";

	if ($conn->query($sql) === TRUE) {
	    echo "Record updated successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
?>