<?php
	include "../connection.php";
	$table = $_POST["table"];
	$id = $_POST["id"];
	$sql = 'DELETE FROM '.$table.' WHERE code = '.$id.';';

	if ($conn->query($sql) === TRUE) {
	    echo "Record deleted successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
?>