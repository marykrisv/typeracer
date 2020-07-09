<?php
session_start();
$connection = mysqli_connect("localhost","root","","typeracer") or die ("ERROR" .mysqli_error($connection));

$sql = "select * from players where playMatchId = {$_SESSION['match_id']}";
$result = mysqli_query ($connection, $sql) or die ("ERROR" .mysqli_error($connection));

$emparray = array();

while ($row = mysqli_fetch_assoc ($result)) {
	$emparray[] = $row;
}

echo json_encode($emparray);
mysqli_close($connection);
?>
