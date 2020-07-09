<?php
session_start();

require("db_connect.php");

$sql = "update players set playResult = 'win' where playMatchId = {$_SESSION['match_id']} and playUserId = {$_SESSION['user_id']}";
$result = $conn->query($sql);
if ($result) {
	$sql = "update players set playResult = 'lose' where playMatchId = {$_SESSION['match_id']} and playUserId != {$_SESSION['user_id']}";

	$result = $conn->query($sql);

	$sql = "update matches set mStatus = 'done' where mId = {$_SESSION['match_id']}";

	$result = $conn->query($sql);
}


?>
