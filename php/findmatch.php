<?php
session_start();
require("db_connect.php");

$sql = "select * from matches where mId = {$_SESSION['match_id']} and mStatus = 'playing'";
$result = $conn->query($sql);

foreach ($result as $res) {
	echo 'stop';
}

?>
